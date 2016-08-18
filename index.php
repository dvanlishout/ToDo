<?php

session_start();

include_once("classes/db.class.php");
include_once("classes/user.class.php");
include_once("classes/task.class.php");
include_once("classes/validation.class.php");
include_once("classes/list.class.php");
include_once("classes/course.class.php");
include_once("classes/comment.class.php");



if(empty($_SESSION['login_user'])){
    header('location: login.php');
};





    if (!empty($_POST["listname"]) && !empty($_POST["coursename"])) {
        try {
            $list = new TodoList();
            $list->Listname = $_POST["listname"];
            $courseID = $_POST["coursename"];
            $list->addList($courseID);
            header("location: index.php");
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }



if(!empty($_POST["taskname"])&& !empty($_POST["datepicker"])) {

    try{
        $task = new Tasks();
        $task->Taskname = $_POST["taskname"];
        $task->Date = $_POST["datepicker"];
        $task->addTask();
        header('location: index.php');

    }
    catch (Exception $e){
        $error = $e->getMessage();
    }

}


if(!empty($_POST["commentname"])) {
    try{
        $comment = new Comment();
        $comment->Commenttext = $_POST["commentname"];
        $comment->addComment();
        header("location: index.php");
    }

    catch (Exception $e){
        $error = $e->getMessage();
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Feed</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/indexstyle.css">
    <script language="JavaScript" type="text/javascript" src="js/jquery-2.2.2.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css"
          href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>



<div class="container-fluid">
    <div class="row">
        <h1 class="col-md-9 col-sm-8 col-xs-9 headerHome"><?php echo $_SESSION['login_user'] ?></h1>
        <a class="col-md-1 col-md-offset-1 col-sm-2  col-xs-2"  id="otherpage" href="logout.php">Log out</a>
    </div>
</div>

<?php if (isset($error)): ?>

    <div class="text-danger feedback">
        <p>
            <?php
            echo $error;
            ?>
        </p>
    </div>
    <?php endif ?>


<div class="container">
    <div class="leftForm row col-md-3">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="row">
                    <input class="form-control" type="text" name="listname" id="listname" placeholder="lijst naam" value="<?php if (isset($_POST['listname'])) {
                        echo htmlspecialchars($_POST['listname']); } ?>" />
            </div>

            <div class="row">
                    <label for="coursename" class="control-label">Vaknaam</label>
                    <select name="coursename">
                        <?php
                        $course = new Course();
                        $row = $course->listCourse();
                        $i = 0;
                        foreach ($row as $r)
                        {
                            echo "<option value=".$row[$i]['courseID'].">".$row[$i]['coursename']."</option>";
                            $i++;
                        }
                        ?>
                    </select>
            </div>

            <div class="row">
                <div class="formknop">
                    <input type="hidden" name="action" value="lijstAanmaken">
                    <input type="submit" id="btnSignup" name="btnList" value="Lijst aanmaken"  class="btn btn-default"/>
                </div>
            </div>
        </form>
    </div>

    <div class="taskform">
        <div class="row col-md-3 col-md-offset-2">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="row">
                        <input class="form-control" type="text" name="taskname" id="taskname" placeholder="Taak naam" value="<?php if (isset($_POST['taskname'])) {
                            echo htmlspecialchars($_POST['taskname']); } ?>" />
                        <p>Date: </p> <input type="text" id="taskdate" name="datepicker">
                    </div>

                <div class="row">
                    <div class="formknop">
                        <input type="hidden" name="action" value="taakAanmaken">
                        <input type="submit" id="btnCreateTask" name="btnCreateTask" value="Taak aanmaken"  class="btn btn-default" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="commentform">
        <div class="row col-md-3 col-md-offset-1">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="row">
                    <input class="form-control" type="text" name="commentname" id="commentname" placeholder="Jouw comment" value="<?php if (isset($_POST['commentname'])) {
                        echo htmlspecialchars($_POST['commentname']); } ?>" />
                </div>

                <div class="row">
                    <div class="formknop">
                        <input type="hidden" name="action" value="registreer">
                        <input type="submit" id="btnCreateComment" name="btnCreateComment" value="Versturen"  class="btn btn-default" />
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>




<div class="container">
    <div class="row">
        <div id="lijsten" class="col-sm-4"></div>
        <div id="taken" class="col-sm-4"></div>
        <div id="opmerkingen" class="col-sm-4">
            <p>opmerkingen</p>
        </div>
    </div>
