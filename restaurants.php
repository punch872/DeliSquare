<?php
/**
 * Created by PhpStorm.
 * User: punchok
 * Date: 16/11/17
 * Time: 23:06
 */
$db = new mysqli("localhost",'root','root','dev');

// Show all Resturant//
function showAllRestaurants(){
    ?>

    <?
    global $db ;
    $restaurant_limit = 5;
    $q1 = "SELECT * FROM shop";
    $restaurants_num = $db->query($q1);
    $restaurant_count = mysqli_num_rows($restaurants_num);
    if( isset($_GET{'current'} ) ) {
        $current = $_GET{'current'} + 1;
        $offset = $restaurant_limit * $current ;
    }else {
        $current = 0;
        $offset = 0;
    }

    $restaurant_left = $restaurant_count - (($current+1) * $restaurant_limit);
    $q2 = "
      SELECT * FROM shop LIMIT $offset,$restaurant_limit
    ";
    $restaurants = $db->query($q2);
    ?>
    <div class="container row owner-container">
        <h2 class="header">Restaurants</h2>
        <? while ($restaurant = $restaurants->fetch_assoc()) { ?>
            <div class="col s12 m6">
                <div class="card horizontal valign-wrapper hoverable">
                    <div class="card-image">
                        <img width="100%" src="<?= $restaurant['feature_pic'] ?>">
                    </div>
                    <div class="card-stacked">
                        <div class="card-content">
                            <p class="red-text"><?=$restaurant['name']?></p>
                            <p><?=$restaurant['description']?>
                                <a href="?feature=foods&sub=restaurants&id=<?=$restaurant['shop_id']?>">More</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
    <?
    if($_GET['page']=='guest'){
        $page = "guest";
    }else{
        $page = "app";
    }
    if($current == 0 && $restaurant_left > 0) {
        echo "<a href = \"?page=$page&feature=foods&sub=restaurants&current=$current\">Next Pages</a>";
    }else if($current != 0 && $restaurant_left <= $restaurant_limit ) {
        $last = $current - 2;
        echo "<a href = \"?page=$page&feature=foods&sub=restaurants&current=$last\">Last Pages</a>";
    }else if($current > 0){
        $last = $current - 2;
        echo "<a href = \"?page=$page&feature=foods&sub=restaurants&current=$last\">Last Pages</a> |";
        echo "<a href = \"?page=$page&feature=foods&sub=restaurants&current=$current\">Next Pages</a>";
    }
    ?>
<?}?>

<?function showRestaurant(){
    ?>
    <?
    global $db;
    $shop_id = $_GET['id'];

    $q="
        SELECT *
        FROM shop
        WHERE shop_id=$shop_id
        ";
    $shop=$db->query($q)->fetch_assoc();

    $q="
        SELECT *
        FROM menu
        WHERE shop_id=$shop_id;
    ";
    $menus=$db->query($q);
    ?>
    <!-- shop pic reference from db -->
        <div class="card">
            <div class="row">
                <div class="card-content">
                    <img src="<?=$shop['feature_pic']?>" height="300" width="100%">
                    <div class="section white">
                        <div class="row" >
                            <!-- Restaurant name reference from db-->
                            <h2><?=$shop['name']?></h2>
                            <hr>
                            <!-- description reffernce from db -->
                            <p class="grey-text text-darken-3 lighten-3"><?=$shop['description']?></p>
                        </div>
                    </div>

                    <!-- Menu Section reference from db -->
                    <h3>Menu</h3>
                    <hr>
                    <div class="row">
                        <?while ($menu=$menus->fetch_assoc()){
                            cardMenu(
                                $menu['shop_id'],
                                $menu['menu_id'],
                                $menu['pic'],
                                $menu['title'],
                                $menu['price'],
                                $menu['description']
                            );
                        }?>
                    </div>
                </div>
            </div>
        </div>
        </div>
<?}?>




