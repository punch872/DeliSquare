<?php
/**
 * Created by PhpStorm.
 * User: punchok
 * Date: 27/11/17
 * Time: 01:14
 */
$db = new mysqli("localhost",'root','root','dev');
$user_id = $_SESSION['user'][0];
$profile_id = $_SESSION['user'][3];
    global $db;
    global $user_id;
    global $profile_id;
    $profile_name = $_POST["profile_name"];
    $user_id=$_POST['user_id'];
    $user_email = $_POST['user_email'];
    $profile_id=$_POST['profile_id'];
    $profile_type = $_POST['profile_type'];
    $profile_bio = $_POST['profile_bio'];
    $address_type = $_POST['address_type'];
    $address_street = $_POST['address_street'];
    $address_district= $_POST['address_district'];
    $address_zipcode= $_POST['address_zipcode'];
    /* $target_dir     = "/Applications/MAMP/htdocs/dev/uploads/user/diner";
     $path_dir       = "uploads/user/diner".$_FILES["profile_pics"]['name'];
     $target_file    = $target_dir.basename($_FILES["profile_pics"]['name']);

     move_uploaded_file($_FILES['user_pic']["name"],$target_file);*/
    $q1 = " UPDATE  profile
           SET profile_name='$profile_name', profile_bio='$profile_bio',
           WHERE profile_id = '$profile_id'";
    $db ->query($q1);
    $q2 = " UPDATE  address
           SET address_type='$address_type',address_street =' $address_street',
           address_district='$address_district', address_zipcode = '$address_zipcode' 
           WHERE profile_id ='$profile_id' ";
    $db ->query($q2);
    $q3 = " UPDATE  user
           SET user_email='$user_email'
           WHERE user_id = '$user_id'";
    $db ->query($q3);
