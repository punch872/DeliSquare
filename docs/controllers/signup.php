<?php
if (isset($_POST['signup'])){
    $email      =   $_POST['email'];
    $password   =   $_POST['password'];
    $confirm    =   $_POST['confirm'];
    $date       =   date('Y-m-d');
    if($password==$confirm){
        $db = new mysqli('localhost','root','root','dev');
        if($db->connect_error){
            die("Could not connect ot database");
        }else{
            $query  =   "
                INSERT INTO user(user_email,user_password,created,updated)
                VALUES ('$email','$password','$date','$date')
            ";
            if ($result=$db->query($query)){
                echo '<script>alert("Thank you ! Please Login again");
                       window.location.href=\'index.php\';
                      </script>';
            }
            else{
                echo '<script>alert("There was some problem")</script>';
            }
        }
        $db->close();
    }
    else{
        echo '<script>alert("Passwords don\'t match")</script>';
    }
}
?>
<div class="container" >
    <div class="row">
        <form class="col s12 m6 offset-m6" method="post" action="#">
            <div class='input-field row'>
                <input id='email' type='email' class='validate' name='email'>
                <label for='email'>Email</label>
            </div>
            <div class='input-field row'>
                <input id='password' type='password' class='validate' name='password'>
                <label for='password'>Password</label>
            </div>
            <div class='input-field row'>
                <input id='password' type='password' class='validate' name='confirm'>
                <label for='password'>Confirm Password</label>
            </div>
            <div class='input-field row'>
                <input id='signup' type='submit' class='btn right' name='signup' value="signup">
            </div>
        </form>
    </div>
</div>
