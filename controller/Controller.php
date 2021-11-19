<?php
require_once 'controller/Student.controller.php';
require_once 'controller/Admin.controller.php';
require_once 'controller/Advisor.controller.php';

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

class Controller
{

    function __construct()
    {
        $this->studentController = new StudentController();
        $this->adminController = new AdminController();
        $this->advisorController = new AdvisorController();
    }

    public function mvcHandler()
    {
        $type = isset($_GET['type']) ? $_GET['type'] : NULL;
        switch ($type) {
            case 'student':
                $this->studentController->handler();
                break;
            case 'admin':
                $this->adminController->handler();
                break;
            case 'advisor':
                $this->advisorController->handler();
                break;
            default:
                $this->landing();
        }
    }

    public static function pageRedirect($url)
    {
        header('Location:' . $url);
    }

    public static function logout()
    {
        session_start();
        $_SESSION["userDetails"] = "";
        session_destroy();
        Controller::pageRedirect('index.php');
    }

    public static function landing()
    {
        Controller::pageRedirect('view/landing.php');
    }

    public static function dashboard()
    {
        Controller::pageRedirect('view/dashboard.php');
    }
}
