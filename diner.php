<?php
/**
 * Created by PhpStorm.
 * User: punchok
 * Date: 16/11/17
 * Time: 22:40
 */
function diner()
{?>
    <div class="row">
        <div class="col s4 m3 l2">
            <?
            dinfeatures(); ?>
        </div>
        <div class="col s8 m9 l10">
            <?
            if($_GET['feature']=='foods') {
                if($_GET['sub']=='restaurants'){
                    if (!isset($_GET['id'])){
                        showAllRestaurants();
                    }else
                    if (isset($_GET['id'])){
                        showRestaurant();
                    }
                }else
                if($_GET['sub']=='menus'){
                    showAllMenus();
                    if($_GET['a']=='add'){
                        addToCart();
                    }
                }else
                if($_GET['sub']=='categories'){
                    showByCategories();
                    if($_GET['a']=='add'){
                        addToCart();
                    }
                }
            }elseif ($_GET['feature']=='userprofile'){
                if(!isset($_GET['q'])){
                    showUserProfile();
                }
                if($_GET['q']=='edit') {
                    editUserProfile();
                    if ($_GET['a'] == 'update') {
                        updateprofile();
                    }
                }
            }else
                if($_GET['feature']=='dinrestaurant'){
                    showRestaurantDetail();
                }
            else
            if (($_GET['feature']=='dinorder')){
                if(isset($_POST['checkout'])){
                    checkout();
                }else
                if(!isset($_GET['q'])){
                    showCart();
                }else
                if ($_GET['q']=='add'){
                    addToOrder();
                }else
                if ($_GET['q']=='remove'){
                    removeFromOrder();
                }
            }
            else
                if($_GET['feature']=='shipping'){
                    shipping();
                }
                else
                    if($_GET['feature']=='payment'){
                        payment();
                    }
            if($_GET['feature']=='messages'){
                if(!isset($_GET['id'])){
                    showAllMessageView();
                }else
                if (isset($_GET['id'])){
                    showReadMessageView();
                }
            }else
        ?>
        </div>
    </div>
<?}

