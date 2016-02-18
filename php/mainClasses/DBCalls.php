<?php

/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2/3/2016
 * Time: 12:23 PM
 */
class DBCalls
{

    function getOwnerById($con, $id)
    {
        $sqlObj = $con->query("SELECT projectOwner FROM projects WHERE projectID=$id");
        $private = $sqlObj[0][0];
        return ($private);
    }

    function checkBrute($con, $username, $userType)
    {
        // 10 and you're locked out for a day (86400 secs);
        $validAttempts = date("Y-m-d H:i:s", time() - 86400);
        $curTable = $userType . 'loginattempts';

        $sql = $con->mysqli;
        $sqlObj = $sql->prepare("SELECT time FROM $curTable WHERE username = ? AND time > '$validAttempts'");
        if ($sqlObj) {
            $sqlObj->bind_param('i', $username);
            $sqlObj->execute();
            $sqlObj->store_result();

            if ($sqlObj->num_rows > 10) {
                return true;
            } else {
                return false;
            }
        } else {
            echo "SQL object bad, returning false as a precaution";
            return false;
        }
    }

    function addBadAttempt($con, $username, $userType)
    {
        $now = date("Y-m-d H:i:s");
        $sql = $con->mysqli;
        $curTable = $userType . 'LoginAttempts';
        $sqlObj = $sql->prepare("INSERT INTO $curTable (username, time) VALUES (?, ?)");
        if ($sqlObj) {
            $sqlObj->bind_param('ss', $username, $now);
            $sqlObj->execute();
            return true;
        }
    }

    private function removeBadAttempts($con, $username, $userType)
    {
        $sql = $con->mysqli;
        $curTable = $userType . 'LoginAttempts';
        $sqlObj = $sql->prepare("DELETE FROM $curTable WHERE username = ?");
        if ($sqlObj) {
            $sqlObj->bind_param('i', $username);
            $sqlObj->execute();
            return true;
        }
    }

    function login($con, $username, $password, $type)
    {
        $sql = $con->mysqli;
        if ($type == "reader") {
            $table = $type . 's';
            $sqlObj = $sql->prepare("SELECT hash FROM $table WHERE username = ? LIMIT 1");
            if ($sqlObj) {
                $sqlObj->bind_param('s', $username);
                $sqlObj->execute();
                $sqlObj->store_result();
                $hash = false;
                $sqlObj->bind_result($hash);
                $sqlObj->fetch();

                if ($this->checkBrute($con, $username, $type)) {
                    return "too many";
                } else {
                    if (password_verify($password,$hash)) {
                        $this->removeBadAttempts($con, $username, $type);
                        return true;
                    } else {
                        $this->addBadAttempt($con, $username, $type);
                        return "no match";
                    }
                }
            }
        }   else    {
            return "dev error: Unknown user type of $type";
        }
    }

    function DBCalls()
    {
        // Any initializing goes here.
    }
}