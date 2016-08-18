<?php
/**
 * Created by PhpStorm.
 * User: Ditte
 * Date: 31/07/16
 * Time: 14:27
 */


session_start();

// INCLUDE CLASSES
include_once("classes/user.class.php");
include_once("classes/db.class.php");
include_once("classes/validation.class.php");
require_once("classes/query.class.php");


// LOGIN


if (!empty($_SESSION)) {
    header("location: index.php");
}

if(!empty($_POST)){

    if($_POST['action'] === "inloggen") {

        if(!empty($_POST["username"]) && !empty($_POST["password"])) {

            try {
                $user = new User();
                $user->Username = $_POST["username"];
                $user->Password = $_POST["password"];

                $user->Canlogin();

            } catch (Exception $e) {
                $error = $e->getMessage();

            }
        }


        else{
                $feedback = "Please fill in all the fields";
            }
    }

}




?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ToDo - Login</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/loginstyle.css">


</head>
<body>

<div id="logoSlogan" class="container">
    <div class="row">
        <h1 class="logo col-md-6 col-sm-8 col-xs-9">To do.</h1>
        <a class="col-md-1 col-md-offset-5 col-sm-2 col-sm-offset-2 col-xs-2"  id="otherpage" href="signup.php">Sign up</a>
    </div>

    <div id="row">
        <h1 class="headline col-md-12">Welkom terug!</h1>
    </div>


        <br class="clearfix">

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
                <label for="Password" class="col-md-4 control-label">Paswoord</label>
                <div class="col-md-4 ">
                    <input class="form-control" type="password" name="password" id="password" placeholder="Wachtwoord" value="<?php if (isset($_POST['password'])) {
                        echo htmlspecialchars($_POST['password']); } ?>""  />
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-offset-5 col-md-4">
            <input type="hidden" name="action" value="inloggen">
            <input type="submit" name="btnLogin" value="Let's go"  class="btn btn-default"/>
                    </div>
                </div>



        </form>


</div>

    <?php if (isset($feedback)): ?>
        <div class="text-danger">
            <?php echo $feedback; ?>
        </div>
    <?php endif;?>

    <?php if (isset($error)): ?>
        <div class="text-danger">
            <p>
                <?php
                echo $error;
                ?>
            </p>
        </div>
    <?php endif ?>

</body>
</html>