<?php

class HistoryModel
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
            $query = $this->condb->prepare("INSERT INTO history (student_email,advisor_email,description) VALUES (?, ?, ?)");
            $query->bind_param("sss", $obj->student_email, $obj->advisor_email, $obj->description);
            if (!$query->execute()) {
                return false;
            }
            $res = $query->get_result();
            $query->close();
            $this->close_db();
            return true;
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

    public function findByAdvisor($advisor_email)
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("SELECT * FROM history WHERE advisor_email = ?");
            $query->bind_param("s", $advisor_email);
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

    public function findByStudent($student_email)
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("SELECT * FROM history WHERE student_email = ?");
            $query->bind_param("s", $student_email);
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

    public function findAll()
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("SELECT * FROM history");
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
