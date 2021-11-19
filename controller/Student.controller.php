<?php
require_once 'model/student.php';
require_once 'model/studentModel.php';
require_once 'model/appointment.php';
require_once 'model/appointmentModel.php';
require_once 'model/history.php';
require_once 'model/historyModel.php';
require_once 'model/advisorModel.php';
require_once 'config.php';

class StudentController
{
    function __construct()
    {
        $this->config = new Config();
        $this->student =  new StudentModel($this->config);
        $this->appointment =  new AppointmentModel($this->config);
        $this->history =  new HistoryModel($this->config);
        $this->advisor =  new AdvisorModel($this->config);
    }

    public function handler()
    {
        $act = isset($_GET['act']) ? $_GET['act'] : NULL;
        switch ($act) {
            case 'login':
                $this->login();
                break;
            case 'register':
                $this->register();
                break;
            case 'profile':
                $this->manageProfile();
                break;
            case 'appointment':
                $this->manageAppointment();
                break;
            case 'history':
                $this->history();
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

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {

                $obj = new Student();
                $obj->name = $_POST["name"];
                $obj->email = $_POST["email"];
                $obj->address = $_POST["address"];
                $obj->age = $_POST["age"];
                $obj->password = md5($_POST["password"]);
                $res = $this->student->insert($obj);
                if ($res) {
                    $obj = new History();
                    $obj->student_email = $_POST["email"];
                    $obj->description = "created account";
                    $res = $this->history->insert($obj);
                    echo json_encode(1);
                } else {
                    echo json_encode("email already exists");
                }
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            Controller::pageRedirect('view/register.php');
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $obj = new Student();
                $obj->email = $_POST["email"];
                $obj->password = md5($_POST["password"]);
                $result = $this->student->find($obj);
                $res = $result->fetch_assoc();
                $session = array("name" => $res["name"], "email" => $res["email"], "type" => "student");
                if ($res) {
                    $_SESSION["userDetails"] = json_encode($session);
                    Controller::dashboard();
                } else {
                    $_SESSION["errorMessage"] = "credentials do not match";
                    Controller::pageRedirect('view/login.php');
                }
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            Controller::pageRedirect('view/login.php');
        }
    }

    public function manageProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $userDetails = json_decode($_SESSION['userDetails']);
                if (!$userDetails->type === "student") {
                    echo json_encode(array("res" => 0));
                    return;
                }
                $obj = new Student();
                $obj->name = $_POST["name"];
                $obj->address = $_POST["address"];
                $obj->age = $_POST["age"];
                $obj->class = $_POST["class"];
                $obj->section = $_POST["section"];
                $obj->email = $userDetails->email;
                $res = $this->student->update($obj);
                if ($res) {
                    echo json_encode(array("res" => 1));
                    $obj = new History();
                    $obj->student_email = $userDetails->email;
                    $obj->description = "changed profile details";
                    $res = $this->history->insert($obj);
                } else {
                    echo json_encode(array("res" => 0));
                }
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            try {
                $userDetails = json_decode($_SESSION['userDetails']);
                if (!$userDetails->type === "student") {
                    echo json_encode(array("res" => 0));
                    return;
                }
                $result = $this->student->findData($userDetails->email);
                $res = $result->fetch_assoc();
                $data = array("name" => $res["name"], "address" => $res["address"], "age" => $res["age"], "class" => $res["class"], "section" => $res["section"]);
                if ($res) {
                    echo json_encode(array("res" => 1, "data" => $data));
                } else {
                    echo json_encode(array("res" => 0));
                }
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function manageAppointment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userDetails = json_decode($_SESSION['userDetails']);
            if (!$userDetails->type === "student") {
                echo json_encode(array("res" => 0));
                return;
            }
            if ($_POST["id"]) {
                $id = $_POST["id"];
                $result = $this->appointment->matchStudentAndId($userDetails->email, $id);
                if (!$result) {
                    echo json_encode(array("res" => 0));
                    return;
                }
                $advisor_email = $result["advisor_email"];
                $obj = new Appointment();
                $obj->id = $id;
                $obj->status = "cancelled by student";
                $obj->student_email = $userDetails->email;
                $res = $this->appointment->update($obj);
                if ($res) {
                    echo json_encode(array("res" => 1));
                    $obj = new History();
                    $obj->student_email = $userDetails->email;
                    $obj->advisor_email = $advisor_email;
                    $obj->description = "cancelled appointment by student";
                    $res = $this->history->insert($obj);
                } else {
                    echo json_encode(array("res" => 0));
                }
            } else {
                try {
                    if (!$this->advisor->findByEmailAndAvailability($_POST["advisor_email"], 1)) {
                        echo json_encode(array("res" => 0));
                        return;
                    }
                    $obj = new Appointment();
                    $obj->status = "pending";
                    $obj->description = $_POST["description"];
                    $obj->advisor_email = $_POST["advisor_email"];
                    $obj->student_email = $userDetails->email;
                    $res = $this->appointment->insert($obj);
                    if ($res) {
                        echo json_encode(array("res" => 1));
                        $obj = new History();
                        $obj->student_email = $userDetails->email;
                        $obj->advisor_email = $_POST["advisor_email"];
                        $obj->description = "booked appointment";
                        $res = $this->history->insert($obj);
                    } else {
                        echo json_encode(array("res" => 0));
                    }
                } catch (Exception $e) {
                    throw $e;
                }
            }
        } else {
            try {
                $userDetails = json_decode($_SESSION['userDetails']);
                if (!$userDetails->type === "student") {
                    echo json_encode(array("res" => 0));
                    return;
                }
                $result = $this->appointment->findByStudent($userDetails->email);
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

    public function history()
    {
        try {
            $userDetails = json_decode($_SESSION['userDetails']);
            if (!$userDetails->type === "student") {
                echo json_encode(array("res" => 0));
                return;
            }
            $result = $this->history->findByStudent($userDetails->email);
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
