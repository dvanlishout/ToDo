<?php

require_once("query.class.php");
class User
{

    // PRIVATE VARIABLES
    private $m_sUsername;
    private $m_sPassword;
    private $m_sMailadress;


    // SETTER FUNCTION
    public function __set($p_sProperty, $p_vValue)
    {

        $validation = new Validate();

        switch ($p_sProperty) {


            case "Username":

                if ($validation->isName($p_vValue)) {
                $this->m_sUsername = $p_vValue;  };

                break;
            case "Password":

                if ($validation->isPassword($p_vValue)) {
                    $this->m_sPassword = $p_vValue;
                }

                break;
            case "Mailadress":

                if ($validation->isEmail($p_vValue)) {
                    $this->m_sMailadress = $p_vValue;
                }

        }
    }

    // GETTER FUNCTION
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Username":
                return $this->m_sUsername;
                break;
            case "Password":
                return $this->m_sPassword;
                break;
            case "Mailadress":
                return $this->m_sMailadress;
                break;

        }
    }

    // LOGIN VERIFICATION FUNCTION
    public function canLogin()
    {

            $q = new query();
            if($q->canLoginquery($this->m_sUsername, $this->m_sPassword )) {



            }

            else {

            }
            ;

    }

    // LOGIN SESSIONS FUNCTION


    // CHECK IF USER IS LOGGED IN
    public function Authenticate()
    {

        if (isset($_SESSION['loggedin'])) {

            if ($_SESSION['loggedin'] == "superbrein") {
                return true;
            } else {
                echo "Session is not set correctly";
            }

        } else {
            echo "Session is empty";
        }
    }

    // SIGNUP FUNCTION
    public function Register()
    {

        // VERIFICATION: IF FILLED IN
        if (!empty($this->m_sUsername) && !empty($this->m_sPassword) && !empty($this->m_sMailadress)) {

            $q = new query();


            if ($q->UsernameAvailable($this->m_sUsername)) {
                $_SESSION['loginfeedback'] = "This username is already taken!";
                echo $this->m_sUsername;


            } elseif ($q->MailadressAvailable($this->m_sMailadress)) {
                $_SESSION['loginfeedback'] = "This e-mailadress is already taken!";


            } else {
                $options = ['cost' => 12];
                $password = password_hash($this->m_sPassword, PASSWORD_DEFAULT, $options);
                $q = new query();
                $q->registerQuery($this->m_sUsername, $password, $this->m_sMailadress);

                $_SESSION['loginfeedback'] = "Welcome aboard!";
                header("location: index.php");
                return true;

            }
        }
    }





            // HASH PASSWORD


            // BIND VALUES TO QUERY


            // CHECK IF USERNAME/EMAIL ALREADY EXISTS





    /// VALIDATION RULES THE NATION

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


    public function isUsername($p_vValue)
    {
        if (!empty($p_vValue)) {
            if (strlen($p_vValue) >= 5) {
                return true;
            } else {
                throw new Exception ("Username must be at least 5 characters");
            }


        } else {
            throw new Exception("Oops, please fill in a username");
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





    // GET INFO OF USER


    // CHANGE USER INFO FUNCTION

}







?>