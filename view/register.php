<?php
require './common/header.php';
require './common/navbar.php';
?>
<style>
  .error-message {
    padding: 7px 10px;
    background: #fff1f2;
    border: #ffd5da 1px solid;
    color: #d6001c;
    border-radius: 4px;
    margin: 30px 10px 10px 10px;
  }
</style>
<script src="../Public/scripts/register.js"></script>
<div class="register">
  <div class="container">
    <div class="row">
      <div class="col-md-8 m-auto">
        <h1 class="display-4 text-center">Sign Up</h1>
        <p class="lead text-center">Create your SAMGS account</p>
        <form onsubmit="registerUser(event)">
          <div class="form-group">
            <input type="name" class="form-control form-control-lg" placeholder="name" name="name" minlength="5" required />
          </div>
          <div class="form-group">
            <input type="email" class="form-control form-control-lg" placeholder="email" name="email" required />
          </div>
          <div class="form-group">
            <input type="text" class="form-control form-control-lg" placeholder="address" name="address" required />
          </div>
          <div class="form-group">
            <input type="number" class="form-control form-control-lg" placeholder="age" name="age" min="5" required />
          </div>
          <div class="form-group">
            <input type="password" class="form-control form-control-lg" placeholder="Password" name="password" minlength="8" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" />
          </div>
          <div id="content" class="error-message"></div>
          <input type="submit" class="btn  btn-danger btn-block mt-4" name="register" value="Register" />
        </form>
      </div>
    </div>
  </div>
</div>

<?php
require './common/footer.php';
?>