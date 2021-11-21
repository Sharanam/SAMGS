function tabChanger() {
    event.preventDefault();
    // active tab change
    let d = document.getElementsByClassName("nav-link");
    for (var i = 0; i < d.length; i++) {
        d[i].classList.remove("active");
        d[i].classList.remove("active-updated");
        d[i].classList.add("link-text-red");
    }
    event.target.classList.add("active");
    event.target.classList.add("active-updated");
    event.target.classList.remove("link-text-red");

    // respective content change
    d = document.getElementsByClassName('tab-items');
    for (let i = 0; i < d.length; i++) {
        d[i].classList.remove("d-block");
        d[i].classList.add("d-none");
    }
    d = document.getElementById(event.target.href.split("#")[1]);
    d.classList.add("d-block");
    d.children[0].click()
}

function getProfile() {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let data = JSON.parse(this.responseText);
            if (!data.res) return false;
            data = data.data;
            document.getElementsByName('name')[0].value = data.name;
            document.getElementsByName('address')[0].value = data.address;
            document.getElementsByName('age')[0].value = data.age;
            document.getElementsByName('class')[0].value = data.class;
            document.getElementsByName('section')[0].value = data.section;
        }
    };
    xhttp.open("GET", "../index.php?type=student&act=profile", true);
    xhttp.send();
}

function setProfile(event) {
    event.preventDefault();
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            res = JSON.parse(this.responseText);
            alert(res.res ? "Profile Updated" : "Something went wrong.")
        }
    };
    xhttp.open("POST", "../index.php?type=student&act=profile", true);
    xhttp.send(new FormData(document.getElementById('profileForm')));
}

function getAppointments() {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let data = JSON.parse(this.responseText);
            if (!data.res) {
                document.getElementById("appointmentView").innerHTML = "<p class='text-center'>No Appoitment Found.</p>";
                return false;
            }
            data = data.data;
            let html = "";
            for (let i = 0; i < data.length; i++) {
                html += "<tr>";
                // html += "<th scope=\"row\">" + data[i].id + "</th>";
                // html += "<td>" + data[i].student_email + "</td>";
                html += "<td>" + (data[i].advisor_email === "null" ? "-" : data[i].advisor_email) + "</td>";
                html += "<td>" + data[i].description + "</td>";
                html += "<td>" + data[i].status + "</td>";
                html += "<td>" + data[i].timestamp + "</td>";
                html += "<td>" + (data[i].status !== "cancelled by student" ? '<button class="btn btn-danger" onclick="cancelAppointment(event)" value=' + data[i].id + '>Cancel</button>' : "") + "</td>";
                html += "</tr>";
            }
            document.getElementById("appointmentView").innerHTML = html;
        }
    };
    xhttp.open("GET", "../index.php?type=student&act=appointment", true);
    xhttp.send();
}

function makeAppointments(event) {
    event.preventDefault();
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            res = JSON.parse(this.responseText);
            if (res.res) {
                alert("Your appointment has been scheduled.");
                getAppointments();
            } else {
                alert("Something went wrong.");
            }
        }
    };
    xhttp.open("POST", "../index.php?type=student&act=appointment", true);
    xhttp.send(new FormData(document.getElementById('appointmentForm')));
}

function cancelAppointment(event) {
    event.preventDefault();
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            res = JSON.parse(this.responseText);
            if (res.res) {
                alert("Appointment Cancelled.");
                getAppointments();
            } else {
                alert("Something went wrong.");
            }
        }
    }
    xhttp.open("POST", "../index.php?type=student&act=appointment", true);
    let d = new FormData()
    d.append("id", event.target.value)
    xhttp.send(d);
}

function getAllAdvisors() {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let data = JSON.parse(this.responseText);
            if (!data.res) {
                document.getElementById("advisor_email").innerHTML = "<option disabled selected value=''>No Advisor Found.</option>";
                return false;
            }
            data = data.data;
            console.log(data);
            let html = "";
            for (let i = 0; i < data.length; i++) {
                if (data[i].availability)
                    html += "<option>" + data[i].email + "</option>";
            }
            document.getElementById("advisor_email").innerHTML = html;
        }
    }
    xhttp.open("GET", "../index.php?type=advisor&act=getAll", true);
    xhttp.send();
}

function getHistory() {
    document.getElementById("historyView").innerHTML = "Waiting...";
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let data = JSON.parse(this.responseText);
            if (!data.res) {
                document.getElementById("historyView").innerHTML = "No History Found";
                return false;
            }
            data = data.data;
            let html = "";
            for (let i = 0; i < data.length; i++) {
                html += "<tr>";
                // html += "<th scope=\"row\">" + data[i].id + "</th>";
                // html += "<td>" + data[i].student_email + "</td>";
                html += "<td>" + (/^null$/i.test(data[i].advisor_email) ? "-" : data[i].advisor_email) + "</td>";
                html += "<td>" + data[i].description + "</td>";
                html += "<td>" + data[i].timestamp + "</td>";
                html += "</tr>";
            }
            document.getElementById("historyView").innerHTML = html;
        }
    };
    xhttp.open("GET", "../index.php?type=student&act=history", true);
    xhttp.send();
}

// on page load
document.getElementById(document.getElementsByClassName("active")[0].href.split("#")[1]).children[0].click()