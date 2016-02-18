<?php

/**
 * Created by PhpStorm.
 * User: cristina
 * Date: 2/16/2016
 * Time: 11:59 AM
 */
class HTMLTemplate
{
    private $templateKey = [
        "register" => "html/register.html",
        "error" => "html/error.html",
        "login" => "html/login.html",
        "registerSuccess" => "html/registerSuccess.html",
        "homepage" => "html/homepage.html",
    ];
    public function echoHTML($name, $replace, $with) {
        $loc = $this->templateKey[$name];
        if (isset($loc)) {
            $html = file_get_contents($loc);
            if ($html) {
                if ($replace && $with) {
                    $htmlWithVars = str_replace($replace, $with, $html);
                }   else    {
                    $htmlWithVars = $html;
                }
                echo $htmlWithVars;
            }
        }   else    {
            echo header("Location:error.php?num=2");
        }
    }

    function HTMLTemplate() {

    }
}