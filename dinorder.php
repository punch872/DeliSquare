<?php
/**
 * Created by PhpStorm.
 * User: punchok
 * Date: 22/11/17
 * Time: 13:11
 */

$db = new mysqli("localhost",'root','root','dev');
$user_id    =   $_SESSION['user'][0];
$profile_id =   $_SESSION['user'][3];
$address_id =   $_SESSION['user'][4];
function showCart(){?>
    <? global $db;
    global $user_id;
    $tax        =   3.60;
    $shipping   =   15.00;
    $subtotal   =   0;
    $q = "
        SELECT *
        FROM cart
        LEFT JOIN menu ON cart.menu_id=menu.menu_id
        WHERE user_id=$user_id
    ";
    $carts =  $db->query($q);
    ?>
    <div class="card" >
        <h3 class="amber-text" style="font-weight: bold">Order&Checkout</h3>
        <div class="onepage-checkout">
            <div class="pure-g-r">
                <div class="pure-u-1-2">
                    <div class="wrapper wrapper__gamma">
                        <h2 class="__alpha">Cart</h2>
                        <table class="">
                            <thead>
                            <tr>
                                <th>Article(s)</th>
                                <th>Total(s)</th>
                                <th></th>
                            </tr>
                            </thead>
                            <?while ($order = $carts->fetch_assoc()){?>
                                <tr class="wrapper--box">
                                    <td class="alpha">
                                        <div class="pure-g">
                                            <div class="pure-u-1-4">
                                                <img src='<?=$order['pic']?>'>
                                            </div>
                                            <div class="pure-u-3-4">
                                                <div class="helper--alpha">
                                                    <h3><?=$order['title']?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="alpha">
                                        <?$subtotal+=$order['price']?>
                                        $<?=$order['price']?>
                                    </td>
                                    <td class="alpha">
                                        <a class="btn" href="?feature=dinorder&q=remove&id=<?=$order['cart_id']?>">remove</a>
                                    </td>
                                </tr>
                            <?}?>
                            <tr>
                                <td colspan="3"><hr></td>
                            </tr>
                            <tr>
                                <th colspan='2'>Subtotal</th>
                                <td>$<?=$subtotal?></td>
                            </tr>
                            <tr>
                                <th colspan='2'>Sales Tax</th>
                                <td>$<?=$tax?></td>
                            </tr>
                            <tr>
                                <th colspan='2'>Shipping</th>
                                <td>$<?=$shipping?></td>
                            </tr>
                            <tr class="alpha">
                                <th colspan='2'>Total</th>
                                <td>$<?=$subtotal+$tax+$shipping?><td>
                            </tr>
                        </table>
                    </div>
                    <?
                        $q = "SELECT address.address_street,address.address_district,address.address_city,address.address_state,address.address_zipcode FROM address,profile,user WHERE address.profile_id = profile.profile_id AND profile.user_id = user.user_id";
                        $address = $db->query($q);
                        $row = $address->fetch_assoc()
                    ?>
                    <div class="pure-u-1-1">
                        <h3 class="amber-text" style="font-weight: bold">Shipping Address</h3>
                        <div class="wrapper wrapper__alpha">
                            <div class="row">
                                <div class="col s12">
                                    <div class="input-field col s6">
                                        <input  value= "<?=$row['address_street']?>" id="addstreet" type="text" class="validate" disabled>
                                        <label for="disabled">Address Street</label>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field col s6">
                                        <input  value= "<?=$row['address_district']?>" id="adddistrict" type="text" class="validate" disabled>
                                        <label for="disabled">Address District</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input  value= "<?=$row['address_city']?>" id="addcity" type="text" class="validate" disabled>
                                        <label for="disabled">Address City</label>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field col s6">
                                        <input  value= "<?=$row['address_state']?>" id="addstate" type="text" class="validate" disabled>
                                        <label for="disabled">Address State</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input  value= "<?=$row['address_zipcode']?>" id="addzip" type="text" class="validate" disabled>
                                        <label for="disabled">Address Zipcode</label>
                                    </div>
                                </div>
                            </div>
                            <div class="btn" ><a class="white-text waves-effect" href="?page=app&feature=userprofile&q=edit">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Payment -->
                <h3 class="amber-text" style="font-weight: bold">Order&Checkout</h3>
                <div class="pure-u-1-1">
                    <div class="row">
                        <form class="col s12" method="post">
                            <p>
                                <input type="radio" name="payment" id="visa" value="visa" required/>
                                <label for="visa"><i class="material-icons">credit_card</i>Visa</label>
                            </p>
                            <p>
                                <input type="radio" name="payment" id="cash" value="cash" required/>
                                <label for="cash"> <i class="material-icons">attach_money</i>Cash</label>
                            </p>
                            <input class="btn" type="submit" name='checkout' value="checkout">
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    </div>
    </div>
<?}
function addToOrder(){
    ?>
    <?
    global $db;
    global $user_id;
    $shop_id    =   $_GET['shop_id'];
    $menu_id    =   $_GET['menu_id'];
    $q="
        INSERT INTO cart(user_id,shop_id,menu_id)
        VALUES ($user_id,$shop_id,$menu_id)
    ";
    //print_r($q);
    $db->query($q);
    showCart();
    ?>
<?}
function removeFromOrder(){
    ?>
    <?
    global $db;
    global $user_id;
    $cart_id    =   $_GET['id'];
    $q="
        DELETE FROM cart
        WHERE cart.cart_id = $cart_id
    ";
    //print_r($q);
    $db->query($q);
    showCart();
}
function checkout(){
    global $db;
    global $user_id;
    global $address_id;
    //print_r('checkout');
    //print_r($_POST);
    $payment = $_POST['payment'];
    $q = "
        SELECT cart.shop_id, SUM(menu.price) as total
        FROM cart
        LEFT JOIN menu ON cart.menu_id=menu.menu_id
        WHERE user_id=$user_id
        GROUP BY cart.shop_id
    ";
    //print_r($q);
    $rows = $db->query($q);
    while($row=$rows->fetch_assoc()){
        //print_r($row);
        $shop_id = $row['shop_id'];
        $total   = $row['total'];
        $q = "
          INSERT INTO orders(user_id,shop_id,shipping_address,billing_address,payment_method,order_status,total)
          VALUES ($user_id,$shop_id,$address_id,$address_id,'$payment','paid',$total)
        ";
        //print_r($q);
        $result = $db->query($q);
        $q = "
            SELECT order_id
            FROM orders
            WHERE shop_id=$shop_id AND user_id=$user_id
            ORDER BY created_date DESC 
            LIMIT 1
        ";
        //print_r($q);
        $result = $db->query($q);
        $order_id = $result->fetch_assoc()['order_id'];
        $q = "
            SELECT cart.menu_id
            FROM cart
            LEFT JOIN menu ON cart.menu_id=menu.menu_id
            WHERE cart.shop_id=$shop_id AND cart.user_id=$user_id
        ";
        //print_r($q);
        $menus = $db->query($q);
        while($menu=$menus->fetch_assoc()){
            //print_r($menu);
            $menu_id = $menu['menu_id'];
            $q = "
                INSERT INTO ordermenu(order_id,menu_id)
                VALUES ($order_id,$menu_id)
            ";
            //print_r($q);
            $db->query($q);
        }
    }
    $q="
        DELETE FROM cart
        WHERE user_id=$user_id
    ";
    $db->query($q);
    //print_r($q);
    print_r("Checkout completed");
}
?>







