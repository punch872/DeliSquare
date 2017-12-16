<?php
/**
 * Created by PhpStorm.
 * User: sangrit
 * Date: 6/11/17
 * Time: 20:25
 */
$db =   new mysqli("localhost",'root','root','dev');

function ownfeatures()
{?>
    <?
    global $db;
    $user_id    = $_SESSION['user'][0];
    $profile_id = $_SESSION['user'][3];
    $shop_id    = $_SESSION['user'][4];

    $q = "
        SELECT * 
        FROM shop
        WHERE shop_id = '$shop_id'
    ";
    $shop = $db->query($q)->fetch_assoc();
    ?>
    <div class="card-panel row shop_pic_div center-align" >
        <a href="index.php">
            <img width="100" class="responsive-img circle center-align" src="<?=$shop['feature_pic']?>">
        </a>
        <a href="?feature=profile"><h5 class="center-align"><?=$shop['name']?></h5></a>
    </div>
    <ul class="row collapsible collapsible-accordion">
        <li>
            <div class="collapsible-header"><a href="?page=app&feature=dashboard"><i class="material-icons">dashboard</i>Dashboard</a></div>
        </li>
        <li>
            <div class="collapsible-header"><a href="?page=app&feature=menus"><i class="material-icons">restaurant_menu</i>Menu</a></div>
        </li>
        <li>
            <div class="collapsible-header"><a href="?page=app&feature=messages"><i class="material-icons">message</i>Message</a></div>
        </li>
        <li>
            <div class="collapsible-header"><a href="?page=app&feature=orders"><i class="material-icons">dvr</i>Order</a></div>
        </li>
    </ul>
<?}

function dinfeatures(){?>
    <ul class="collapsible collapsible-accordion">
        <li>
            <div class="collapsible-header waves-effect waves-teal"><i class="material-icons">restaurant_menu</i>Foods</a></div>
            <div class="collapsible-body"style="display: block;" >
                <ul>
                    <!--Search box = ongoing-->
                    <li><div class="collapsible-header waves-effect waves-teal"><a href="?page=app&feature=foods&sub=restaurants">>By Restaurants</a></div></li>
                    <li><div class="collapsible-header waves-effect waves-teal"><a href="?page=app&feature=foods&sub=menus">>By Menu</a></div></li>
                    <li><div class="collapsible-header waves-effect waves-teal"><a href="?page=app&feature=foods&sub=categories">>By Category</a></div></li>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header waves-effect waves-teal">
                <a href="?page=app&feature=dinorder">
                    <i class="material-icons">shopping_cart</i>Order
                </a>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><a href="?page=app&feature=messages"><i class="material-icons">message</i>Message</a></div>
        </li>
        <li>
            <div class="collapsible-header waves-effect waves-teal"><a href="?page=app&feature=userprofile"><i class="material-icons">account_circle</i>View Profile</a></div>
        </li>
    </ul>
    <?
}
function guestfeatures(){?>
    <ul class="collapsible collapsible-accordion">
        <li>
            <div class="collapsible-header waves-effect waves-teal"><i class="material-icons">restaurant_menu</i>Foods</a></div>
            <div class="collapsible-body"style="display: block;" >
                <ul>
                    <!--Search box = ongoing-->
                    <li><div class="collapsible-header waves-effect waves-teal"><a href="?page=guest&feature=foods&sub=restaurants">>By Restaurants</a></div></li>
                    <li><div class="collapsible-header waves-effect waves-teal"><a href="?page=guest&feature=foods&sub=menus">>By Menu</a></div></li>
                    <li><div class="collapsible-header waves-effect waves-teal"><a href="?page=guest&feature=foods&sub=categories">>By Category</a></div></li>
                </ul>
            </div>
        </li>
    </ul>
    <?
}
