async function registerUser(e) {
  e.preventDefault();
  const formData = new FormData(e.target);
  let res = await fetch("../index.php?type=student&act=register", {
    method: "POST",
    body: formData,
  });
  let json = await res.json();
  if (json == 1) {
    alert("SUCCESSFULLY REGISTERED");
    location.href = "../index.php?type=student&act=login";
  } else {
    document.querySelector("#content").innerText = json;
  }
}