</div>


<script>
    $( function() {
        $( "#taskdate" ).datepicker({ dateFormat: 'dd-mm-yy' });
    } );


    function getStatus(taskID){

        $.ajax
        ({
            type: "POST",
            url: "ajax/getStatus.php",
            data: "taskID="+ taskID,
            success: function(data){

                //document.getElementById().addClass("strike");
                $( '#' + taskID ).toggleClass( "strike" );
                $('#' + taskID ).blur()

            }
        })
    }

    function showList(){
        var tekst= "";


        $.ajax
        ({
            type: "GET",
            url: "ajax/showlist.php",
            success: function(data){
                $.each(data, function(i, field){
                    courseID = data[i].FK_courseID;
                    coursename = getCourseName(courseID);




                    tekst = tekst + "<a href=\"javascript: showTask('"+data[i].listID+"')\">" + coursename + ' ' + data[i].listname +  "</a>"
                    + "<a href=\"javascript: dList('"+data[i].listID+ "')\">" + "   X" + "</a>";
                    tekst = tekst + "<br />";
                });
                document.getElementById('lijsten').innerHTML = tekst;
            }
        })
    }

    showList();


    function showTask(listID){
        var tekst2 = "";


        $.ajax
        ({
            type: "POST",
            url: "ajax/showtask.php",
            data: "listID="+ listID,
            success: function(data){

                $.each(data, function(i, field){
                    taskID = data[i].taskID;
                    taskname = data[i].taskname;
                    status = data[i].status;
                    deadline = data[i].deadline;
                    day = deadline.substring(8,10);
                    month = deadline.substring(5,7);
                    daycount = getStress(deadline);




                    if (status == "1"){
                        tekst2 = tekst2 + "<a class='strike task' id='" + taskID + "' href=\"javascript: getStatus("+data[i].taskID+")\">" + data[i].taskname +  ' ' + daycount + " days " + "</a>";
                    }else{
                        tekst2 = tekst2 + "<a class='task' id='" + taskID + "' href=\"javascript: getStatus("+data[i].taskID+")\">" + data[i].taskname + ' ' + daycount + " days" +  "</a>";
                    }

                    tekst2 = tekst2 + "<a class='showcomment' id='" + 'showcomment' + taskID + "' href=\"javascript: showComment("+data[i].taskID+")\">" +' comments' + "</a><br />";




                });


                $( ".taskform" ).show();
                document.getElementById('taken').innerHTML = tekst2;


            }
        })
    }

    function getCourseName(courseID){
       var coursename = "";

        $.ajax
        ({
            type: "POST",
            url: "ajax/getCoursename.php",
            async: false,
            data: "courseID="+ courseID,
            success: function(data){

                coursename = data[0].coursename;



            }


        });
        return coursename;





    }

    function dList(listID){

        $.ajax
        ({
            type: "POST",
            url: "ajax/deleteList.php",
            data: "listID="+ listID,
            success: function(data){
                showList();


            }
        });

        $( ".taskform" ).hide();
        $( ".commentform" ).hide();
        $( "#opmerkingen" ).hide();
        $( "#taken" ).hide();



    }

    function showComment(taskID){
        var comment = "";

        $.ajax
        ({
            type: "POST",
            url: "ajax/showcomment.php",
            data: "taskID="+ taskID,
            success: function(data){
                $.each(data, function(i, field){
                    commentvalue = data[i].commenttext;
                    userid = data[i].FK_userID;
                    username = getUserName(userid);
                    commentid = data[i].commentid;

                    comment = comment + "<p>" + username + ": " +commentvalue + "</p>";



                });
                document.getElementById('opmerkingen').innerHTML = comment;
                $( ".commentform" ).show();
                $( "#opmerkingen" ).show();
            }
        })


    }

    function getUserName(userID){
        var username = "";

        $.ajax
        ({
            type: "POST",
            url: "ajax/getUsername.php",
            async: false,
            data: "userID="+ userID,
            success: function(data){

                username = data[0].username;

            }


        });
        return username;

    }

    function getStress(deadline){
        var stress="";

        $.ajax
        ({
            type: "POST",
            url: "ajax/getDeadline.php",
            async: false,
            data: "deadline="+ deadline,
            success: function(data){

                stress = data;

            }


        });
        return stress;



    }









</script>
</body>
</html>



