<?php

class AdminModel
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
            $query = $this->condb->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
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
}
