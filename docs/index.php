<?php
session_start();

include ("components/features.php");
include ("controllers/cardMenu.php");
//diner
include ("controllers/diner.php");
include ("controllers/restaurants.php");
include ("controllers/userprofile.php");
include ("controllers/dinmenu.php");
include ("controllers/category.php");
include("controllers/dinorder.php");
include "controllers/shipping.php";
include "controllers/payment.php";

// For owner
include ("controllers/owner.php");
include ("controllers/dashboard.php");
include ("controllers/menu.php");
include ("controllers/message.php");
include ("controllers/order.php");
//print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>DeliSquare</title>
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<? include ('components/header.php'); ?>
<!-- Container -->
<?
    if(isset($_GET['page'])){
        include ('controllers/'.$_GET['page'].'.php');
    }
    else{
        include('controllers/landing.php');
    }
?>
<? include ('components/footer.php'); ?>
<!--  Scripts-->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
</body>
</html>
