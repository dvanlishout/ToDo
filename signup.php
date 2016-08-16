<?php


// INCLUDE CLASSES
include_once("classes/db.class.php");
include_once("classes/user.class.php");
include_once("classes/validation.class.php");
include_once("classes/query.class.php");




// ON POST FORM: REGISTER USER

if (!empty($_SESSION)) {
    header("location: index.php");
}

if( !empty($_POST) ) {


    if( !empty($_POST["username"]) && !empty($_POST['password'])  && !empty($_POST['mail']) ) {

        try {
            $user = new User();
            $user->Username = $_POST["username"];
            $user->Password = $_POST["password"];
            $user->Mailadress = $_POST["mail"];
            $admin = 0;
            $user->Register($admin);

              } //INSERT USER INTO TABLE


        catch(Exception $e) {
            $error = $e->getMessage();
        }

        }





     else {

        $_SESSION['loginfeedback'] = "Please fill in all the fields.";

    }



}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ToDo - Plan your life</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">



</head>
<body>

    <div id="logoSlogan" class="container">
        <div class="logo row">To do.</div>
        <div id="whatever"><h1 class="row">Als je de bomen door het bos niet meer ziet.</h1></div>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal container">
    <div class="form-group ">

        <label for="username" class="col-md-4 control-label">Uw naam</label>
        <div class="col-md-4">
            <input class="form-control" type="text" name="username" id="username" placeholder="Uw voornaam en naam" value="<?php if (isset($_POST['username'])) {
                echo htmlspecialchars($_POST['username']);
            } ?>""/>
        </div>
    </div>


    <div class="form-group">
        <label for="Email" class="col-md-4 control-label">Email</label>
        <div class="col-md-4 ">
            <input class="form-control" type="text" name="mail" id="mail" placeholder="Mailadress" value="<?php if (isset($_POST['mail'])) {
                echo htmlspecialchars($_POST['mail']); } ?>"" />
        </div>
    </div>


    <div class="form-group">
        <label for="Password" class="col-md-4 control-label">Paswoord</label>
        <div class="col-md-4 ">
            <input class="form-control" type="password" name="password" id="password" placeholder="Wachtwoord" value="<?php if (isset($_POST['password'])) {
                echo htmlspecialchars($_POST['password']); } ?>""  />
        </div>
    </div>


    <div class="form-group">
        <div class="col-md-offset-5 col-md-4">
            <input type="hidden" name="action" value="registreer">
            <input type="submit" id="btnSignup" name="btnSignup" value="Profiel aanmaken"  class="btn btn-default"/>
        </div>
    </div>





            <div class="usernameFeedback"><span></span></div>
            <?php if(isset($_SESSION['loginfeedback'])): ?>
                <div class="feedback"><?php echo $_SESSION['loginfeedback']; ?></div>
            <?php else: ?>
                <!--<div class="feedback">Gelieve alle velden in te vullen</div>-->
            <?php endif; ?>
        </form>







    </div>

    <!--Feedback section-->

    <?php if (isset($feedback)): ?>
        <div class="feedback">
            <?php echo $feedback; ?>
        </div>
    <?php endif;?>

    <?php if (isset($error)): ?>
        <div class="bg-danger text-danger">
            <p>
                <?php
                echo $error;
                ?>
            </p>
        </div>
    <?php endif ?>





</body>
</html>