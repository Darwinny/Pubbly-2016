<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2/16/2016
 * Time: 1:53 PM
 */
$redirectURL = $_GET['redirectURL'];
require('../../DBConnect.php');
set_include_path('../php/mainClasses');
require('DBCalls.php');
require('secSession.php');
sec_session_start();

$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);;
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);;


if (isset($username) && isset($password)) {
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        header("Location:../error.php?num=512");
    }   else    {
        $con = new DBConnect('marketPlace');
        $calls = new DBCalls;

        $loggedIn = $calls->login($con,$username,$password,"reader");
        if ($loggedIn === true) {
            $_SESSION['username'] = $username;
            $_SESSION['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
            header("Location:../loggedIn.php");
        }   else    {
            $error = explode(":",$loggedIn);
            if ($error[0] == "dev error") {
                $mesgForMe = $error[1];
                // TODO: Handle development errors somehow...
                header("Location:../error.php");
            }   else    {
                if ($loggedIn == "no match") {
                    header("Location:../error.php?num=511"); // Bad password (but don't tell them.
                }   else if ($loggedIn == "too many") {
                    header("Location:../error.php?num=513"); // Brute force
                }
            }
        }
    }
}   else    {
    header("Location:../error.php?num=510"); // Missing username or password
}

?>