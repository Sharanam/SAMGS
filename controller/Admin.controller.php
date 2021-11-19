<?php
require_once 'model/admin.php';
require_once 'model/adminModel.php';
require_once 'config.php';

class AdminController
{
    function __construct()
    {
        $this->config = new Config();
        $this->admin =  new AdminModel($this->config);
    }

    public function handler()
    {
        $act = isset($_GET['act']) ? $_GET['act'] : NULL;
        switch ($act) {
            case 'login':
                $this->login();
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
                $obj = new Admin();
                $obj->email = $_POST["email"];
                $obj->password = md5($_POST["password"]);
                $result = $this->admin->find($obj);
                $res = $result->fetch_assoc();
                $session = array("email" => $res["email"], "type" => "admin");
                if ($res) {
                    $_SESSION["userDetails"] = json_encode($session);
                    Controller::dashboard();
                } else {
                    $_SESSION["errorMessage"] = "credentials do not match";
                    Controller::pageRedirect('view/admin.php');
                }
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            Controller::pageRedirect('view/admin.php');
        }
    }
}
