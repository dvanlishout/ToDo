<?php
	require_once("db.class.php");

	class query
    {
        function command($sql)
        {
            $q = new dbconnect;
            $q->run($sql);
            return $q->fetch();
            $q->close();
        }

        //LIST//

        function getList()
        {
            $sql = "SELECT * FROM list";
            $user = $this->command($sql);
            return $user;
        }

        function listnameQuery($listname)
        {
            $sql = "SELECT listname FROM list WHERE listname = '" . $listname . "'";
            $result = $this->command($sql);
            if (count($result) > 0) {
                return false;

            } else {
                return true;
            }

        }

        function newListquery($listname, $userid, $courseID)
        {
            $sql = "INSERT INTO list (listname, fk_userid, fk_courseid) VALUES ('" . $listname . "', '" . $userid . "', '" . $courseID . "')";
            $result = $this->command($sql);
            return $result;

        }

        function deleteList($listID)
        {
            $q = new query;
            $q = $q->getTask($listID);

            if(count($q) > 0){
                $sql = "DELETE FROM task WHERE fk_listID = '" . $listID . "'";
                $q = new dbconnect();
                $q->run($sql);

            }

            $sql2 = "DELETE FROM list WHERE listID = '" . $listID . "'";
            $q = new dbconnect();
            $result = $q->run($sql2);
            return $result;

        }

        //TASK//


        function getTask($listID)
        {
            $sql = "SELECT * FROM task WHERE FK_listID = '" . $listID . "'  ORDER BY deadline ASC";
            $result = $this->command($sql);
            return $result;
        }

        function updateTask($taskID)
        {
            $status3 = $this->checkStatus($taskID);




            $sql = "UPDATE task SET status='".$status3."' WHERE taskID = '" . $taskID . "'";

            $q = new dbconnect();
            $result = $q->run($sql);
            return $result;
        }

        function checkStatus($taskID){
            $status3 = $this->getStatus($taskID);

            if ($status3 == 0){
                $status2 = 1;
            }else{
                $status2 = 0;
            }
            return $status2;

        }

        function getStatus($taskID)
        {
            $sql = "SELECT status FROM task WHERE taskID = '" . $taskID . "'";
            $result = $this->command($sql);
            return $result[0]['status'];

        }

        function newTaskquery($taskname, $listid, $date)
        {
            $date2 = substr($date, 6, 4)."-".substr($date, 3, 2)."-".substr($date, 0, 2);
            $sql = "INSERT INTO task (taskname, FK_listid, deadline) VALUES ('" . $taskname . "', '" . $listid . "', '" . $date2 . "')";
            $result = $this->command($sql);
            return $result;

        }

        //COURSE//


        function newCoursequery($coursename, $teacher)
        {
            $sql = "INSERT INTO course (coursename, teacher) VALUES ('" . $coursename . "', '" . $teacher . "')";
            $result = $this->command($sql);
            return $result;

        }

        function coursenameQuery($coursename)
        {
            $sql = "SELECT coursename FROM course WHERE coursename = '" . $coursename . "'";
            $result = $this->command($sql);


            if (count($result) > 0) {
                return false;

            } else {
                return true;
            }

        }

        function chooseCourse(){
            $sql = "SELECT * FROM course";
            $result = $this->command($sql);
            return $result;


        }

        //COMMENT//


        function newCommentquery($commentname, $userid, $taskid)
        {
            $sql = "INSERT INTO comment (comment, fk_userid, fk_taskid) VALUES ('" . $commentname . "', '" . $userid . "', '" . $taskid . "')";
            $result = $this->command($sql);
            return $result;
        }


        //SIGNUP//

        function registerQuery($username, $password, $mailadress, $admin)
        {
            $sql = "INSERT INTO users (username, password, mailadress, admin) VALUES ('" . $username . "', '" . $password . "', '" . $mailadress . "', '" . $admin . "')";
            $newuser = $this->command($sql);
            return $newuser;
        }

        function usernameAvailable($username)
        {
            $sql = "SELECT username FROM users WHERE username = '" . $username . "'";
            $result = $this->command($sql);


            if (count($result) > 0) {
                return true;
            } else {
                return false;
            }
        }

        function mailadressAvailable($mailadress)
        {
            $sql = "SELECT mailadress FROM users WHERE mailadress = '" . $mailadress . "'";
            $result = $this->command($sql);

            if (count($result) > 0) {
                return true;
            } else {
                return false;
            }
        }

        //LOGIN//

        function canloginQuery($username, $password)
        {
            $sql = "SELECT * FROM users WHERE username = '" . $username . "'";
            $result = $this->command($sql);

            if (count($result) > 0) {
                $hash = $result[0]['password'];
                $admin = $result[0]['admin'];

                if (password_verify($password, $hash)) {
                    $_SESSION['login_user'] = $result[0]['username'];
                    $_SESSION['user_id'] = $result[0]['userID'];
                    $_SESSION['loggedin'] = "yes";
                    $_SESSION['admin'] = $admin;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }



    }





?>