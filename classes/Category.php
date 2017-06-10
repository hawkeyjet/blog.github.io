<?php

class Category
{
	public $id = null;
	public $name = null;
	public $description = null;

	public function __construct( $data=array() ) {
		if (isset( $data['id']))
			$this->id = (int)$data['id'];
		if (isset( $data['name']))
			$this->name = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9а-яА-Я()]/u", "", $data['name']);
		if (isset( $data['description']))
			$this->description = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9а-яА-Я()]/u", "", $data['description']);
	}

	public function storeFormValues ($params) {
		$this->__construct($params);
	}

	public static function getById($id) {
		include TEMPLATE_PATH . "/include/db.inc.php";
		$sql = "SELECT * FROM categories WHERE id = :id";
		$s = $pdo->prepare($sql);
		$s->bindValue(":id", $id, PDO::PARAM_INT);
		$s->execute();
		$row = $s->fetch();
		$pdo = null;
		if ($row) return new Category($row);
	}

	public static function getList($numRows=1000000, $order="name ASC") {
		include TEMPLATE_PATH . "/include/db.inc.php";
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM categories
						ORDER BY " . $pdo->quote($order) . " LIMIT :numRows";

		$s = $pdo->prepare($sql);
		$s->bindValue(":numRows", $numRows, PDO::PARAM_INT);
		$s->execute();
		$list = array();

		while ($row = $s->fetch()) {
			$category = new Category( $row );
			$list[] = $category;
		}

		$sql = "SELECT FOUND_ROWS() AS totalRows";
		$totalRows = $pdo->query($sql)->fetch();
		$pdo = null;
		return (array("results" => $list, "totalRows" => $totalRows[0]));
	}

	public function insert() {

		if (!is_null($this->id))
			trigger_error("Category::insert(): Попытка вставить категорию, которая имеет установленное свойство ($this->id).", E_USER_ERROR);

		include TEMPLATE_PATH . "/include/db.inc.php";
		$sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
		$s = $pdo->prepare ($sql);
		$s->bindValue(":name", $this->name, PDO::PARAM_STR);
		$s->bindValue(":description", $this->description, PDO::PARAM_STR);
		$s->execute();
		$this->id = $pdo->lastInsertId();
		$pdo = null;
	}

	public function update() {
		if (is_null($this->id))
			trigger_error ("Category::update(): Попытка вставить категорию которая не имеет id.", E_USER_ERROR);

		include TEMPLATE_PATH . "/include/db.inc.php";
		$sql = "UPDATE categories SET name=:name, description=:description WHERE id = :id";
		$s = $pdo->prepare ($sql);
		$s->bindValue(":name", $this->name, PDO::PARAM_STR);
		$s->bindValue(":description", $this->description, PDO::PARAM_STR);
		$s->bindValue(":id", $this->id, PDO::PARAM_INT);
		$s->execute();
		$pdo = null;
	}

	public function delete() {
		if (is_null($this->id))
			trigger_error ("Category::delete(): Попытка удалить категорию которая не имеет id.", E_USER_ERROR);

		include TEMPLATE_PATH . "/include/db.inc.php";
		$s = $pdo->prepare ("DELETE FROM categories WHERE id = :id LIMIT 1");
		$s->bindValue(":id", $this->id, PDO::PARAM_INT);
		$s->execute();
		$pdo = null;
	}

}