<?php
	require_once("db.class.php");

	class query{
        function command($sql){
            $q = new dbconnect;
            $q->run($sql);
            return $q->fetch();
            $q->close();
        }
        function getUser(){
            $sql = "SELECT * FROM student";
            $user = $this->command($sql);
            return $user;
        }
        function getList($userID){
            $sql = "SELECT * FROM list WHERE userID = '".$userID."'";
            $result = $this->command($sql);
            return $result;
        }

        function registerQuery($username, $password, $mailadress){
            $sql = "INSERT INTO student (username, password, mailadress) VALUES ('".$username."', '".$password."', '".$mailadress."')";
            $newuser = $this->command($sql);
            return $newuser;
        }

        function usernameAvailable($username){
            $sql = "SELECT username FROM student WHERE username = '".$username."'";
            $result = $this->command($sql);


            if (count($result) > 0) {
                return true;
            } else {
                return false;
            }
        }

        function mailadressAvailable($mailadress){
            $sql = "SELECT mailadress FROM student WHERE mailadress = '".$mailadress."'";
            $result = $this->command($sql);

            if (count($result) > 0) {
                return true;
            } else {
                return false;
            }
        }

        function canloginQuery($username, $password){
            $sql = "SELECT * FROM student WHERE username = '".$username."'";
            $result = $this->command($sql);

            if (count($result) > 0) {
                $hash = $result[0]['password'];

                if(password_verify($password, $hash)){
                    $_SESSION['login_user'] = $result[0]['username'];
                    $_SESSION['user_id'] = $result[0]['userID'];
                    $_SESSION['loggedin'] = "yes";
                    header('location: index.php');
                }

                else {
                    return false;
                }
            }

            else{
                return false;
            }
        }





    }
?>