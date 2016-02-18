<?php

/**
 * Created by PhpStorm.
 * User: cristina
 * Date: 2/16/2016
 * Time: 12:06 PM
 */
class ErrorLookup
{
    private $devContactURL = "www.pubbly.com/console";
    private $devContactHTML = false /*'<a href=' . $this . '->devContactURL>Jason</a>'*/;
    /* TODO: FRIG!!
     * Can't have an evaluated expression in an array declaration
     * which means "message" => "contact $devContactHTML" won't freaking fracking work
     *
     * Maybe replace {devContact} with the private var in the constructor?
     * I dunno man, but I aint doing it right now.
     */
    private $errorKey = [
        1 => [
            "title" => "Error not found",
            "message" => "Can't find the error you requested... something went wrong while something was going wrong",
        ],
        2 => [
            "title" => "HTML Template not found",
            "message" => "HTML Template requested in php/mainClasses/HTMLTemplate.php was not found in the key array.",
        ],
        // 500 block is Registration errors
        500 => [
            "title" => "Registration Error:",
            "message" => "Invalid password configuration.",
        ],
        501 => [
            "title" => "Registration Error:",
            "message" => "A user with this email address already exists.",
        ],
        502 => [
            "title" => "Registration Error:",
            "message" => "Database error, bad sqli statement.",
        ],
        503 => [
            "title" => "Registration Error:",
            "message" => "A user with this username already exists.",
        ],
        504 => [
            "title" => "Registration Error:",
            "message" => "Registration failure: Bad INSERT command.",
        ],
        505 => [
            "title" => "Registration Error:",
            "message" => "The email address you entered is not valid.",
        ],
        // 510 block is Login errors
        510 => [
            "title" => "Login Error:",
            "message" => "Missing Username or Password.",
            "url" => "login",
        ],
        511 => [
            "title" => "Login Error:",
            "message" => "Wrong password.",
            "url" => "login",
        ],
        512 => [
            "title" => "Developer error:",
            "message" => "Invalid password configuration, report to Jason",
        ],
        513 => [
            "title" => "Login error:",
            "message" => "Too many attempts, try against tomorrow or contact your system admin",
            "url" => "login",
        ]

    ];

    public function lookUp($num)
    {
        $errorObj = isset($this->errorKey[$num]) ? $this->errorKey[$num] : false;
        if ($errorObj) {
            return $errorObj;
        } else {
            return $this->errorKey[1];
        }
    }

    function ErrorLookup()
    {
    }
}