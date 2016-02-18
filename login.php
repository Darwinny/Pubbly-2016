<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2/16/2016
 * Time: 11:50 AM
 */

require "../DBConnect.php";
set_include_path('php/mainClasses');
require "DBCalls.php";
require "secSession.php";
require "HTMLTemplate.php";
$redirectURL = isset($_GET['redirectURL']) ? $_GET['redirectURL'] : false;

sec_session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : false;
if ($username) {
    echo "logged in";
}   else    {
    $template = new HTMLTemplate();
    $replace = array('{redirectURL}');
    $with = array($redirectURL);
    $template->echoHTML('login',$replace,$with);
}


?>