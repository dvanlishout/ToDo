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

if(!empty($_POST)) {

    if (!empty($_POST["coursename"]) && !empty($_POST['teacher'])) {

        try {
            $course = new Course();
            $course->Coursename = $_POST["coursename"];
            $course->Teacher = $_POST["teacher"];


            if ($course->addCourse()) {
                $feedback = "vak toegevoegd";
            }

        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    else {
        $error = "vul alle velden in aub";
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



</head>
<body>


<div class="container-fluid">
    <div class="row">
        <h1 class="col-md-9 col-sm-8 col-xs-9 headerHome"><?php echo $_SESSION['login_user'] ?></h1>
        <a class="col-md-1 col-md-offset-1 col-sm-2  col-xs-2"  id="otherpage" href="logout.php">Log out</a>
    </div>
</div>



<div class="leftForm container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="row">
                <div class="col-sm-4 ">
                    <label for="coursename" class="col-md-4 control-label">Vaknaam</label>
                    <input class="form-control" type="text" name="coursename" id="coursename" placeholder="Vaknaam" />
                    <label for="teacher" class="col-md-4 control-label">Docent</label>
                    <input class="form-control" type="text" name="teacher" id="teacher" placeholder="Docent" />
                </div>
            </div>

            <div class="row">
                    <div class="col-sm-4 formknop ">
                        <input type="hidden" name="action" value="vakAanmaken">
                        <input type="submit" id="btn" name="btnCourse" value="Vak aanmaken"  class="btn btn-default"/>
                    </div>
                </div>
        </form>
</div>





<?php if (isset($error)): ?>
    <div class="container">
        <div class="text-danger row col-sm-6 feedback">
        <p>
            <?php
            echo $error;
            ?>
        </p>
    </div>
<?php endif ?>

<div class="container">
    <div class="row">
        <div class="col-sm-6"
        <div id="vakken">
        </div>
    </div>
</div>



<script>
    function showCourse(){
        var tekst= "";


        $.ajax
        ({
            type: "GET",
            url: "ajax/showcourse.php",
            success: function(data){
                $.each(data, function(i, field){
                    courseID = data[i].courseID;
                    coursename = data[i].coursename;


                    tekst = tekst + coursename
                        + "<a href=\"javascript: dCourse('"+courseID+ "')\">" + "   X" + "</a>";
                    tekst = tekst + "<br />";
                });
                document.getElementById('vakken').innerHTML = tekst;
            }
        })
    }

    showCourse();

    function dCourse(courseID){

        $.ajax
        ({
            type: "POST",
            url: "ajax/deleteCourse.php",
            data: "courseID="+ courseID,
            success: function(data){
                showCourse();
                alert(data);

            }
        });

    }





</script>



</body>

</html>



