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

    function checkBrute($con, $username)
    {
        // 10 and you're locked out for a day (86400 secs);
        $validAttempts = date("Y-m-d H:i:s", time() - 86400);

        $sql = $con->mysqli;
        $sqlObj = $sql->prepare("SELECT time FROM loginattempts WHERE username = ? AND time > '$validAttempts'");
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

    function addBadAttempt($con, $username)
    {
        $now = date("Y-m-d H:i:s");
        $sql = $con->mysqli;
        $sqlObj = $sql->prepare("INSERT INTO loginattempts (username, time) VALUES (?, ?)");
        if ($sqlObj) {
            $sqlObj->bind_param('ss', $username, $now);
            $sqlObj->execute();
            return true;
        }
    }

    private function removeBadAttempts($con, $username)
    {
        $sql = $con->mysqli;
        $sqlObj = $sql->prepare("DELETE FROM loginattempts WHERE username = ?");
        if ($sqlObj) {
            $sqlObj->bind_param('i', $username);
            $sqlObj->execute();
            return true;
        }
    }

    function login($con, $username, $password)
    {
        $sql = $con->mysqli;
        $sqlObj = $sql->prepare("SELECT username, password FROM users WHERE username = ? LIMIT 1");
        if ($sqlObj) {
            $sqlObj->bind_param('s', $username);
            $sqlObj->execute();
            $sqlObj->store_result();

            $sqlObj->bind_result($retUsername, $retPassword);
            $sqlObj->fetch();

            // TODO: Passwords not salted or hashed. Recreate all usernames with proper salt and hashing.
            if ($this->checkBrute($con, $username)) {
                return false;
            } else {
                if ($retPassword == $password) {
                    $this->removeBadAttempts($con, $username);
                    return true;
                } else {
                    $this->addBadAttempt($con, $username);
                    return false;
                }
            }
        }
    }

    function DBCalls()
    {
        // Any initializing goes here.
    }
}