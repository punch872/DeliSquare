<?php
/**
 * Created by PhpStorm.
 * User: boycatbay
 * Date: 21/11/60
 * Time: 12:29
 */
$db = new mysqli('localhost','root','root','dev');

function showByCategories(){
    global $db;
    $q="
        SELECT * 
        FROM category
    ";
    $categories = $db->query($q);
    $categories_array = array();
?>
    <br>
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <?while ($category=$categories->fetch_assoc()){//print_r($category);
                    $categories_array[$category['category_id']]=$category['title'];
                ?>
                    <li class="tab col s6 m4 l2"><a href="#<?=$category['title']?>"><?=$category['title']?></a></li>
                <?}?>
            </ul>
        </div>
        <?
            //print_r($categories_array);
            foreach ($categories_array as $id=>$title){
                ?>
                    <div id="<?=$title?>">
                        <?=showMenu($id)?>
                    </div>
                <?
            }
        ?>
    </div>

<?}

function showMenu($category){?>
<?
global $db;
$categories = $category;
$category_menu_limit = 30;
$q1 = "SELECT menu_id FROM menu WHERE menu.category_id = $categories";

$category_menu_num = $db->query($q1);
$category_menu_count = mysqli_num_rows($category_menu_num);

if( isset($_GET{'current'} ) ) {
    $current = $_GET{'current'} + 1;
    $offset = $category_menu_limit * $current ;
}else {
    $current = 0;
    $offset = 0;
}
$category_menu_left = $category_menu_count - (($current+1) * $category_menu_limit);

$q2 = "SELECT * FROM menu WHERE menu.category_id = $categories LIMIT $offset,$category_menu_limit";

$category_menus = $db->query($q2);
?>
<div class="row">
    <?
    while ($category_menu=$category_menus->fetch_assoc()) {
        cardMenu(
            $category_menu['shop_id'],
            $category_menu['menu_id'],
            $category_menu['pic'],
            $category_menu['title'],
            $category_menu['price'],
            $category_menu['description']
        );
    }
    ?>
</div>
<?}