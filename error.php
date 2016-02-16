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
    $replace = array('{curTitle}','{curMessage}');
    $with = array($obj["title"],$obj["message"]);
    $template->echoHTML("error",$replace,$with);
}   else    {
    echo "Something went wrong! We'll fix it soon, promiss";
}