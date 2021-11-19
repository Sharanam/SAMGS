<?php
require_once 'model/advisor.php';
require_once 'model/advisorModel.php';
require_once 'config.php';

class AdvisorController
{
    function __construct()
    {
        $this->config = new Config();
        $this->advisor =  new AdvisorModel($this->config);
    }

    public function handler()
    {
        $act = isset($_GET['act']) ? $_GET['act'] : NULL;
        switch ($act) {
            case 'login':
                $this->login();
                break;
            case 'getAll':
                $this->getAll();
                break;
            case 'logout':
                Controller::logout();
                break;
            case 'dashboard':
                Controller::dashboard();
                break;
            default:
                Controller::landing();
        }
    }

    public function login()
    {
        if (isset($_POST['login'])) {
            try {
                $obj = new Advisor();
                $obj->email = $_POST["email"];
                $obj->password = md5($_POST["password"]);
                $result = $this->advisor->find($obj);
                $res = $result->fetch_assoc();
                $session = array("name" => $res["name"], "email" => $res["email"], "type" => "advisor");
                if ($res) {
                    $_SESSION["userDetails"] = json_encode($session);
                    Controller::dashboard();
                } else {
                    $_SESSION["errorMessage"] = "credentials do not match";
                    Controller::pageRedirect('view/advisor.php');
                }
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            Controller::pageRedirect('view/advisor.php');
        }
    }

    public function getAll()
    {
        try {
            $result = $this->advisor->findAll();
            if ($result) {
                echo json_encode(array("res" => 1, "data" => $result));
            } else {
                echo json_encode(array("res" => 0));
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
