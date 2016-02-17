<?php
/**
 * Created by PhpStorm.
 * User: cristina
 * Date: 2/16/2016
 * Time: 11:54 AM
 */
set_include_path('php/mainClasses');
require('HTMLTemplate.php');
$template = new HTMLTemplate();
$template->echoHTML('register',false,false);

?>