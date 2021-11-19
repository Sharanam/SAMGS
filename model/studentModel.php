<?php

class StudentModel
{
	function __construct($consetup)
	{
		$this->host = $consetup->host;
		$this->user = $consetup->user;
		$this->pass =  $consetup->pass;
		$this->db = $consetup->db;
	}

	public function open_db()
	{
		$this->condb = new mysqli($this->host, $this->user, $this->pass, $this->db);
		if ($this->condb->connect_error) {
			die("Error in connection: " . $this->condb->connect_error);
		}
	}

	public function close_db()
	{
		$this->condb->close();
	}

	public function insert($obj)
	{
		try {
			$this->open_db();
			$query = $this->condb->prepare("INSERT INTO students (name,password,email,address,age) VALUES (?, ?, ?, ?, ?)");
			$query->bind_param("ssssi", $obj->name, $obj->password, $obj->email, $obj->address, $obj->age);
			if (!$query->execute()) {
				return false;
			}
			$query->get_result();
			$query->close();
			$this->close_db();
			return true;
		} catch (Exception $e) {
			$this->close_db();
			throw $e;
		}
	}

	public function find($obj)
	{
		try {
			$this->open_db();
			$query = $this->condb->prepare("SELECT * FROM students WHERE email = ? AND password = ?");
			$query->bind_param("ss", $obj->email, $obj->password);
			$query->execute();
			$res = $query->get_result();
			if (!empty($res)) {
				$query->close();
				$this->close_db();
				return $res;
			}
		} catch (Exception $e) {
			$this->close_db();
			throw $e;
		}
	}

	public function findData($email)
	{
		try {
			$this->open_db();
			$query = $this->condb->prepare("SELECT * FROM students WHERE email = ? ");
			$query->bind_param("s", $email);
			$query->execute();
			$res = $query->get_result();
			if (!empty($res)) {
				$query->close();
				$this->close_db();
				return $res;
			}
		} catch (Exception $e) {
			$this->close_db();
			throw $e;
		}
	}

	public function update($obj)
	{
		try {
			$this->open_db();
			$query = $this->condb->prepare("UPDATE students SET name = ?, address = ?, age = ?, class = ?, section = ? WHERE email = ?");
			$query->bind_param("ssiiss", $obj->name, $obj->address, $obj->age, $obj->class, $obj->section, $obj->email);
			if (!$query->execute()) {
				return false;
			}
			$query->close();
			$this->close_db();
			return true;
		} catch (Exception $e) {
			$this->close_db();
			return false;
		}
	}
}
