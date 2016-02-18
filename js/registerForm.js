var keytimeout = false;
function check_pubbly_cred(elem) {
    if (keytimeout) {
        window.clearTimeout(keytimeout);
    }
    keytimeout = window.setTimeout(function () {
        console.log("check " + elem);
        var cont = $(elem).parent();
        $(cont).find('img').css('display','none');
        $(cont).find('.server-wait-mark').css('display','block');
        var server = cont[0].getAttribute('server');
        var serverip = (server == 'dev' ? devip : prodip);

        $.post( serverip + "phpscripts/UserExists.php", { username: elem.value})
            .done(function( data ) {
                console.log( "Data Loaded: " + data );
            });
    }, 500)
}
function toggle_server_creds(elem) {
    var server = (elem.value == 'd' ? "dev" : "prod");
    var stat = $('#' + server + "-pubblyuser").prop('disabled');
    $('#' + server + "-pubblyuser").prop('disabled', !stat);
}
// TODO: Join this function and the function at login.html into one single formHash include file.
function register(elem) {
    var i_username = elem.form.username.value;
    var i_password = elem.form.password.value;
    var i_confirm = elem.form.confirmpwd.value;
    var i_email = elem.form.email.value;

    if (i_password === i_confirm) {
        if (i_username && i_email) {
            if (i_password.length >= 6) {
                var p = document.createElement("input");
                document.getElementById("registrationForm").appendChild(p);
                p.name = "password";
                p.type = "hidden";
                p.value = hex_sha512(password.value);
                i_password = "";
                i_confirm = "";
                submitForm();
                return true;
            }   else    {
                setError("Error: Password too short!");
            }
        }   else    {
            setError("Error: Missing some information!");
        }
    } else {
        setError("Error: Passwords do not match!");
    }
}
function submitForm() {
    $("#registrationForm").attr("action","formActions/register.php");
    $("#registrationForm").submit();
}
function setError(mesg) {
    $(".error").html(mesg);
    $(".error").css("visibility","visible");
    window.setTimeout(function() {
        $(".error").css("visibility","hidden");
    },250);
    window.setTimeout(function() {
        $(".error").css("visibility","visible");
    },500);
}
