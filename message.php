<?php
/**
 * Created by PhpStorm.
 * User: sangrit
 * Date: 18/11/17
 * Time: 20:00
 */

$db =   new mysqli("localhost",'root','root','dev');

$user_type  = $_SESSION['user'][2];

if(isset($_POST['action'])){
    if($_POST['action']=='reply' && $_POST['message']!=''){
        $message = $_POST['message'];
        $date    = date('Y-m-d');
        if($user_type=='owner'){
            $shop_id = $_SESSION['user'][4];
            $diner_id = $_POST['user_id'];
        }else
        if($user_type=='diner'){
            $shop_id = $_POST['user_id'];
            $diner_id = $_SESSION['user'][0];
        }
        $q="
          INSERT INTO message(user_id, shop_id, message, from_user)
          VALUES ($diner_id,$shop_id,'$message','$user_type')
        ";
        //print_r($q);
        $db->query($q);
    }
}

function showAllMessageView()
{?>
    <?
    global  $db;

    if($_SESSION['user'][2]=='owner'){
        $shop_id    = $_SESSION['user'][4];
        $q = "
            SELECT profile.user_id, profile.profile_name, message.created_date
            FROM message, profile
            WHERE message.shop_id=$shop_id AND profile.user_id=message.user_id
            GROUP BY message.user_id
            ORDER BY created_date DESC
        ";
    }else
    if($_SESSION['user'][2]=='diner'){
        $user_id    = $_SESSION['user'][0];
        $q = "
            SELECT shop.shop_id, shop.name,  message.created_date
            FROM message, shop
            WHERE message.shop_id=shop.shop_id AND message.user_id=$user_id
            GROUP BY message.shop_id
            ORDER BY created_date DESC
        ";
    }
    //print_r($q);
    $messages = $db->query($q);
    ?>
    <h1>Message</h1>
    <? if ($messages->num_rows==0) {
        echo "<h1>You have no message</h1>";
    }
    else{?>
        <table class="bordered highlight">
            <thead>
                <th><?=$_SESSION['user'][2]=='owner'?'From diners':'From shops'?></th>
                <th>Date</th>
            </thead>
        <?while($message=$messages->fetch_assoc()){
        ?>
            <tr><? if ($_SESSION['user'][2]=='owner'){?>
                    <td><?=$message['profile_name']?></td>
                    <td><?=$message['created_date']?></td>
                    <td><a href="?feature=messages&id=<?=$message['user_id']?>">Reply</a></td>
                <? }else {?>
                    <td><?=$message['name']?></td>
                    <td><?=$message['created_date']?></td>
                    <td><a href="?feature=messages&id=<?=$message['shop_id']?>">Reply</a></td>
                <?}?>
            </tr>
        <?}?>
        </table>
    <?}
}?>


<?
function showReadMessageView(){
?>
    <div class="container">
        <div class="row">
            <form method="post">
                <input type="hidden" name="user_id" value="<?=$_GET['id']?>">
                <div class="input-field col s9">
                    <input type="text"   name="message">
                </div>
                <div class="input-field  col s3">
                    <input type="submit" name="action" value="reply" class="btn blue right">
                </div>
            </form>
        </div>
        <?
        global $db;
        $user_type = $_SESSION['user'][2];
        if ($_SESSION['user'][2]=='owner'){
            $shop_id = $_SESSION['user'][4];
            $user_id = $_GET['id'];
        }else
        if($_SESSION['user'][2]=='diner'){
            $shop_id = $_GET['id'];
            $user_id = $_SESSION['user'][0];
        }
        $q = "
                SELECT *
                FROM message
                WHERE shop_id=$shop_id AND user_id=$user_id
                ORDER BY created_date DESC
            ";
        //print_r($q);
        $messages = $db->query($q);
        while ($message=$messages->fetch_assoc()){?>
            <div class="row">
                <?if ($user_type!=$message['from_user']){?>
                    <div class="col s6 left-align">
                        <?=$message['from_user']?>
                        <?=$message['message']?>
                    </div>
                    <div class="col s6">
                    </div>
                <?}else{?>
                    <div class="col s6">
                    </div>
                    <div class="col s6 right-align">
                        <?=$message['from_user']?>
                        <?=$message['message']?>
                    </div>
                <?}?>
            </div>
        <?}?>
    </div>
<?}