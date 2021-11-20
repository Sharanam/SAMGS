function tabChanger() {
    event.preventDefault();
    // active tab change
    let d = document.getElementsByClassName("nav-link");
    for (var i = 0; i < d.length; i++) {
        d[i].classList.remove("active");
        d[i].classList.remove("active-updated");
        event.target.classList.add("link-text-red");
    }
    event.target.classList.add("active");
    event.target.classList.add("active-updated");
    d[i].classList.remove("link-text-red");

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

// on page load
document.getElementById(document.getElementsByClassName("active")[0].href.split("#")[1]).children[0].click()