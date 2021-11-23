<script src="../Public/scripts/student.js" defer> </script>
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <ul class="nav nav-pills nav-fill">
                <style>
                    <?php include '../public/styles/tempered-bootstrap.css'; ?>
                </style>
                <li class="nav-item">
                    <a onclick="return tabChanger()" class="nav-link link-text-red" href="#profile">Profile</a>
                </li>
                <li class="nav-item">
                    <a onclick="return tabChanger()" class="nav-link link-text-red active active-updated" href="#appointments">Appointment</a>
                </li>
                <li class="nav-item">
                    <a onclick="return tabChanger()" class="nav-link link-text-red" href="#history">History</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container my-4">
    <div class="row tab-items d-none" id="profile">
        <button class="d-none" onclick="getProfile()">Profile</button>
        <div class="col-md-8 m-auto">
            <!-- <h1 class="display-4 text-center">Profile</h1> -->
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
    <div class="row tab-items d-block" id="appointments">
        <button class="d-none" onclick="getAppointments()">Appointment</button>
        <div class="col-md-8 m-auto">
            <div class="border border-danger rounded p-3 mb-3">
                <!-- <h1 class="display-4 text-center">New Appointment</h1> -->
                <form onsubmit="makeAppointments(event)" id='appointmentForm'>
                    <div class="form-group">
                        <label for="advisor_email">Advisor's E-mail</label>
                        <!-- <input type="email" class="form-control form-control-lg" placeholder="advisor_email" name="advisor_email" required /> -->
                        <select class="form-control" name="advisor_email" id="advisor_email" onclick="getAllAdvisors()">
                            <option disabled selected value="">Select Advisor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control form-control-lg" placeholder="description" name="description" required />
                    </div>
                    <input type="submit" class="btn  btn-danger btn-block mt-4" name="make" value="Make Appointment" />
                </form>
            </div>
            <h1 class="display-4 text-center mt-4">Appointments</h1>
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <!-- <th scope="col">ID</th> -->
                        <!-- <th scope="col">Student's E-mail</th> -->
                        <th scope="col">Advisor</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date & Time</th>
                        <th scope="col">Cancel</th>
                    </tr>
                </thead>
                <tbody id="appointmentView" class="text-capitalize">

                </tbody>
            </table>
        </div>
    </div>
    <div class="row tab-items d-none" id="history">
        <button class="d-none" onclick="getHistory()">History</button>
        <!-- <h1 class="display-4 text-center">History</h1> -->
        <table class="table table-striped">
            <thead>
                <tr class="text-center">
                    <!-- <th scope="col">ID</th> -->
                    <!-- <th scope="col">Student's E-mail</th> -->
                    <th scope="col">Advisor</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date & Time</th>
                </tr>
            </thead>
            <tbody id="historyView" class="text-capitalize">

            </tbody>
        </table>
    </div>
</div>