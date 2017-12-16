<?php
/**
 * Created by PhpStorm.
 * User: sangrit
 * Date: 19/11/17
 * Time: 21:03
 */

$db =   new mysqli("localhost",'root','root','dev');

$user_id    = $_SESSION['user'][0];
$profile_id = $_SESSION['user'][3];
$shop_id    = $_SESSION['user'][4];

function showAllDashboardView()
{?>
    <?
    global $db;
    global $shop_id;


    // Order
    /*$q = "
        SELECT count(order_status) as count,'status'
        FROM orders
        WHERE orders.shop_id='$shop_id'
        UNION
        SELECT count(order_status) as count,order_status
        FROM orders
        WHERE orders.shop_id='$shop_id'
        GROUP BY orders.order_status
    ";*/

    // Ordered using showOrderedSummary view
    $q="
        SELECT *
        FROM showOrderedSummary
        WHERE shop_id=$shop_id
    ";
    $orders=$db->query($q);
    while($order=$orders->fetch_assoc()){
        if($order['status']=='status')
            $total_order = $order['count'];
        if($order['status']=='paid')
            $total_paid = $order['count'];
        if($order['status']=='delivered')
            $total_delivered = $order['count'];
    }

    // User
    $q = "
        SELECT *
        FROM orders
        WHERE shop_id='$shop_id'
        GROUP BY user_id
    ";
    $user = $db->query($q);

    // Income
    $q = "
        SELECT SUM(total) AS total
        FROM orders
        WHERE orders.shop_id=$shop_id
    ";
    $income = $db->query($q)->fetch_assoc();
    //print_r($income);

    // All menus
    $q = "
      SELECT *
      FROM menu
      WHERE shop_id = '$shop_id'
    ";
    $menus = $db->query($q);

    // Top 3 ordered menus using showOrdredMenus view
    $q = "
        SELECT * 
        FROM showOrderedMenus
        WHERE  shop_id=$shop_id
        ORDER BY amount_of_ordered DESC 
        LIMIT 3
    ";
    $top_3_menus = $db->query($q);

    // Summary of payments
    $q = "
        SELECT payment_method, count(*) as count_payment_method, SUM(total) as total, avg(total) as average
        FROM orders
        WHERE shop_id=$shop_id
        GROUP BY payment_method
    ";
    $payments = $db->query($q);

    //print_r($q);
    ?>
    <h1>Dashboard</h1>
    <div class="row">
        <div class="col s12 m6">
            <div class="card-panel">
                <span class="pink-text">Overview of orders</span>
                <table>
                    <tr>
                        <td>Total number of orders</td>
                        <td><span class="orange-text accent-4"><?=$total_order!=null?$total_order:0?></span></td>
                    </tr>
                    <tr>
                        <td>Total number of paid orders</td>
                        <td><span class="orange-text accent-4"><?=$total_paid!=null?$total_paid:0?></span></td>
                    </tr>
                    <tr>
                        <td>Total number of delivered orders</td>
                        <td><span class="orange-text accent-4"><?=$total_delivered!=null?$total_delivered:0?></span></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card-panel">
                <span class="pink-text">Overview of customers</span>
                <table>
                    <tr>
                        <td>Total number of customers : </td>
                        <td><span class="orange-text accent-4 left"><?=$user->num_rows?></span></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card-panel">
                <h6>Total income : <span class="orange-text accent-4"><?=$income['total']!=null?$income['total']:0?> $</span></h6>
            </div>
        </div>
    </div>
    <div class="col s12">
        <div class="col s12">
        <?
            if ($menus->num_rows==0){
        ?>
            <div class="card-panel">
                <div class="row center-align">
                    <p>You have no any menus.</br>Plase add a new one.</p>
                    <a class="btn-floating" href="?feature=menus&q=add"><i class="material-icons">add</i></a>
                </div>
            </div>
        <?  }
            else {
                echo '<div class="row"><span class="pink-text">Top 3 ordered menus</span></div>';
                while ($menu = $top_3_menus->fetch_assoc()) {
                    //print_r($menu);
                    ?>
                    <a href="<?=$_SERVER['REQUEST_URI'].'&q=menusummary&id='.$menu['menu_id'].'&pic='.$menu['pic'].'&title='.$menu['title']?>">
                    <div class="col s12 m4">
                        <div class="card hoverable">
                            <div class="card-image">
                                <img src="<?= $menu['pic'] ?>" height="200px">
                            </div>
                            <div class="card-content">
                                <span class="card-title orange-text"><?=$menu['title']?></span>
                                <span class="black-text">Amount of ordered :</span>
                                <span class="pink-text"><?= $menu['amount_of_ordered'] ?></span>
                            </div>
                        </div>
                    </div>
                    </a>
                <?
                }
            }
        ?>
        </div>
    </div>
    <div class="col s12">
        <span class="pink-text">Payment</span>
        <table class="striped">
            <thead>
                <th>Method of payment</th>
                <th>Number of payment</th>
                <th>Average income</th>
                <th>Total income</th>
            </thead>
            <?
                $methods = array(
                        'visa' => 'Visa',
                        'cash' => 'Cash'
                );
                while ($payment=$payments->fetch_assoc()){
                    //print_r($payment);?>
                    <tr>
                        <td><?=$methods[$payment['payment_method']]?></td>
                        <td><?=$payment['count_payment_method']?></td>
                        <td><?=$payment['average']?></td>
                        <td><?=$payment['total']?></td>
                    </tr>
                <?
                }
            ?>
        </table>
    </div>
<?}

function showMenuSummaryView(){
    global $db;
    global $shop_id;

    $menu_id = $_GET['id'];
    $q = "
        SELECT profile_name,ordered.amount
        FROM profile,
          (
              SELECT ordermenu.order_id,orders.user_id, menu.menu_id,sum(ordermenu.amount) AS amount
              FROM menu,ordermenu,orders
              WHERE menu.menu_id = ordermenu.menu_id AND orders.order_id = ordermenu.order_id AND menu.menu_id=$menu_id
              GROUP BY user_id
          ) ordered
        WHERE profile.user_id=ordered.user_id        
    ";
    $customers=$db->query($q);

    $q="
        SELECT SUM(ordermenu.amount)/total_orderd.total*100 AS percent
        FROM ordermenu,
          (
           SELECT sum(amount) as total
           FROM orders, ordermenu
           WHERE shop_id=$shop_id AND orders.order_id = ordermenu.order_id
          ) total_orderd
        WHERE ordermenu.menu_id=$menu_id
    ";
    $result=$db->query($q)->fetch_assoc();
    ?>
    <div class="col s12">
        <h2 class="header">Ordering summary</h2>
        <div class="col s12 m3">
            <div class="card">
                <div class="card-image">
                    <img src="<?=$_GET['pic']?>" class="circle responsive-img">
                </div>
                <div class="card-content center-align">
                    <span class="card-title orange-text"><?=$_GET['title']?></span>
                    <?=$result['percent']?>% of orders
                </div>
            </div>
        </div>
        <div class="col s12 m9 card-panel">
            <table class="highlight responsive-table">
                <thead>
                    <th>Customers</th>
                    <th>Amount of orders</th>
                </thead>
                <?
                    while($customer=$customers->fetch_assoc()){
                    ?>
                        <tr>
                            <td><?=$customer['profile_name']?></td>
                            <td><?=$customer['amount']?></td>
                        </tr>
                    <?}
                ?>
            </table>
        </div>
    </div>
    <?
}
