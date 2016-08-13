<?php
/**
 * Created by PhpStorm.
 * User: Ditte
 * Date: 05/08/16
 * Time: 11:48
 */

session_start();

include_once("classes/db.class.php");
include_once("classes/user.class.php");
include_once("classes/validation.class.php");
include_once("classes/list.class.php");
include_once("classes/task.class.php");

if(!empty($_POST)) {
    $task = new Task();
    $task->Taskname = $_POST["taskname"];

        $task->getListId();
        $task->NewTask(); //INSERT USER INTO TABLE

        header('Location: index.php');


    };




?>

    <!DOCTYPE html>
    <html lang="en" xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="UTF-8">
        <title>Your Feed</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">


    </head>
    <body>



    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal container">
        <div class="form-group ">

            <label for="ListName" class="col-md-4 control-label">Taak</label>
            <div class="col-md-4">
                <input class="form-control" type="text" name="taskname" id="taskname" placeholder="Taak" />
            </div>
        </div>




        <div class="form-group">
            <div class="col-md-offset-5 col-md-4">
                <input type="hidden" name="action" value="registreer">
                <input type="submit" id="btnSignup" name="btnSignup" value="Taak aanmaken"  class="btn btn-default"/>
            </div>
        </div>

        <?php if(isset($feedback)): ?>
            <div class="feedback"><?php echo $feedback; ?></div>
        <?php else: ?>
            <!--<div class="feedback">Gelieve alle velden in te vullen</div>-->
        <?php endif; ?>
    </form>

    </body>

    </html>

<?php
/**
 * Created by PhpStorm.
 * User: Ditte
 * Date: 05/08/16
 * Time: 17:13
 */