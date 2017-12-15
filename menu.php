<?php
/**
 * Created by PhpStorm.
 * User: sangrit
 * Date: 6/11/17
 * Time: 20:22
 */

$db =   new mysqli("localhost",'root','root','dev');

$user_id    = $_SESSION['user'][0];
$profile_id = $_SESSION['user'][3];
$shop_id    = $_SESSION['user'][4];

$menu_id = $_GET['id'];

$q = "
        SELECT * 
        FROM category
    ";
$categories = $db->query($q);

if(isset($_POST['action'])){
    if($_POST['action']=='add'){
        $title          =   $_POST['title'];
        $price          =   $_POST['price'];
        $description    =   $_POST['description'];
        $category_id    =   $_POST['category_id'];
        $date           =   date('Y-m-d');

        $target_dir     = "/Applications/MAMP/htdocs/dev/uploads/menu/";
        $path_dir       = "uploads/menu/".basename($_FILES["menu_pic"]['tmp_name']);
        $target_file    = $target_dir.basename($_FILES["menu_pic"]['tmp_name']);

        move_uploaded_file($_FILES['menu_pic']["tmp_name"],$target_file);

        $q = "
            INSERT INTO menu(shop_id,category_id,title,price,pic,description,created_dated,updated_dated)
            VALUES (
              '$shop_id',
              '$category_id',
              '$title',
              '$price',
              '$path_dir',
              '$description',
              '$date',
              '$date'
            )
        ";
        $result = $db->query($q);
        if(!$db->error){
            header("location: index.php?feature=menus");
        }else{
            print_r($db->error);
        }
    }elseif($_POST['action']=='edit'){
        $title          =   $_POST['title'];
        $price          =   $_POST['price'];
        $description    =   $_POST['description'];
        $category_id    =   $_POST['category_id'];
        $date           =   date('Y-m-d');

        if ($_FILES['menu_pic']['size']==0){
            $q = "
            UPDATE menu
            SET title='$title', price='$price', description='$description', category_id='$category_id', updated_dated='$date'
            WHERE menu_id = '$menu_id'
        ";
        }
        else{
            $target_dir     = "/Applications/MAMP/htdocs/dev/uploads/menu/";
            $path_dir       = "uploads/menu/".basename($_FILES["menu_pic"]['tmp_name']);
            $target_file    = $target_dir.basename($_FILES["menu_pic"]['tmp_name']);
            move_uploaded_file($_FILES['menu_pic']["tmp_name"],$target_file);

            $q = "
            UPDATE menu
            SET title='$title', price='$price', description='$description', category_id='$category_id', pic='$path_dir', updated_dated='$date'
            WHERE menu_id = '$menu_id'
        ";
        }
        $db->query($q);
        if ($db->error){
            echo $db->error;
        }
    }
}

function showAllMenuView()
{
    ?>
    <?
    global $db;
    global $user_id;
    global $profile_id;
    global $shop_id;
    $q = "
          SELECT *
          FROM menu
          WHERE shop_id = '$shop_id'
        ";

    $menus = $db->query($q);
    ?>
    <h1>Menu</h1>
    <?
    if ($menus->num_rows == 0) {?>
        <div class="col s12">
            <div class="card-panel">
                <div class="row center-align">
                    <p>You have no any menus.</br>Plase add a new one</p>
                    <a class="btn-floating" href="<?=$_SERVER['REQUEST_URI'].'&q=add'?>"><i class="material-icons">add</i></a>
                </div>
            </div>
        </div>
    <?} else {
        echo "<div class='row'>";
        while ($menu = $menus->fetch_assoc()) {
        ?>
        <div class="col s12 m4">
            <div class="card hoverable">
                <div class="card-image">
                    <img src="<?=$menu['pic']?>" height="200">
                    <a class="btn-floating halfway-fab waves-effect waves-light green"
                       href="<?=$_SERVER['REQUEST_URI'] . "&q=edit&id=" . $menu['menu_id']?>"><i class="material-icons">mode_edit</i></a>
                </div>
                <div class="card-content">
                    <span class="card-title black-text"><?= $menu['title'] ?> <?= $menu['price'] ?>$</span>
                    <p><?= $menu['description'] ?></p>
                </div>
                <div class="card-action center-align">
                    <a href="<?=$_SERVER['REQUEST_URI']."&q=remove&id=".$menu['menu_id']?>" class="red-text">remove</a>
                </div>
            </div>
        </div>
        <?
        }
        echo "</div>";
        ?>
        <div class="fixed-action-btn">
            <a class="btn-floating blue" href="<?=$_SERVER['REQUEST_URI'].'&q=add'?>"><i class="material-icons">add</i></a>
        </div>
    <?}?>
<?}

