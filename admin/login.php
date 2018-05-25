<?php 
    session_start();
?>
<?php
    require_once '../core/init.php';
    include 'includes/head.php';

    $errors = array();
?>

<style>
    body{
        background-image: url("../assets/images/background5.jpg");
        background-size: 100vw 100vh;
        background-attachment: fixed;
    }
</style>

<div id="login-form" class="text-center">
    <div>
        <?php
            if ($_POST) {
                if (empty($_POST['email']) || empty($_POST['password'])) {
                    $errors[] .= 'You must provide email and password';
                }
                $email = sanitize($_POST['email']);
                $password = sanitize($_POST['password']);
                if (!preg_match("/^\w+\@[a-zA-Z_.]+\.\w{2,5}$/",$email)) {
                  $errors[] .= "Please enter valid email address";
                }
                if (strlen($password) < 8 || strlen($password) > 12) {
                  $errors[] .= "Password Field Should contain characters between 8 to 12"; 
                }
                $check_login_query = "SELECT * FROM admin WHERE email = '".$email."'";
                $check_login = $db->query($check_login_query);
                $number_of_rows = mysqli_num_rows($check_login);
                if($number_of_rows != 1){
                    $errors[] .= "Email or password doesn't exist.";
                }
                else{
                    $check_login_results = mysqli_fetch_assoc($check_login);
                    if(!password_verify($password, $check_login_results['password'])){
                        $errors[] .= "Email or password doesn't exist.";
                    }
                }
                
                if(!empty($errors)){
                    echo display_errors($errors);
                }
                else{
//                    $user_record = mysqli_fetch_assoc($check_login);
//                    $id = $user_record['id'];
                    $_SESSION['email'] = $email;
//                    if(isset($_POST['rememeber'])=='on'){
//                        if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
//                            //Set Cookie from here for one month
//                            setcookie("username", $email, time()+(60*60*1*24));
//                            setcookie("password", $password, time()+(60*60*1*24));
//                        }
//                    }
                    
                    $last_login = date("Y-m-d H:i:s");
                    $db->query("UPDATE admin SET last_login = '".$last_login."' WHERE email = '".$email."'");
                    header("Location: index.php");
                }
            }
        ?>
    </div>
    <h2 class="text-center">Login</h2>
    <form role="form" method="post">
        <div class="form-group">
            <label for="email">Email*:</label>
            <input type="email" class="form-control email required" name="email" id="email" placeholder="Enter email" onblur="email_error()" onKeyPress="email_blank()">
            <span id="email_error"></span>
        </div>

        <div class="form-group">
            <label for="password">Password*:</label>
            <input type="password" class="form-control required" name="password" id="password" placeholder="Enter password" onblur="pass_error()" onKeyPress="pass_blank()">
            <span id="pass_error"></span>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" id="remember" name="remember"> Remember me </label>
        </div>
        <button type="submit" class="btn btn-primary" onClick="return register();" value=""><span class="fa fa-sign-in"></span> Login</button>
    </form>
</div>


<?php
    include 'includes/footer.php';
?>