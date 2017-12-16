<?php
/**
 * Created by PhpStorm.
 * User: sangrit
 * Date: 19/11/17
 * Time: 21:02
 */

$db =   new mysqli("localhost",'root','root','dev');

$user_id    = $_SESSION['user'][0];
$profile_id = $_SESSION['user'][3];
$shop_id    = $_SESSION['user'][4];

function showAllOrderView()
{?>
    <?
    global $db;
    global  $shop_id;
    $q = "
        SELECT DISTINCT orders.order_id, orders.payment_method, orders.comments, orders.order_status, orders.total, orders.created_date as order_date, orders.shop_id, orders.user_id, user.*, profile.*, address.*
        FROM orders, shop, user, profile, address
        WHERE orders.shop_id='$shop_id'
        HAVING orders.user_id=user.user_id AND profile.user_id=user.user_id AND address.profile_id=profile.profile_id
        ORDER BY orders.created_date DESC
    ";
    $orders = $db->query($q);
    ?>
    <h1>Order</h1>
    <? if ($orders->num_rows==0) {
    echo "<h1>You have no orders</h1>";
}
else{?>
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s4"><a href="#all">All</a></li>
                <li class="tab col s4"><a href="#paid">Paid</a></li>
                <li class="tab col s4"><a href="#delivered">Delivered</a></li>
            </ul>
        </div>
        <div id="all" class="col s12">
            <ul class="collapsible" data-collapsible="accordion">
                <?while($order=$orders->fetch_assoc()){?>
                    <?
                    $order_id = $order['order_id'];
                    $q = "
                                SELECT *, ordermenu.amount*menu.price as total_menu_price
                                FROM ordermenu,menu
                                WHERE ordermenu.order_id='$order_id' AND ordermenu.menu_id=menu.menu_id
                            ";
                    $menus=$db->query($q);
                    //print_r($menus);
                    ?>
                    <li>
                        <div class="collapsible-header">
                            <div class="col">
                                <?=$order['profile_name']?>
                            </div>
                            <div class="col">
                                Total : <?=$order['total']?>
                            </div>
                            <div class="col">
                                Date : <?=$order['order_date']?>
                            </div>
                            <span class="new badge <?=$order['order_status']=="paid"?"red":($order['order_status']=="delivered"?"grey":($order['order_status']=="canceled"?"yellow":null))?>" data-badge-caption="<?=$order['order_status']?>"></span>
                        </div>
                        <div class="collapsible-body">
                            <div class="row">
                                <table class="striped">
                                    <thead>
                                    <th>Menu</th>
                                    <th>Amount</th>
                                    <th>Total Price</th>
                                    </thead>
                                    <?while($menu=$menus->fetch_assoc()){?>
                                        <tr>
                                            <td><a href="?feature=menus&q=edit&id=<?=$menu['menu_id']?>"><?=$menu['title']?></a></td>
                                            <td><?=$menu['amount']?></td>
                                            <td><?=$menu['total_menu_price']?></td>
                                        </tr>
                                    <?}?>
                                </table>
                            </div>
                            <div class="row">
                                Phone number : <?=$order['profile_phone'];?>
                            </div>
                            <div class="row">
                                Email : <?=$order['user_email'];?>
                            </div>
                            <div class="row">
                                Payment method : <?=$order['payment_method']?>
                            </div>
                            <div class="row">
                                Shipping address :
                                Street <?=$order['address_street']?>
                                District <?=$order['address_district']?>
                                City <?=$order['address_city']?>
                                Zipcode <?=$order['address_zipcode']?>
                            </div>
                            <div class="row">
                                Comment : <?=$order['comments']?>
                            </div>
                            <?if($order['order_status']!="delivered"){?>
                                <div class="row">
                                    <a href="<?=$_SERVER['REQUEST_URI']."&q=deliver&id=".$order['order_id']?>" class="btn red">deliver</a>
                                </div>
                            <?}?>
                        </div>
                    </li>
                <?}?>
            </ul>
        </div>
        <div id="paid" class="col s12">
            <ul class="collapsible" data-collapsible="accordion">
                <?
                $q = "
                    SELECT DISTINCT orders.order_id,orders.comments, orders.payment_method, orders.order_status, orders.total, orders.created_date as order_date, orders.shop_id, orders.user_id, user.*, profile.*, address.*
                    FROM orders, shop, user, profile, address
                    WHERE orders.shop_id='$shop_id' AND orders.order_status='paid'
                    HAVING orders.user_id=user.user_id AND profile.user_id=user.user_id AND address.profile_id=profile.profile_id
                    ORDER BY orders.created_date DESC
                ";
                $orders = $db->query($q);
                ?>
                <?while($order=$orders->fetch_assoc()){?>
                    <?
                    $order_id = $order['order_id'];
                    $q = "
                                SELECT *, ordermenu.amount*menu.price as total_menu_price
                                FROM ordermenu,menu
                                WHERE ordermenu.order_id='$order_id' AND ordermenu.menu_id=menu.menu_id
                            ";
                    $menus=$db->query($q);
                    //print_r($menus);
                    ?>
                    <li>
                        <div class="collapsible-header">
                            <div class="col">
                                <?=$order['profile_name']?>
                            </div>
                            <div class="col">
                                Total : <?=$order['total']?>
                            </div>
                            <div class="col">
                                Date : <?=$order['order_date']?>
                            </div>
                            <span class="new badge <?=$order['order_status']=="paid"?"red":($order['order_status']=="delivered"?"grey":($order['order_status']=="canceled"?"yellow":null))?>" data-badge-caption="<?=$order['order_status']?>"></span>
                        </div>
                        <div class="collapsible-body">
                            <div class="row">
                                <table class="striped">
                                    <thead>
                                    <th>Menu</th>
                                    <th>Amount</th>
                                    <th>Total Price</th>
                                    </thead>
                                    <?while($menu=$menus->fetch_assoc()){?>
                                        <tr>
                                            <td><a href="?feature=menus&q=edit&id=<?=$menu['menu_id']?>"><?=$menu['title']?></a></td>
                                            <td><?=$menu['amount']?></td>
                                            <td><?=$menu['total_menu_price']?></td>
                                        </tr>
                                    <?}?>
                                </table>
                            </div>
                            <div class="row">
                                Phone number : <?=$order['profile_phone'];?>
                            </div>
                            <div class="row">
                                Email : <?=$order['user_email'];?>
                            </div>
                            <div class="row">
                                Payment method : <?=$order['payment_method']?>
                            </div>
                            <div class="row">
                                Shipping address :
                                Street <?=$order['address_street']?>
                                District <?=$order['address_district']?>
                                City <?=$order['address_city']?>
                                Zipcode <?=$order['address_zipcode']?>
                            </div>
                            <div class="row">
                                Comment : <?=$order['comments']?>
                            </div>
                            <?if(!$order['order_status']=="delivered"){?>
                                <div class="row">
                                    <a href="<?=$_SERVER['REQUEST_URI']."&q=deliver&id=".$order['order_id']?>" class="btn red">deliver</a>
                                </div>
                            <?}?>
                        </div>
                    </li>
                <?}?>
            </ul>
        </div>
        <div id="delivered" class="col s12">
            <ul class="collapsible" data-collapsible="accordion">
                <?
                $q = "
                    SELECT DISTINCT orders.order_id, orders.payment_method, orders.comments, orders.order_status, orders.total, orders.created_date as order_date, orders.shop_id, orders.user_id, user.*, profile.*, address.*
                    FROM orders, shop, user, profile, address
                    WHERE orders.shop_id='$shop_id' AND orders.order_status='delivered'
                    HAVING orders.user_id=user.user_id AND profile.user_id=user.user_id AND address.profile_id=profile.profile_id
                    ORDER BY orders.created_date DESC
                ";
                $orders = $db->query($q);
                ?>
                <?while($order=$orders->fetch_assoc()){?>
                    <?
                    $order_id = $order['order_id'];
                    $q = "
                                SELECT *, ordermenu.amount*menu.price as total_menu_price
                                FROM ordermenu,menu
                                WHERE ordermenu.order_id='$order_id' AND ordermenu.menu_id=menu.menu_id
                            ";
                    $menus=$db->query($q);
                    //print_r($menus);
                    ?>
                    <li>
                        <div class="collapsible-header">
                            <div class="col">
                                <?=$order['profile_name']?>
                            </div>
                            <div class="col">
                                Total : <?=$order['total']?>
                            </div>
                            <div class="col">
                                Date : <?=$order['order_date']?>
                            </div>
                            <span class="new badge <?=$order['order_status']=="paid"?"red":($order['order_status']=="delivered"?"grey":($order['order_status']=="canceled"?"yellow":null))?>" data-badge-caption="<?=$order['order_status']?>"></span>
                        </div>
                        <div class="collapsible-body">
                            <div class="row">
                                <table class="striped">
                                    <thead>
                                    <th>Menu</th>
                                    <th>Amount</th>
                                    <th>Total Price</th>
                                    </thead>
                                    <?while($menu=$menus->fetch_assoc()){?>
                                        <tr>
                                            <td><a href="?feature=menus&q=edit&id=<?=$menu['menu_id']?>"><?=$menu['title']?></a></td>
                                            <td><?=$menu['amount']?></td>
                                            <td><?=$menu['total_menu_price']?></td>
                                        </tr>
                                    <?}?>
                                </table>
                            </div>
                            <div class="row">
                                Phone number : <?=$order['profile_phone'];?>
                            </div>
                            <div class="row">
                                Email : <?=$order['user_email'];?>
                            </div>
                            <div class="row">
                                Payment method : <?=$order['payment_method']?>
                            </div>
                            <div class="row">
                                Shipping address :
                                Street <?=$order['address_street']?>
                                District <?=$order['address_district']?>
                                City <?=$order['address_city']?>
                                Zipcode <?=$order['address_zipcode']?>
                            </div>
                            <div class="row">
                                Comment : <?=$order['comments']?>
                            </div>
                            <?if(!$order['order_status']=="delivered"){?>
                                <div class="row">
                                    <a href="<?=$_SERVER['REQUEST_URI']."&q=deliver&id=".$order['order_id']?>" class="btn red">deliver</a>
                                </div>
                            <?}?>
                        </div>
                    </li>
                <?}?>
            </ul>
        </div>
    </div>
<?}
}?>

<?
function showOrderDeliverView(){
    global $db;
    $order_id = $_GET['id'];
    $q="
        UPDATE orders
        SET orders.order_status='delivered'
        WHERE orders.order_id='$order_id'
    ";
    $db->query($q);
    if(!$db->error){
        echo "<p>Order has been delivered</p>";
        echo "<a href='?feature=orders'>back</a>";
    }
}
?>


