<?php
if(isset($_POST['signin'])){
    $user_email     =   $_POST['email'];
    $user_password  =   $_POST['password'];

    $query  =   "
        SELECT  user_id,user_email
        FROM  user
        WHERE user_email='$user_email' AND user_password='$user_password'
    ";
    //var_dump($query);
    $result =   $db->query($query);
    if($result->num_rows>0){
        $_SESSION['user']   =   $result->fetch_all()[0];
        echo "
            <script>
                console.log('[+]User login');
                window.location.href='?page=app';
            </script>
        ";
    }
    else{
        echo "
            <script>
                alert('Email or password is wrong');
            </script>
        ";
    }
}else
if(isset($_POST['signup'])){
    $email      =   $_POST['email'];
    $password   =   $_POST['password'];
    $confirm    =   $_POST['confirm'];
    $date       =   date('Y-m-d');
    if($password==$confirm){
        $query  =   "
            INSERT INTO user(user_email,user_password,created,updated)
            VALUES ('$email','$password','$date','$date')
        ";
        if ($result=$db->query($query)){
            echo '<script>alert("Thank you ! Please Login again");window.location.href=\'index.php\';</script>';
        }
        else{
            echo '<script>alert("There was some problem")</script>';
        }
    } else{
        echo '<script>alert("Passwords don\'t match")</script>';
    }
}
?>
<div class="container row valign-wrapper">
    <div class="col s6 m6 hide-on-small-and-down">
        <img class="responsive-img" src="images/seafood.jpg">
    </div>
    <div class="col s6 m6">
        <div class="card">
            <div class="card-tabs">
                <ul class="tabs tabs-fixed-width">
                    <li class="tab"><a href="#signin">Sign In</a></li>
                    <li class="tab"><a href="#signup">Sign Up</a></li>
                </ul>
            </div>
            <div class="card-content">
                <div id="signin">
                    <form method="post" action="#">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="email" type="email" class="validate" name="email">
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="password" type="password" class="validate" name="password">
                                <label for="password">Password</label>
                            </div>
                            <div class="input-field col s12">
                                <div class="col s12 center-align">
                                    <a href="#">Forget password?</a>
                                </div>
                            </div>
                            <div class="input-field col s12 center-align">
                                <input id="login" type="submit" class="btn" value="signin" name="signin">
                            </div>
                        </div>
                    </form>
                </div>
                <div id="signup">
                    <form method="post" action="#">
                        <div class="row">
                            <div class='input-field col s12'>
                                <input id='email' type='email' class='validate' name='email'>
                                <label for='email'>Email</label>
                            </div>
                            <div class='input-field col s12'>
                                <input id='password' type='password' class='validate' name='password'>
                                <label for='password'>Password</label>
                            </div>
                            <div class='input-field col s12'>
                                <input id='password' type='password' class='validate' name='confirm'>
                                <label for='password'>Confirm Password</label>
                            </div>
                            <div class='input-field col s12 center-align'>
                                <input id='signup' type='submit' class='btn blue' name='signup' value="signup">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