function showAddMenuView()
{?>
<?
    global $db;
    global $categories;
    $user_id = $_SESSION['user'][0];
    $q = "
        SELECT * 
        FROM menu m 
        WHERE s.shop_id = (
          SELECT s.shop_id
          FROM shop s 
          WHERE s.profile_id = (
            SELECT p.profile_id
            FROM profile p
            WHERE p.user_id=$user_id
      )
    )
    ";
    $menus = $db->query($q);
?>
    <h1>Add Menu</h1>
    <div class="container">
    <form method="post" enctype='multipart/form-data'>
        <div class="input-field col s6">
            <input name="title" type="text" id="title">
            <label for="title">Title</label>
        </div>
        <div class="input-field col s6">
            <select name="category_id">
                <option value="" disabled selected>Choose your option</option>
                <?while ($category = $categories->fetch_assoc()){
                ?>
                    <option value="<?=$category['category_id']?>"><?=$category['title']?></option>
                <?}?>
            </select>
            <label>Category</label>
        </div>
        <div class="input-field col s12">
            <textarea id="description" class="materialize-textarea" name="description"></textarea>
            <label for="description">Description</label>
        </div>
        <div class="col s12 m6 file-field input-field">
            <div class="btn">
                <span>File</span>
                <input type="file" name="menu_pic" id="menu_pic">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Upload a picture">
            </div>
        </div>
        <div class="input-field col s6">
            <input name="price" type="number" id="price">
            <label for="price">Price</label>
        </div>
        <div class="input-field col s12">
            <input class="col s12 btn"type="submit" value="add" name="action">
        </div>
    </form>
    </div>
<?}

function showEditMenuView(){?>
<?
    global $db;
    global $user_id;
    global $profile_id;
    global $shop_id;
    global $categories;

    $menu_id = $_GET['id'];
    $q = "
        SELECT * 
        FROM menu
        WHERE shop_id = $shop_id AND menu_id = $menu_id
    ";

    $menu = $db->query($q)->fetch_assoc();
?>
    <h1>Edit Menu</h1>
    <div class="container center-align">
        <img class="materialboxed" width="400" src="<?=$menu['pic']?>">
        <form method="post" enctype='multipart/form-data'>
            <div class="input-field col s6">
                <input name="title" type="text" id="title" value="<?=$menu['title']?>">
                <label for="title">Title</label>
            </div>
            <div class="input-field col s6">
                <select name="category_id">
                    <option value="" disabled selected>Choose your option</option>
                    <?while ($category = $categories->fetch_assoc()){?>
                        <option value="<?=$category['category_id']?>" <?=$category['category_id']==$menu['category_id']?selected:null?>><?=$category['title']?></option>
                    <?}?>
                </select>
                <label>Category</label>
            </div>
            <div class="input-field col s12">
                <textarea id="description" class="materialize-textarea" name="description"><?=$menu['description']?></textarea>
                <label for="description">Description</label>
            </div>
            <div class="col s12 m6 file-field input-field">
                <div class="btn">
                    <span>File</span>
                    <input type="file" name="menu_pic" id="menu_pic">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Upload new picture">
                </div>
            </div>
            <div class="input-field col s6">
                <input name="price" type="number" id="price" value=<?=$menu['price']?>>
                <label for="price">Price</label>
            </div>
            <div class="input-field col s12">
                <input type="submit" value="edit" class="btn blue left" name="action">
            </div>
        </form>
    </div>
<?}

function showRemoveMenuView(){
?>
    <?
        global $db;
        $menu_id = $_GET['id'];
        $q = "
            DELETE FROM menu
            WHERE menu_id = $menu_id
        ";
        //print_r($q);
        $db->query($q);
        header('location: ?feature=menus');
    ?>
<?}