<?php
/**
 * Created by PhpStorm.
 * User: sangrit
 * Date: 15/12/17
 * Time: 15:32
 */

function cardMenu($shop_id,$menu_id,$pic,$title,$price,$description){?>
    <div class="col s12 m6 l3">
        <div class="card">
            <div class="card-image waves-effect waves-block waves-light">
                <img style="width:100%;height: 150px"class="activator cpic" src="<?=$pic?>">
            </div>
            <div class="card-content" style="80px">
                <span class="card-title activator grey-text text-darken-4"><?=$title?></span>
                <p>Price : <?=$price?> Baht</p>
                <div class="center-align">
                    <a class="btn" href=<?='?feature=dinorder&q=add&shop_id='.$shop_id.'&menu_id='.$menu_id?>>Add to Cart</a>
                </div>
            </div>
            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4"><?=$title?><i class="material-icons right">close</i></span>
                <p><?=$description?></p>
            </div>
        </div>
    </div>
<?}

