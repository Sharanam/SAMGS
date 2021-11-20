<?php

class AdvisorModel
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

    public function find($obj)
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("SELECT * FROM advisor WHERE email = ? AND password = ?");
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

    public function findByEmailAndAvailability($email, $availability)
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("SELECT * FROM advisor WHERE email = ? AND availability = ?");
            $query->bind_param("si", $email, $availability);
            $query->execute();
            $res = $query->get_result();
            $result = $res->fetch_assoc();
            if ($result) {
                $query->close();
                $this->close_db();
                return true;
            }
            return false;
        } catch (Exception $e) {
            $this->close_db();
            return false;
        }
    }

    public function findAll()
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("SELECT email, name, availability FROM advisor");
            $query->execute();
            $result = $query->get_result();
            $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $query->close();
            $this->close_db();
            return $array;
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }
}
