<?php
/**
 * Created by PhpStorm.
 * User: cristina
 * Date: 2/16/2016
 * Time: 12:20 PM
 */

$num = isset($_GET["num"]) ? $_GET["num"] : false;
set_include_path('php/mainClasses/');
require('errorLookup.php');
require('HTMLTemplate.php');
$errorClass = new ErrorLookup();
if ($num) {
    $obj = $errorClass->lookUp($num);
    $template = new HTMLTemplate();

    $replace = array('{curTitle}', '{curMessage}');
    $with = array($obj["title"], $obj["message"]);
    if (isset($obj["url"])) {
        // If a url is supplied, redirect and replace there.
        $template->echoHTML($obj["url"], $replace, $with);
    } else {
        // Else use the standard error.php page
        $template->echoHTML("error", $replace, $with);
    }
} else {
    echo "<h2>Oh shoot, a bug!</h2>";
    echo "</br> Please <a href='www.pubbly.com/console'>contact me</a>";
    echo " (jason) with the steps to repeat this.";
}