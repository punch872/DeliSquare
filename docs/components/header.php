<?php
/**
 * Created by PhpStorm.
 * User: sangrit
 * Date: 6/10/17
 * Time: 11:27
 */

// Connection to database
$db =   new mysqli("localhost",'root','root','dev');
?>
<header>
<nav class="teal" role="navigation">
    <div class="nav-wrapper container">
    <?php
        if (isset($_SESSION['user'])){
    ?>
        <a id="logo-container" href="index.php" class="brand-logo" ><img src="images/deli-logo.png" align="top" height="90" width="100" ></a>
        <a href="#" data-activates="mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <!-- dropdown-->
            <li><a href="?page=logout" class="white-text">Logout</a></li>
        </ul>
        <!--navbar -->
        <ul  class="left side-nav" id="mobile">
            <br>
            <!-- dropdown-->
                <li><a href="?page=logout">Logout</a></li>
        </ul>
    <?
        }else{
    ?>
        <a id="logo-container" href="index.php" class="brand-logo" ><img src="images/deli-logo.png" align="top" height="90" width="100" ></a>
        <a href="#" data-activates="mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <!-- dropdown-->
            <!--<li><a href="?page=guest&feature=foods&sub=menus" class="white-text">Foods</a></li>-->
            <li><a href="?page=signin" class="white-text" >Sign In/Sign Up</a></li>

        </ul>
        <!--navbar -->
        <ul  class="left side-nav" id="mobile">
            <br>
            <!--<li><a href="?page=guest&feature=foods&sub=menus" class="black-text">Foods</a></li>-->
            <li><a href="?page=signin" class="black-text" >Sign In/Sign Up</a></li>
        </ul>
    <?
        }
    ?>
    </div>
</nav>
</header>