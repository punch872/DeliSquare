<?php
    $user_id    =   $_SESSION['user'][0];
    $user_email =   $_SESSION['user'][1];
    $q = "
        SELECT * 
        FROM profile
        WHERE user_id = '$user_id'
    ";
    if($result = $db->query($q)){
        if($result->num_rows==0){
            // Show add new user information view
            newProfileView();
        }
        else{
            $row = $result->fetch_assoc();
            $profile_id=$row['profile_id'];
            $user_type = $row['profile_type'];
            $_SESSION['user'][2]=$user_type;
            $_SESSION['user'][3]=$profile_id;
            if ($user_type=='diner'){
                $q = "
                  SELECT *
                  FROM address
                  WHERE profile_id = ( SELECT profile_id FROM profile WHERE user_id = '$user_id' )
                ";
                if ($result = $db->query($q)){
                    if ($result->num_rows==0){
                        newAddressView();
                    }else{
                        $fetched = $result->fetch_assoc();
                        $_SESSION['user'][4]=$fetched['address_id'];
                        $completed = true;
                    }
                }
            }else
            if ($user_type=='owner'){
                $q = "
                    SELECT *
                    FROM shop
                    WHERE profile_id = ( SELECT profile_id FROM profile WHERE user_id = '$user_id' )
                ";
                if($result = $db->query($q)){
                    if($result->num_rows==0){
                        newShopView();
                    }else{
                        $row = $result->fetch_assoc();
                        $_SESSION['user'][4] = $row['shop_id'];
                        $q = "
                          SELECT *
                          FROM address
                          WHERE profile_id = ( SELECT profile_id FROM profile WHERE user_id = '$user_id' )
                        ";
                        if ($result = $db->query($q)){
                            if ($result->num_rows==0){
                                newAddressView();
                            }else {
                                $completed = true;
                            }
                        }
                    }
                }
            }
        }
    }
    if($completed)
        AppView();
?>

