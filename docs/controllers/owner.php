<?php
/**
 * Created by PhpStorm.
 * User: sangrit
 * Date: 6/11/17
 * Time: 19:18
 */
function owner()
{?>
    <div class="container owner-container">
        <div class="row">
            <div class="col s12 m3">
                <?ownfeatures();?>
            </div>
            <div class="col s12 m9">
                <?
                if($_GET['feature']=='profile'){
                    if(!isset($_GET['q'])){
                        showUserProfile();
                    }else
                    if ($_GET['q']=='edit'){
                        editUserProfile();
                    }
                }else
                if($_GET['feature']=='menus') {
                    if(!isset($_GET['q'])) {
                        showAllMenuView();
                    }else
                    if ($_GET['q']=='add'){
                        showAddMenuView();
                    }else
                    if ($_GET['q']=='edit'){
                        showEditMenuView();
                    }else
                    if($_GET['q']=='remove'){
                        showRemoveMenuView();
                    }
                }else
                if($_GET['feature']=='messages'){
                    if(!isset($_GET['id'])){
                        showAllMessageView();
                    }else
                    if (isset($_GET['id'])){
                        showReadMessageView();
                    }
                }else
                if($_GET['feature']=='orders'){
                    if(!isset($_GET['q'])){
                        showAllOrderView();
                    }else
                        if($_GET['q']=='deliver'){
                            showOrderDeliverView();
                        }
                }else
                {
                    if(!isset($_GET['q'])){
                        showAllDashboardView();
                    }
                    if($_GET['q']=='menusummary'){
                        showMenuSummaryView();
                    }
                }
                ?>
            </div>

        </div>
    </div>
<?}

