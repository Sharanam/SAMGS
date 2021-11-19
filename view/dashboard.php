<?php
require './common/header.php';
require './common/navbar.php';

if ($type === "student") {
    require './dashboard/student/index.php';
} else if ($type === "admin") {
    require './dashboard/admin/index.php';
} else {
    require './dashboard/advisor/index.php';
}

require './common/footer.php';
