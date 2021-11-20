<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a onclick="return tabChanger()" class="nav-link" href="#profile">Profile</a>
                </li>
                <li class="nav-item">
                    <a onclick="return tabChanger()" class="nav-link active" href="#appointments">Appointment</a>
                </li>
                <li class="nav-item">
                    <a onclick="return tabChanger()" class="nav-link" href="#history">History</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    function tabChanger() {
        // active tab change
        let d = document.getElementsByClassName("nav-link");
        for (var i = 0; i < d.length; i++) {
            d[i].classList.remove("active");
        }
        event.target.classList.add("active");

        // respective content change
        d = document.getElementsByClassName('tab-items');
        for (let i = 0; i < d.length; i++) {
            d[i].classList.remove("d-block");
            d[i].classList.add("d-none");
        }
        document.getElementById(event.target.href.split("#")[1]).classList.add("d-block");
    }
</script>
<div class="container">
    <div class="row tab-items d-none" id="profile">
        <p> profiles- 2 APIs</p>
    </div>
    <div class="row tab-items d-block" id="appointments">
        3 APIs - book and manage appointments (+1 to get list of advisors)
        Pop-up in appointment
    </div>
    <div class="row tab-items d-none" id="history">
        history - 1 API
    </div>
</div>