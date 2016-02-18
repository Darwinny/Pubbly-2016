// Clear the username and password field
window.setTimeout(function () {
    document.getElementById("username").value = "";
    document.getElementById("password").value = "";

    var errorElem = document.getElementById('errorMesg');
    if (errorElem.innerHTML !== "{curMessage}") {
        errorElem.style.display = "block";
    }


    // TODO: Remove this shit, it's a tester ONLY!
    document.getElementById("username").value = "Jason";
    document.getElementById("password").value = "HowardRoarkLaughed";
}, 1);
function login() {
    var elem = document.getElementById('loginForm');
    var i_username = elem.username.value;
    var i_password = elem.password.value;
    if (i_username && i_password) {
        var p = document.createElement("input");
        elem.appendChild(p);
        p.name = "p";
        p.type = "hidden";
        p.value = hex_sha512(i_password);
        document.getElementById("password").value = "";

        var redirectURL = document.getElementById('redirect').value;

        elem.setAttribute("action","formActions/processLogin.php?redirectURL=" + redirectURL);
        elem.submit();
        return true;
    } else {
        setError("Error: Missing some information!");
    }
}
function error(mesg) {
    var errorElem = document.getElementById("errorMesg");
    errorElem.innerHTML = mesg;
    errorElem.style.display = "block";
    window.setTimeout(function() {
        errorElem.style.display = "none";
    },250);
    window.setTimeout(function() {
        errorElem.style.display = "block";
    },500);
}