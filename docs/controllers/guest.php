
<!--
 * Created by PhpStorm.
 * User: boycatbay
 * Date: 23/11/60
 * Time: 10:24
 -->
    <div class="row">
        <div class="col s4 m3 l2">
            <? guestfeatures();?>
        </div>
        <div class="col s8 m9 l10">
            <?
            if($_GET['feature']=='foods') {
                if ($_GET['sub'] == 'restaurants') {
                    showAllRestaurants();
                } elseif ($_GET['sub'] == 'menus') {
                    showAllMenus();
                } elseif ($_GET['sub'] == 'categories') {
                    showByCategories();
                }
            }
            ?>
        </div>
    </div>
