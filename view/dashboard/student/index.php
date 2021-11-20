<script src="../Public/scripts/student.js" defer> </script>
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <ul class="nav nav-pills nav-fill">
                <style>
                    <?php require '../public/styles/tempered-bootstrap.css'; ?>
                </style>
                <li class="nav-item">
                    <a onclick="return tabChanger()" class="nav-link link-text-red" href="#profile">Profile</a>
                </li>
                <li class="nav-item">
                    <a onclick="return tabChanger()" class="nav-link link-text-red" href="#appointments">Appointment</a>
                </li>
                <li class="nav-item">
                    <a onclick="return tabChanger()" class="nav-link active link-text-red active-updated " href="#history">History</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container my-4">
    <div class="row tab-items d-none" id="profile">
        <button class="d-none" onclick="getProfile()">Profile</button>
        <div class="col-md-8 m-auto">
            <h1 class="display-4 text-center">Update Profile</h1>
            <form onsubmit="setProfile(event)" id='profileForm'>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="name" class="form-control form-control-lg" placeholder="name" name="name" minlength="5" required />
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control form-control-lg" placeholder="address" name="address" required />
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control form-control-lg" placeholder="age" name="age" min="5" required />
                </div>
                <div class="form-group">
                    <label for="Class">Class</label>
                    <input type="number" class="form-control form-control-lg" placeholder="Class" name="class" required />
                </div>
                <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" maxlength="1" class="form-control form-control-lg" placeholder="section" name="section" required />
                </div>
                <div id="profile-content" class="error-message"></div>
                <input type="submit" class="btn  btn-danger btn-block mt-4" name="update" value="Update" />
            </form>
        </div>
    </div>
    <div class="row tab-items d-none" id="appointments">
        <button class="d-none" onclick="getAppointments()">Profile</button>
        <div id="appointmentView">
            <p>
                Appointments will be shown here
                <br />
                For that, 3 APIs - book and manage appointments
                <br />
                (+1 to get list of advisors)
                <br />
                Pop-up in appointment
            </p>
        </div>
    </div>
    <div class="row tab-items d-block" id="history">
        <button class="d-none" onclick="getHistory()">Profile</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <!-- <th scope="col">ID</th> -->
                    <!-- <th scope="col">Student's E-mail</th> -->
                    <th scope="col">Advisor's E-mail</th>
                    <th scope="col">Description</th>
                    <th scope="col">Timestamp</th>
                </tr>
            </thead>
            <tbody id="historyView" class="text-capitalize">

            </tbody>
        </table>
    </div>
</div>