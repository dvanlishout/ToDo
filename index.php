<?php

session_start();

include_once("classes/db.class.php");
include_once("classes/user.class.php");
include_once("classes/validation.class.php");
include_once("classes/list.class.php");




if(empty($_SESSION['login_user'])){
    header('location: login.php');
};




if(!empty($_POST)) {
    $list = new TodoList();
    $list->Listname = $_POST["listname"];

    if ($list->ListnameAvailable()) {
        $feedback = "Listname already taken";
    } else {
        $list->NewList(); //INSERT USER INTO TABLE


    }
}




?>




});


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



</head>
<body>
<div id="userInfo">
    <p><?php echo $_SESSION['login_user'] ?></p>
</div>

<div id="backgroundleft">


    <a id="logout" href="logout.php">Log out</a>



<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline container addList">
    <div class="row">
    <div class="form-group">


        <div class="col-xs-1">
            <input class="form-control" type="text" name="listname" id="listname" placeholder="Titel" />
        </div>
    </div>




    <div class="form-group">
        <div class="col-xs-1 ">
            <input type="hidden" name="action" value="registreer">
            <input type="submit" id="btnSignup" name="btnSignup" value="Lijst aanmaken"  class="btn btn-default"/>
        </div>
    </div>
    </div>

    <?php if(isset($feedback)): ?>
        <div class="feedback"><?php echo $feedback; ?></div>
    <?php else: ?>
        <!--<div class="feedback">Gelieve alle velden in te vullen</div>-->
    <?php endif; ?>
</form>



</div>

<div id="lijst"></div>

<script>
    var tekst = "";



    function toonLijst(userID){
        $.ajax
        ({
            type: "POST",
            url: "ajax/showlist.php",
            data: "userID="+ userID,
            success: function(data){
                $.each(data, function(i, field){
                    tekst = data[i].listname;
                });
                document.getElementById('lijst').innerHTML = tekst;
            }
        })
    }

    toonLijst();


</script>
    <?php
    /*$options = $options = [
        'cost' => 12,
    ];

    if(count($error) == 0){
        //alle gegevens zijn ingevuld, wachtwoord decrypten
        $p_password_encrypt = password_hash($p_password, PASSWORD_DEFAULT, $options);
    }*/
    ?>




</body>

</html>



