<?php

class AppointmentModel
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
            $query = $this->condb->prepare("INSERT INTO appointment (student_email,advisor_email,description,status) VALUES (?, ?, ?, ?)");
            $query->bind_param("ssss", $obj->student_email, $obj->advisor_email, $obj->description, $obj->status);
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
            $query = $this->condb->prepare("SELECT * FROM appointment WHERE advisor_email = ?");
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
            $query = $this->condb->prepare("SELECT * FROM appointment WHERE student_email = ?");
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
            $query = $this->condb->prepare("SELECT * FROM appointment");
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

    public function matchStudentAndId($student_email, $id)
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("SELECT * FROM appointment WHERE student_email = ? AND id = ?");
            $query->bind_param("si", $student_email, $id);
            $query->execute();
            $res = $query->get_result();
            $result = $res->fetch_assoc();
            if ($result) {
                $query->close();
                $this->close_db();
                return $result;
            }
            return false;
        } catch (Exception $e) {
            $this->close_db();
            return false;
        }
    }

    public function update($obj)
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("UPDATE appointment SET status = ? WHERE student_email = ? AND id = ?");
            $query->bind_param("ssi", $obj->status, $obj->student_email, $obj->id);
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
