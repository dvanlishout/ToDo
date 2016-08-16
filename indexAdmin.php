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


if(!empty($_POST["coursename"]) && !empty($_POST['teacher']) ) {

    try {
        $course = new Course();
        $course->Coursename = $_POST["coursename"];
        $course->Teacher = $_POST["teacher"];

        if ($course->addCourse()) {
            $feedback = "vak toegevoegd";
        } else {
            $feedback = "vaknaam is al gekozen";
        }
    }

    catch (Exception $e) {
        $error = $e->getMessage();
    }
}


else {
        $feedback = "vul alle velden in aub";
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



</head>
<body>


<div id="userInfo container">
    <div class="row">
        <h1 class="col-sm-10 "><?php echo $_SESSION['login_user'] ?></h1>
        <a class="col-sm-1" id="logout" href="logout.php">Log out</a>
    </div>

</div>





<div id="backgroundleft" class="container">


        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline row addList col-sm-4">
            <div class="row">
                <div class="col-sm-4 ">
                    <input class="form-control" type="text" name="coursename" id="coursename" placeholder="Vaknaam" />
                    <input class="form-control" type="text" name="teacher" id="teacher" placeholder="Docent" />
                </div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-6 ">
                        <input type="hidden" name="action" value="registreer">
                        <input type="submit" id="btnSignup" name="btnSignup" value="Vak aanmaken"  class="btn btn-default"/>
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
                $.each(data, function(i, field){

                    tekst2 = tekst2 + "- " + data[i].taskname ;
                    tekst2 = tekst2 + "<br />";



                });

                document.getElementById('taken').innerHTML = tekst2;
                $( "#taskform" ).show();


            }
        })
    }

    function dList(listID){
        var tekst3 = "";

        $.ajax
        ({
            type: "POST",
            url: "ajax/deleteList.php",
            data: "listID="+ listID,
            success: function(data){
                $.each(data, function(i, field){
                    tekst3 = tekst3 + "<a href=\"javascript: showTask(' "+data[i].listID+"')\">" + data[i].listname + "</a>"
                        + "<a href=\"javascript: deleteList(' "+data[i].listID+ "')\">" + "   DELETE" + "</a>";
                    tekst3 = tekst3 + "<br />";


                });

                document.getElementById('lijsten').innerHTML = "test";


            }
        })

    }


    $(document).ready(function(){
        $("#date").datepicker(
            {dateFormat: 'dd-mm-yy'}
        );
    });


</script>


</body>

</html>



