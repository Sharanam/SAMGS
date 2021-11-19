<?php
session_start();
if (isset($_SESSION['userDetails'])) {
  if (in_array(basename($_SERVER['PHP_SELF']), array("login.php", "register.php", "admin.php", "advisor.php"))) {
    header('Location:../index.php');
  }
  $details = $_SESSION['userDetails'];
  $type = json_decode($details)->type;
} else if (basename($_SERVER['PHP_SELF']) === "dashboard.php") {
  header('Location:../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <link rel="stylesheet" href="../Public/styles/style.css">
  <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  <title>SAMGS</title>
</head>
<?php
if (isset($type))
  echo '<script>const type="' . $type . '";</script>';
?>

<body>