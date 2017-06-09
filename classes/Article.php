<?php

class Article
{
	public $id = null;
	public $publicationDate = null;
	public $title = null;
	public $summary = null;
	public $content = null;
	public $imageExtension = "";

	public function __construct($data=array()) {
		if (isset($data['id']))
			$this->id = (int)$data['id'];
		if (isset( $data['publicationDate']))
			$this->publicationDate = (int)$data['publicationDate'];
		if (isset($data['title']))
			$this->title = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9а-яА-Я]()/u", "", $data['title']);
		if (isset($data['summary']))
			$this->summary = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9а-яА-Я]()]/u", "", $data['summary']);
		if (isset($data['content']))
			$this->content = $data['content'];
		if (isset($data['imageExtension']))
			$this->imageExtension = preg_replace("/[^\.\,\-\_\'\"\@\?\!\$ a-zA-Z0-9а-яА-Я()]/u", "", $data['imageExtension']);
	}

	public function storeFormValues($params) {
		$this->__construct($params);

		if (isset($params['publicationDate'])) {
			$publicationDate = explode ('-', $params['publicationDate']);

			if (count($publicationDate) == 3) {
				list($y, $m, $d) = $publicationDate;
				$this->publicationDate = mktime(0, 0, 0, $m, $d, $y);
			}
		}
	}

	public function storeUploadedImage($image) {
		if ($image['error'] == UPLOAD_ERR_OK) {

			if (is_null($this->id))
				trigger_error("Article::storeUploadedImage(): Попытка загрузить изображение для статьи, у которой нет идентификатора.", E_USER_ERROR);

			$this->deleteImages();
			$this->imageExtension = strtolower(strrchr($image['name'], '.'));
			$tempFilename = trim($image['tmp_name']);

			if (is_uploaded_file($tempFilename)) {
				if (!(move_uploaded_file($tempFilename, $this->getImagePath())))
					trigger_error("Article::storeUploadedImage(): Не удалось переместить загруженный файл.", E_USER_ERROR);
				if (!(chmod($this->getImagePath(), 0666)))
					trigger_error( "Article::storeUploadedImage(): Не удалось установить привилегии для загруженного файла.", E_USER_ERROR );
			}

			$attrs = getimagesize($this->getImagePath());
			$imageWidth = $attrs[0];
			$imageHeight = $attrs[1];
			$imageType = $attrs[2];

			switch ($imageType) {
				case IMAGETYPE_GIF:
					$imageResource = imagecreatefromgif($this->getImagePath());
					break;
				case IMAGETYPE_JPEG:
					$imageResource = imagecreatefromjpeg($this->getImagePath());
					break;
				case IMAGETYPE_PNG:
					$imageResource = imagecreatefrompng($this->getImagePath());
					break;
				default:
					trigger_error("Article::storeUploadedImage(): Необработанный или неизвестный тип изображения($imageType)", E_USER_ERROR);
			}

			$thumbHeight = intval($imageHeight / $imageWidth * ARTICLE_THUMB_WIDTH);
			$thumbResource = imagecreatetruecolor(ARTICLE_THUMB_WIDTH, $thumbHeight);
			imagecopyresampled($thumbResource, $imageResource, 0, 0, 0, 0, ARTICLE_THUMB_WIDTH, $thumbHeight, $imageWidth, $imageHeight);

			switch ($imageType) {
				case IMAGETYPE_GIF:
					imagegif($thumbResource, $this->getImagePath(IMG_TYPE_THUMB));
					break;
				case IMAGETYPE_JPEG:
					imagejpeg($thumbResource, $this->getImagePath(IMG_TYPE_THUMB), JPEG_QUALITY);
					break;
				case IMAGETYPE_PNG:
					imagepng ( $thumbResource, $this->getImagePath( IMG_TYPE_THUMB ) );
					break;
				default:
					trigger_error ("Article::storeUploadedImage(): Необработанный или неизвестный тип изображения($imageType)", E_USER_ERROR);
			}

			$this->update();
		}
	}

	public function deleteImages() {
		foreach (glob( ARTICLE_IMG_PATH . "/" . IMG_TYPE_FULLSIZE . "/" . $this->id . ".*") as $filename) {
			if (!unlink($filename))
				trigger_error("Article::deleteImages(): Не могу удалить изображение.", E_USER_ERROR);
		}

		foreach (glob(ARTICLE_IMG_PATH . "/" . IMG_TYPE_THUMB . "/" . $this->id . ".*") as $filename) {
			if (!unlink($filename))
				trigger_error("Article::deleteImages(): Не могу удалить миниатюру.", E_USER_ERROR);
		}

		$this->imageExtension = "";
	}

	public function getImagePath($type=IMG_TYPE_FULLSIZE) {
		return ($this->id && $this->imageExtension) ? ( ARTICLE_IMG_PATH . "/$type/" . $this->id . $this->imageExtension) : false;
	}

	public static function getById($id) {
		try {
			include TEMPLATE_PATH . "/include/db.inc.php";
			$sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE id = :id";
			$s = $pdo->prepare($sql);
			$s->bindValue( ":id", $id, PDO::PARAM_INT );
			$s->execute();
			$row = $s->fetch();
			$pdo = null;
		} catch (PDOException $e) {
			echo 'Ошибка в Article::getById($id)';
			error_log($e->getMessage());
		}
		if ($row) return new Article($row);
	}

	public static function getList($numRows=1000000, $order="publicationDate DESC") {
		try {
			include TEMPLATE_PATH . "/include/db.inc.php";
			$sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles
							ORDER BY " . $pdo->quote($order) . " LIMIT :numRows";

			$s = $pdo->prepare($sql);
			$s->bindValue(":numRows", $numRows, PDO::PARAM_INT);
			$s->execute();
			$list = array();

			while ($row = $s->fetch()) {
				$article = new Article($row);
				$list[] = $article;
			}

			$sql = "SELECT FOUND_ROWS() AS totalRows";
			$totalRows = $pdo->query($sql)->fetch();
			$pdo = null;
		} catch (PDOException $e) {
			echo 'Ошибка в Article::getList($numRows, $order)';
			error_log($e->getMessage());
		}
		return (array("results" => $list, "totalRows" => $totalRows[0]));
	}

	public function insert() {
		if (!is_null( $this->id))
			trigger_error ("Article::insert(): Попытка вставить статью, у которой есть идентификатор ($this->id).", E_USER_ERROR);
		try {
			include TEMPLATE_PATH . "/include/db.inc.php";
			$sql = "INSERT INTO articles (publicationDate, title, summary, content, imageExtension) VALUES (FROM_UNIXTIME(:publicationDate), :title, :summary, :content, :imageExtension)";
			$s = $pdo->prepare($sql);
			$s->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
			$s->bindValue(":title", $this->title, PDO::PARAM_STR);
			$s->bindValue(":summary", $this->summary, PDO::PARAM_STR);
			$s->bindValue(":content", $this->content, PDO::PARAM_STR);
			$s->bindValue(":imageExtension", $this->imageExtension, PDO::PARAM_STR);
			$s->execute();
			$this->id = $pdo->lastInsertId();
			$pdo = null;
		} catch (PDOException $e) {
			echo 'Ошибка в Article::insert()';
			error_log($e->getMessage());
		}
	}

	public function update() {
		if (is_null($this->id))
			trigger_error("Article::update(): Попытка обновить статью, у которой нет идентификатора.", E_USER_ERROR);

		try {
			include TEMPLATE_PATH . "/include/db.inc.php";
			$sql = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate), title=:title, summary=:summary, content=:content, imageExtension=:imageExtension WHERE id = :id";
			$s = $pdo->prepare ($sql);
			$s->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
			$s->bindValue(":title", $this->title, PDO::PARAM_STR);
			$s->bindValue(":summary", $this->summary, PDO::PARAM_STR);
			$s->bindValue(":content", $this->content, PDO::PARAM_STR);
			$s->bindValue(":imageExtension", $this->imageExtension, PDO::PARAM_STR);
			$s->bindValue(":id", $this->id, PDO::PARAM_INT);
			$s->execute();
			$pdo = null;
		} catch (PDOException $e) {
			echo 'Ошибка в Article::update()';
			error_log($e->getMessage());
		}
	}

	public function delete() {
		if (is_null($this->id))
			trigger_error ("Article::delete(): Попытка удалить статью, у которой нет идентификатора.", E_USER_ERROR);

		try {
			include TEMPLATE_PATH . "/include/db.inc.php";
			$s = $pdo->prepare ( "DELETE FROM articles WHERE id = :id LIMIT 1" );
			$s->bindValue( ":id", $this->id, PDO::PARAM_INT );
			$s->execute();
			$pdo = null;
		} catch (PDOException $e) {
			echo 'Ошибка в Article::delete()';
			error_log($e->getMessage());
		}
	}

}