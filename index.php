<?php

session_start();

include_once("classes/db.class.php");
include_once("classes/user.class.php");
include_once("classes/task.class.php");
include_once("classes/validation.class.php");
include_once("classes/list.class.php");
include_once("classes/course.class.php");



if(empty($_SESSION['login_user'])){
    header('location: login.php');
};


if(!empty($_POST["listname"] )) {
    try{
        $list = new TodoList();
        $list->Listname = $_POST["listname"];
        $courseID = $_POST["coursename"];

        if ($list->addList($courseID)){
            $feedback = "lijst toegevoegd";
        }

        else{
            $feedback = "lijstnaam is al gekozen";
        }

    }

    catch (Exception $e){
        $error = $e->getMessage();

    }


}


if(!empty($_POST["taskname"])&& !empty($_POST["datepicker"])) {

    try{
        $task = new Tasks();
        $task->Taskname = $_POST["taskname"];
        $task->Date = $_POST["datepicker"];

        $task->addTask();


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



<div id="userInfo container">
    <div class="row">
        <h1 class="col-sm-10 "><?php echo $_SESSION['login_user'] ?></h1>
        <a class="col-sm-1" id="logout" href="logout.php">Log out</a>
    </div>
</div>


<div id="backgroundleft" class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline row addList col-sm-8">
        <div class="row form-group">
            <div class="col-sm-4 ">
                <input class="form-control" type="text" name="listname" id="listname" placeholder="lijst naam" />
            </div>

            <div class="col-sm-4 col-sm-offset-3">
                <input type="hidden" name="action" value="registreer">
                <input type="submit" id="btnSignup" name="btnSignup" value="Lijst aanmaken"  class="btn btn-default"/>
            </div>
         </div>

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

        <?php if(isset($feedback)): ?>
            <div class="feedback"><?php echo $feedback; ?></div>
        <?php else: ?>
        <?php endif; ?>
    </form>


    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline row col-sm-4  taskform">
       <div class="row">
            <div class="col-sm-4 ">
                <input class="form-control" type="text" name="taskname" id="taskname" placeholder="Taak naam" />
                <p>Date: </p> <input type="text" id="taskdate" name="datepicker">
            </div>




            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-6 ">
                    <input type="hidden" name="action" value="registreer">
                    <input type="submit" id="btnCreateTask" name="btnCreateTask" value="Taak aanmaken"  class="btn btn-default"/>
                </div>
            </div>
        </div>




        <?php if(isset($feedback)): ?>
            <div class="feedback"><?php echo $feedback; ?></div>
        <?php else: ?>

        <?php endif; ?>
    </form>



</div>


<div class="container">
    <div class="row">
        <div id="lijsten" class="col-sm-4"></div>
        <div id="taken" class=" row col-sm-4"></div>
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
                    tekst = tekst + "<a href=\"javascript: showTask('"+data[i].listID+"')\">" + data[i].listname + "</a>"
                    + "<a href=\"javascript: dList('"+data[i].listID+ "')\">" + "   DELETE" + "</a>";
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
                console.log(data[0]);
                $.each(data, function(i, field){
                    taskID = data[i].taskID;
                    taskname = data[i].taskname;
                    status = data[i].status;
                    date = [data][i].deadline;





                    if (status == "1"){
                        tekst2 = tekst2 + "<a class='strike' id='" + taskID + "' href=\"javascript: getStatus("+data[i].taskID+")\">" + data[i].taskname + "</a><br />";
                    }else{
                        tekst2 = tekst2 + "<a id='" + taskID + "' href=\"javascript: getStatus("+data[i].taskID+")\">" + data[i].taskname + "</a><br />";
                    }






                });

                document.getElementById('taken').innerHTML = tekst2;
                $( ".taskform" ).show();

            }
        })
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
        })

    }








</script>
</body>
</html>



