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

        function getCoursename($fk_courseID){
            $sql = "SELECT coursename FROM course WHERE courseID = '" . $fk_courseID . "'";
            $result = $this->command($sql);
            return $result;
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
            $taskids = $q->getTaskID($listID);


            if(count($taskids) > 0){

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

        function getTaskID($listID)
        {
            $sql = "SELECT taskID FROM task WHERE fk_listID = '" . $listID . "'";
            $result = $this->command($sql);
            foreach($result as $row) {
                $q =new query;
                $q->deleteComment($row["taskID"]);
            }
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

        function getCourse()
        {
            $sql = "SELECT * FROM course ";
            $result = $this->command($sql);
            return $result;
        }





        //COMMENT//


        function newCommentquery($commentname, $userid, $taskid)
        {
            $sql = "INSERT INTO comment (commenttext, fk_userid, fk_taskid) VALUES ('" . $commentname . "', '" . $userid . "', '" . $taskid . "')";
            $result = $this->command($sql);
            return $result;
        }

        function getComment($taskid) {
            $sql = "SELECT * FROM comment WHERE FK_taskID = '" . $taskid . "' ";
            $result = $this->command($sql);
            return $result;
        }

        function getUsername($userid){
            $sql = "SELECT username FROM users WHERE userID = '" . $userid . "'";
            $result = $this->command($sql);
            return $result;

        }

        function deleteComment($taskid){
            $sql3 = "DELETE FROM comment WHERE fk_taskID = '" . $taskid . "'";
            $q = new dbconnect();
            $q->run($sql3);
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

        //course delete//
        function getListIDZ($courseID)
        {
            $sql = "SELECT * FROM list WHERE fk_courseID = '" . $courseID . "'";
            $result = $this->command($sql);
            foreach($result as $row) {
                $q =new query;
                $q->getTaskIDZ($row["listID"]);
            }
            return $result;
        }

        function getTaskIDZ($listid)
        {
            $sql = "SELECT * FROM task WHERE fk_listID = '" . $listid . "'";
            $result = $this->command($sql);
            foreach($result as $row) {
                $q =new query;
                $q->deleteCommentz($row["taskID"]);
                $q->deleteTaskz($row["taskID"]);
            }
            return $result;
        }


        function deleteCommentz($taskID){
            $sql = "DELETE FROM comment WHERE fk_taskID = '" . $taskID . "'";
            $q = new dbconnect();
            $q->run($sql);
        }

        function deleteTaskz($taskID){
            $sql = "DELETE FROM task WHERE taskID = '" . $taskID . "'";
            $q = new dbconnect();
            $q->run($sql);
        }



        function deleteCourse($courseID)
        {
            $q = new query;
            $result = $q->getListIDZ($courseID);
            echo 'yello';

            if (count($result) > 0) {
                $sql = "DELETE FROM list WHERE fk_courseID = '" . $courseID . "'";
                $q = new dbconnect();
                $q->run($sql);
            }

            $sql = "DELETE FROM course WHERE courseID = '" . $courseID . "'";
            $q = new dbconnect();
            $q->run($sql);
        }
    }












?>