<?php
/**
 * Created by PhpStorm.
 * User: boycatbay
 * Date: 20/11/60
 * Time: 23:25
 */
$db = new mysqli('localhost','root','root','dev');
$user_id  = $_SESSION['user'][0];


function showAllMenus(){
    ?>
    <? global $db ;
    $menu_limit = 12;
    $q1 = "SELECT * FROM menu";
    $menu_num = $db->query($q1);
    $menu_count = mysqli_num_rows($menu_num);

    if( isset($_GET{'current'} ) ) {
        $current = $_GET{'current'} + 1;
        $offset = $menu_limit * $current ;
    }else {
        $current = 0;
        $offset = 0;
    }
    $menu_left = $menu_count - (($current+1) * $menu_limit);
    $q2 = "SELECT * FROM menu LIMIT $offset,$menu_limit";
    $menus = $db->query($q2);
    if($_GET['page']=='guest'){
        $page = "guest";
    }else{
        $page = "app";
    }
    ?>
    <div class="row">
        <?
            while ($menu=$menus->fetch_assoc()){
                cardMenu(
                    $menu['shop_id'],
                    $menu['menu_id'],
                    $menu['pic'],
                    $menu['title'],
                    $menu['price'],
                    $menu['description']
                );
            }
        ?>

    </div>

    <div class="center-align">
        <?
        if($current == 0 && $menu_left > 0) {
            echo "<a href = \"?page=$page&feature=foods&sub=menus&current=$current\">Next </a>";
        }else if($current != 0 && $menu_left <= $menu_limit ) {
            $last = $current - 2;
            echo "<a href = \"?page=$page&feature=foods&sub=menus&current=$last\">Back</a>";
        }else if($current > 0){
            $last = $current - 2;
            echo "<a href = \"?page=$page&feature=foods&sub=menus&current=$last\">Back</a> | ";
            echo "<a href = \"?page=$page&feature=foods&sub=menus&current=$current\">Next</a>";
        }
        ?>
    </div>
<?}