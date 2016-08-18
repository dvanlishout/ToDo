<?php

include_once("user.class.php");

class Validate
{

    public function isName($p_vValue)
    {
        if (!empty($p_vValue)) {

            if (preg_match("/^[a-zA-Z '-]*$/", $p_vValue)) {
                return true;
            } else {
                throw new Exception("A name can only contain white spaces and letters!");
            }
        } else {
            throw new Exception("Oops, please fill in your full name");
        }

    }




    public function isEmail($p_vValue)
    {
        if (!empty($p_vValue)) {
            if (preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})^", $p_vValue)) {
                return true;
            } else {
                throw new Exception("Oops, please fill in a valid email adress");
            }
        } else {
            throw new Exception("Oops, please fill in your email adress");
        }
    }

    public function isPassword($p_vValue)
    {
        if (!empty($p_vValue)) {
            if (strlen($p_vValue) >= 6) {
                if (preg_match("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])^", $p_vValue)) {
                    return true;
                } else {
                    throw new Exception("Looks like you're missing a digit, uppercase or lowercase letter in your password");
                }
            } else {
                throw new Exception("Password must be at least 6 characters. Also make sure there is an upper case, lower case and one digit in it!");
            }

        } else {
            throw new Exception("Oops, please fill in a password");
        }
    }








}


?>