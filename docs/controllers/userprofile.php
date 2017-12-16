<?php
/**
 * Created by PhpStorm.
 * User: punchok
 * Date: 19/11/17
 * Time: 22:28
 */
$db = new mysqli("localhost",'root','root','dev');
$user_id = $_SESSION['user'][0];
$profile_id = $_SESSION['user'][3];
$q = "  SELECT *
        FROM  profile,user,address
        WHERE user_id = '$user_id'
    ";
$users = $db -> query($q);

function updateprofile(){
?>
    <?
    global $db;
    global $user_id;
    global $profile_id;
    $profile_name = $_POST["profile_name"];
    $user_id=$_POST['user_id'];
    $user_email = $_POST['user_email'];
    $profile_id=$_POST['profile_id'];
    $address_type = $_POST['address_type'];
    $address_street = $_POST['address_street'];
    $address_district= $_POST['address_district'];
    $address_zipcode= $_POST['address_zipcode'];
    $q1 = " UPDATE  profile
           SET profile_name='$profile_name'
           WHERE profile_id = '$profile_id'";
    $db ->query($q1);
    $q2 = " UPDATE  address
           SET address_type='$address_type',address_street =' $address_street',
           address_district='$address_district', address_zipcode = '$address_zipcode' 
           WHERE profile_id ='$profile_id' ";
    $db ->query($q2);
    $q3 = " UPDATE  user
           SET user_email='$user_email'
           WHERE user_id = '$user_id'";
    $db ->query($q3);
    ?>
<?}

function showUserProfile()
{
?>
    <?
    global $db;
    global $user_id;
    global $profile_id;
    $q = "
        SELECT *
        FROM user,profile,address
        WHERE user.user_id = $user_id AND profile.user_id=user.user_id AND address.profile_id = profile.profile_id       
         ";
    $users = $db->query($q);
    ?>
    <div class="row">
    <div class="col s12 ">
    <div class="card darken-1">
    <div class="card-content ">
    <?
    if ($q) {
        $row = $users->fetch_assoc();
        ?>
        <h3 class="amber-text" style="font-weight: bold">Profile</h3>
        <form class="col s12 ">
            <div class="input-field col s6">
                <input  disabled value= "<?=$row['profile_name']?>" id="name" type="text" class="validate">
                <label for="disabled">Name</label>
            </div>
            <div class="input-field col s6">
                <input disabled value= "<?=$row['user_email']?>" id="email" type="text" class="validate">
                <label for="disabled">Email</label>
            </div>
        </form>
        <form class="col s12 ">
            <div class="input-field col s6">
                <input disabled value= "<?=$row['profile_type']?>" id="type" type="text" class="validate">
                <label for="disabled">Type</label>
            </div>
            <div class="input-field col s6">
                <input disabled value= "<?=$row['profile_phone']?>" id="phone" type="text" class="validate">
                <label for="disabled">phone</label>
            </div>
        </form>
        <div>
            <h4 style="color: dimgrey;">Address</h4>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="input-field col s6">
                    <input disabled value= "<?=$row['address_type']?>" id="addtype" type="text" class="validate">
                    <label for="disabled">Address Type</label>
                </div>
                <div class="input-field col s6">
                    <input disabled value= "<?=$row['address_street']?>" id="addstreet" type="text" class="validate">
                    <label for="disabled">Address Street</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input disabled value= "<?=$row['address_district']?>" id="adddistrict" type="text" class="validate">
                    <label for="disabled">Address District</label>
                </div>
                <div class="input-field col s6">
                    <input disabled value= "<?=$row['address_city']?>" id="addcity" type="text" class="validate">
                    <label for="disabled">Address City</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input disabled value= "<?=$row['address_state']?>" id="addstate" type="text" class="validate">
                    <label for="disabled">Address State</label>
                </div>
                <div class="input-field col s6">
                    <input disabled value= "<?=$row['address_zipcode']?>" id="addzip" type="text" class="validate">
                    <label for="disabled">Address Zipcode</label>
                </div>
            </div>
        </div>

        <div  class="fixed-action-btn horizontal">
            <a href="<?=$_SERVER['REQUEST_URI']."&q=edit&id=".$row['user_id']?>"  class="btn-floating waves-effect waves-light btn-large red">
                <i  class="large material-icons">mode_edit</i>
            </a>
        </div>
        </div>
        </div>
        </div>
        </div>
        <?
    } ?>

    <?
}
function editUserProfile(){
    ?>
    <?
    global $db;
    global $user_id;
    global $profile_id;
    global $address_id;
    $q = "
        SELECT *
        FROM user,profile,address
        WHERE user.user_id = $user_id AND profile.user_id=user.user_id AND address.profile_id = profile.profile_id       
         ";
    $users = $db->query($q);
    ?>
    <div class="card">
    <div class="card-content ">
    <div class="row">
    <div class="col s12 ">
    <?
    if ($q) {
        $row = $users->fetch_assoc();
        ?>
        <h3 class="amber-text" style="font-weight: bold">Edit Profile</h3>
        <div class="col s12">
            <form action="<?=$_SERVER['REQUEST_URI'].'&q=update' ?>"  method="post">
                <div class="col s12 ">
                    <div class="input-field col s6">
                        <input type="text" name="profile_name" value="<?=$row['profile_name']?>"  >
                        <label >Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="text"  name="user_email"  value= "<?=$row['user_email']?>" >
                        <label >Email</label>
                    </div>
                </div>
                <div class="col s12 ">
                    <div class="input-field col s6">
                        <input type="text"   name="profile_type"  value= "<?=$row['profile_type']?>">
                        <label >Type</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="text"   name="profile_phone" value= "<?=$row['profile_phone']?>">
                        <label>phone</label>
                    </div>
                </div>
                <div>
                    <h4 style="color: dimgrey;">Address</h4>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input type="text" name="address_type" value= "<?=$row['address_type']?>" >
                            <label>Address Type</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="address_street" value= "<?=$row['address_street']?>" >
                            <label>Address Street</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input type="text"  name="address_district" value= "<?=$row['address_district']?>">
                            <label>Sub-district</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="address_city"  value= "<?=$row['address_city']?>">
                            <label>District </label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input type="text" name="address_state" value= "<?=$row['address_state']?>" >
                            <label>Province</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="address_zipcode" value= "<?=$row['address_zipcode']?>" >
                            <label>Address Zipcode</label>
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <input type="submit" value="save" name="action" class="btn">
                    </div>
            </form>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <?
    } ?>
    <?}
