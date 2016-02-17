<?php
/**
 * Created by PhpStorm.
 * User: cristina
 * Date: 2/16/2016
 * Time: 12:41 PM
 */

require("../../DBConnect.php");
set_include_path("../php/mainClasses");
require("DBCalls.php");
require("secSession.php");

$con = new DBConnect("marketPlace");

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
        header("location:../error.php?num=505");
    }

    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        header("Location:../error.php?num=500");
    }

    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //

    $mysqli = $con->mysqli;

    $prep_stmt = "SELECT id FROM readers WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    // check existing email
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $stmt->close();
            header("Location:../error.php?num=501");
        }
    } else {
        header("Location:../error.php?num=502");
    }

    // check existing username
    $prep_stmt = "SELECT id FROM readers WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // A user with this username already exists
            $stmt->close();
            header("Location:../error.php?num=503");
        }
    } else {
        $stmt->close();
        header("Location:../error.php?num=502");
    }

    // TODO:
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.

    if (empty($error_msg)) {

        // Create hashed password using the password_hash function.
        // This function salts it with a random salt and can be verified with
        // the password_verify function.
        $password = password_hash($password, PASSWORD_BCRYPT);

        // Insert the new user into the database
        if ($insert_stmt = $mysqli->prepare("INSERT INTO readers (username, email, password) VALUES (?, ?, ?)")) {
            $insert_stmt->bind_param('sss', $username, $email, $password);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?num=504');
            }
        }
        header('Location: ../registerSuccess.php');
    }
}