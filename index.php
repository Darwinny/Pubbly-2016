<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2/18/2016
 * Time: 4:11 PM
 */

set_include_path('php/mainClasses');
require('HTMLTemplate.php');
$template = new HTMLTemplate();
$template->echoHTML('homepage',false,false);

?>