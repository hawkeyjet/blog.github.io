<?php

class Article
{
	public $id = null;
	public $publicationDate = null;
	public $title = null;
	public $summary = null;
	public $content = null;

	public function __construct($data=array()) {
		if (isset( $data['id']))
			$this->id = (int) $data['id'];
		if (isset( $data['publicationDate']))
			$this->publicationDate = (int)$data['publicationDate'];
		if (isset($data['title']))
			$this->title = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title']);
		if (isset($data['summary']))
			$this->summary = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['summary']);
		if (isset( $data['content']))
			$this->content = $data['content'];
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

	public static function getById($id) {
		try {
			$pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
			$pdo->exec("SET NAMES 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE id = :id";
			$s = $pdo->prepare( $sql );
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
			$pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
			$pdo->exec("SET NAMES 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
			$pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
			$pdo->exec("SET NAMES 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO articles (publicationDate, title, summary, content) VALUES (FROM_UNIXTIME(:publicationDate), :title, :summary, :content)";
			$s = $pdo->prepare ($sql);
			$s->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
			$s->bindValue(":title", $this->title, PDO::PARAM_STR);
			$s->bindValue(":summary", $this->summary, PDO::PARAM_STR);
			$s->bindValue(":content", $this->content, PDO::PARAM_STR);
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
			$pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
			$pdo->exec("SET NAMES 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate), title=:title, summary=:summary, content=:content WHERE id = :id";
			$s = $pdo->prepare ($sql);
			$s->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
			$s->bindValue(":title", $this->title, PDO::PARAM_STR);
			$s->bindValue(":summary", $this->summary, PDO::PARAM_STR);
			$s->bindValue(":content", $this->content, PDO::PARAM_STR);
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
			$pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
			$pdo->exec("SET NAMES 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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