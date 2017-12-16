<?php
if (isset($_SESSION['user'])){
    include('controllers/app.php');
}else{
    ?>
    <div>
        <div class="slider">
            <ul class="slides">
                <li>
                    <img src="./images/burger.jpg">
                    <div class="caption center-align">
                        <h1 class="header center teal-text text-lighten-2">DeliSquare Delivery</h1>
                        <h5 class="header col s12 light">Faster.Easier.More.</h5>
                        <a href="index.php?page=signin" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Get Started</a>

                    </div>
                </li>
                <li>
                    <img src="./images/sushi.jpg">
                    <div class="caption left-align">
                        <h4 class="deep-orange-text text-darken-4">New way to order<br> your favourite dishs</h4>
                        <h5 class="light teal-text text-darken-3">Just seaching and order.<br>Then wait for yummy.</h5>
                    </div>
                </li>
                <li>
                    <img src="./images/tomyum.jpg">
                    <div class="caption right-align">
                        <h4>Tons of food <br>wait for you</h4>
                    </div>
                </li>
            </ul>
        </div>

        <br>

        <div class="container">
            <div>
                <h2 style="text-align:center;font-weight: bold"> More than 3 thousand menus </div>
            </h2>
        </div>

        <div class="row" >
            <?
            $q = "
              SELECT * 
              FROM category
            ";
            $categories = $db->query($q);
            $count=0;
            ?>
            <?
                while ($category=$categories->fetch_assoc()){?>
                    <div class="col s4">
                        <div class="card">
                            <div class="con">
                                <img src="<?=$category['feature_pic']?>" class="imm" style=" width: 100%"  >
                                <div class="mid">
                                    <div class="txt<?=$count++%6?>"><?=$category['title']?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?}
            ?>
        </div>
    </div>

    <br>

    <div class="section">
    <!--   Icon Section   -->

    <div class="carousel carousel-slider center" data-indicators="true" style="height: 200px;width:auto">
        <div class="carousel-item red amber-text"  href="#one!">
            <h2 style="font-weight: bold">30 Minutes confirm</h2>
            <p >We will serve your order as fast as possible.If we can't serve in half an hour, we will give you the coupon for free.</p>
            <a class="center-align amber-text"><i class="material-icons large">flash_on</i></a>
        </div>
        <div class="carousel-item green  amber-text" style="" href="#two!">
            <h2 style="font-weight: bold">Best for our customer</h2>
            <p >Our website try to serve you the delicious food as the medium for your value customer and the shop’s owner</p>
            <h2 class="center amber-text"><i class="large material-icons">group</i></h2>
        </div>
        <div class="carousel-item blue amber-text"  href="#one!">
            <h2 style="font-weight: bold">Easy to work with</h2>
            <p >We have provided detailed documentation as well as specific code examples to help new users get started. We are also always open to feedback and can answer any questions a user may have about Materialize.</p>
            <a class="center-align amber-text"><i class="material-icons large">face</i></a>
        </div>
    </div>

    <div class="container section">
        <?
        $q = "
              SELECT * 
              FROM category
            ";
        $categories = $db->query($q);
        ?>
        <div class="col s12">
            <h2 style="font-weight: bold"> Quick options</h2>
            <div class="row">
                <?
                while ($category=$categories->fetch_assoc()){?>
                    <div class="chip">
                        <?=$category['title']?>
                    </div>
                <?}
                ?>
            </div>
        </div>
    </div>
    <div style="background-color: #5C6BC0" class="section">
        <h2 class="amber-text container" style="font-weight: bold">Who are you?</h2>
        <div class="row container">
            <div class="col s6">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator cpic"   src="./images/owner.jpg">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Restaurant Owner</span>
                        <p><a href="?page=signin">Get start!</a></p>
                    </div>
                </div>
            </div>
            <div class="col s6">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator cpic" src="./images/Customer.jpg">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Diner</span>
                        <p><a href="?page=signin">Get start!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?}