<?
    if (isset($_POST['profile_new'])){
        //var_dump($_POST);
        $profile_name   =   $_POST['profile_name'];
        $profile_phone  =   $_POST['profile_phone'];
        $profile_type   =   $_POST['profile_type'];
        $date           =   date('Y-m-d');
        $q="
            INSERT INTO profile(user_id,profile_name,profile_phone,profile_type,created,updated)
            VALUES ('$user_id','$profile_name','$profile_phone','$profile_type','$date','$date')
        ";
        $db->query($q);
        if ($db->error){
            echo 'Error with '.$db->error;
        }else{
            $_SESSION['user'][2] = $profile_type;
            header("location: index.php?page=app");
            echo '<script>window.location.href=\'index.php?page=app\';</script>';
        }
    }else
    if(isset($_POST['address_new'])){
        //var_dump($_POST);
        $address_type       =   $_POST['address_type'];
        $address_street     =   $_POST['address_street'];
        $address_district   =   $_POST['address_district'];
        $address_city       =   $_POST['address_city'];
        $address_state      =   $_POST['address_state'];
        $address_zipcode    =   $_POST['address_zipcode'];
        $date               =   date('Y-m-d');
        $q="
            INSERT INTO address(profile_id,address_type,address_street,address_district,address_city,address_state,address_zipcode)
            
            VALUES (
              (
                SELECT profile_id
                FROM profile WHERE user_id = '$user_id'
              ),
              '$address_type',
              '$address_street',
              '$address_district',
              '$address_city',
              '$address_state',
              '$address_zipcode'
            )
        ";
        $db->query($q);
        if($db->error){
            echo 'Error with '.$db->error;
        }else{
            header("location: index.php?page=app");
            echo '<script>window.location.href=\'index.php?page=app\';</script>';
        }
    }else
    if(isset($_POST['shop_new'])){
        //var_dump($_POST);
        $name           =   $_POST['name'];
        $description    =   $_POST['description'];
        $date               =   date('Y-m-d');

        $target_dir = "/Applications/MAMP/htdocs/dev/uploads/shop/";
        $path_dir = "uploads/shop/".basename($_FILES["feature_pic"]['tmp_name']);
        $target_file = $target_dir.basename($_FILES["feature_pic"]['name']);

        if(move_uploaded_file($_FILES['feature_pic']["tmp_name"],$target_file)){
            $q = "
                INSERT INTO shop(profile_id,name,feature_pic,description,created_date,updated_date)
                VALUES (
                  (
                    SELECT profile_id
                    FROM profile WHERE user_id = '$user_id'
                  ),
                  '$name',
                  '$path_dir',
                  '$description',
                  '$date',
                  '$date'
                ) 
            ";
            $db->query($q);
            if ($db->error){
                echo "Error with".$db->error;
            }else{
                header("location: index.php?page=app");
                echo '<script>window.location.href=\'index.php?page=app\';</script>';
            }
        }else{
            echo "could not upload file";
        };
    }

    function newProfileView()
    {?>
        <div class="container">
            <div class="row col s12 m6 center-align">
                <div class="card-panel ">
                    <p>Please fill in your information</p>
                    <form action="#" class="row" method="post" class="center-align">
                        <div class="row col s12 input-field">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" name="profile_name" id="profile_name">
                            <label for="profile_name">Full Name</label>
                        </div>
                        <div class="row col s12 input-field">
                            <i class="material-icons prefix">local_phone</i>
                            <input type="text" name="profile_phone" id="profile_phone">
                            <label for="profile_phone">Phone number</label>
                        </div>
                        <div class="row col s12 input-field">
                            <select name="profile_type">
                                <option value="" disabled selected>Choose your option</option>
                                <option value="diner">Diner</option>
                                <option value="owner">Owner</option>
                            </select>
                            <label>Who are you?</label>
                        </div>
                        <div class="row col s12 input-field center-align">
                            <input type="submit" value="save" name="profile_new" class="btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?}

    function newAddressView()
    {?>
        <div class="container">
            <div class="row col s12 m6 center-align">
                <div class="card-panel">
                    <p>Please fill in your address</p>
                    <form action="#" class="row" method="post">
                        <div class="col s12 m6 input-field">
                            <select name="address_type">
                                <option value="" disabled selected>Choose your option</option>
                                <?if ($_SESSION['user'][2]=='diner')
                                {?>
                                    <option value="ship">Shipping</option>
                                    <option value="bill">Billing</option>
                                <?}else
                                {?>
                                    <option value="shop" selected>Shop</option>
                                <?}?>
                            </select>
                            <label>Type of Address</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" name="address_street" id="address_street">
                            <label for="address_street">Street</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" name="address_district" id="address_district">
                            <label for="address_district">District</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" name="address_city" id="address_city">
                            <label for="address_city">City</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" name="address_state" id="address_state">
                            <label for="address_state">State</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" name="address_zipcode" id="address_zipcode">
                            <label for="address_zipcode">Zipcode</label>
                        </div>
                        <div class="row col s12 input-field center-align">
                            <input type="submit" value="save" name="address_new" class="btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?}

    function newShopView()
    {?>
        <div class="container">
            <div class="row col s12 center-align">
                <div class="card-panel col s12 m6 offset-m3">
                    <p>Please fill in your shop information</p>
                    <form action="#" class="row" method="post" enctype='multipart/form-data'>
                        <div class="row col s12 input-field">
                            <input type="text" name="name" id="name">
                            <label for="name">Shop name</label>
                        </div>
                        <div class="row col s12 input-field">
                            <textarea name="description" id="description" class="materialize-textarea"></textarea>
                            <label for="description">Description</label>
                        </div>
                        <div class="row col s12 file-field input-field">
                            <div class="btn">
                                <span>File</span>
                                <input type="file" name="feature_pic" id="feature_pic">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload shop picture">
                            </div>
                        </div>
                        <div class="row col s12 input-field center-align">
                            <input type="submit" value="save" name="shop_new" class="btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?}

    function AppView()
    {
        if ($_SESSION['user'][2] == 'diner') {
            diner();
        } elseif ($_SESSION['user'][2] == 'owner') {
            owner();
        }
    }?>

