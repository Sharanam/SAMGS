  <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-4">
    <div class="container">
      <div class="navbar-brand"> <a href="../index.php" class="nav-link" style="color:white;">SAMGS</a></div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobile-nav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mobile-nav">
        <ul class="navbar-nav ml-auto">
          <?php
          if (isset($_SESSION['userDetails'])) {
            echo '<li class="nav-item">
            <a class="nav-link" href="../index.php?type=' . $type . '&act=dashboard">Dashboard</a>
          </li>';
            echo '<li class="nav-item">
            <a class="nav-link" href="../index.php?type=' . $type . '&act=logout">Logout</a>
          </li>';
          } else {
            echo '<li class="nav-item">
            <a class="nav-link" href="../index.php?type=student&act=register">Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../index.php?type=student&act=login">Login</a>
          </li>';
          } ?>
        </ul>
      </div>
    </div>
  </nav>