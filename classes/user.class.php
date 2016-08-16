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


                if ( $_SESSION['admin'] > 0) {
                    header("location: indexAdmin.php");

                }
                else {
                    header("location: index.php");

                }
            }


            else {
            }
            ;

    }


    // SIGNUP FUNCTION
    public function Register($admin)
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
                $q->registerQuery($this->m_sUsername, $password, $this->m_sMailadress, $admin);

                $_SESSION['loginfeedback'] = "Welcome aboard!";
                $_SESSION['admin'] = $admin;
                header("location: login.php");

                return true;

            }
        }
    }






    /// VALIDATION RULES THE NATION



    // GET INFO OF USER


    // CHANGE USER INFO FUNCTION

}







?>