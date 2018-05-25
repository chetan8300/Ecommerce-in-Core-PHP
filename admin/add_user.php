<?php
    require_once 'includes/session.php';
    require_once '../core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
    $errors = array();
    $success = "";
    if(isset($_GET) && !empty($_GET)){
        $success = $_GET['success'];
    }
?>


<div id="login-form" >
    <div>
        <?php
            if (isset($_POST) && !empty($_POST)) {
                if (empty($_POST['user']) || empty($_POST['fname']) || empty($_POST['lname']) || 
                   empty($_POST['email']) || empty($_POST['password']) || empty($_POST['con_password'])) {
                    $errors[] .= 'Fields marked with (*) are mandatory';
                }
                $user_type = sanitize($_POST['user']);
                $firstname = sanitize($_POST['fname']);
                $lastname = sanitize($_POST['lname']);
                $email = sanitize($_POST['email']);
                $password = sanitize($_POST['password']);
                $con_password = sanitize($_POST['con_password']);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                if($user_type == ""){
                    $errors[] .= "You must select user type.";
                }
                
                if (!preg_match("/^\w+\@[a-zA-Z_.]+\.\w{2,5}$/",$email)) {
                  $errors[] .= "Please enter valid email address";
                }
                
                if (strlen($password) < 8) {
                  $errors[] .= "Password Field Should contain more than 8 characters"; 
                }
                
                if($password != $con_password){
                    $errors[] .= "Password and Confirm Password must be same.";
                }
                if($user_type == "admin"){
                    $check_account_query = "SELECT * FROM admin WHERE email = '".$email."'";
                    $check_account = $db->query($check_account_query);
                    $number_of_rows = mysqli_num_rows($check_account);
                    if($number_of_rows != 0){
                        $errors[] .= "Email already exist.";
                    }
                }
                elseif($user_type == "regular"){
                    $check_account_query = "SELECT * FROM users WHERE email = '".$email."'";
                    $check_account = $db->query($check_account_query);
                    $number_of_rows = mysqli_num_rows($check_account);
                    if($number_of_rows != 0){
                        $errors[] .= "Email already exist.";
                    }
                }
                
                if(!empty($errors)){
                    echo display_errors($errors);
                }
                else{
                    $last_login = date("Y-m-d H:i:s");
                    if($user_type == "admin"){
                        $registration = "INSERT INTO `admin`(`firstname`, `lastname`, `email`, `password`, `last_login`)"
                                        . "VALUES ('".$firstname."','".$lastname."','".$email."','".$hashed_password."','".$last_login."')";
                        $db->query($registration);
                        $success = "Registraion Successful";
                        header("Location: add_user.php?success='Registraion Successful'");
                    }
                    elseif($user_type == "regular"){
                        $registration = "INSERT INTO `users`(`firstname`, `lastname`, `email`, `password`, `last_login`)"
                                        . "VALUES ('".$firstname."','".$lastname."','".$email."','".$hashed_password."','".$last_login."')";
                        $db->query($registration);
                        $success = "Registraion Successful";
                        header("Location: add_user.php?success='Registraion Successful'");
                    }
                }
            }
        ?>
    </div>
    <div class="text-center"><?php echo $success; ?></div>
    <h2 class="text-center">Add New User</h2><hr>
    <div class="row">
        <div class="container">
            <div class=" col-sm-12 col-md-12 col-lg-12">
                <div>
                    <div class="container">
                        <form id="register_form" method="post" action="add_user.php" name="register_form">
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="type">Select User Type*:</label>
                                    <select class="form-control" name="user" id="user">
                                        <!--<option selected disabled>Select User Type</option>-->
                                        <option value=""></option>
                                        <option value="admin">Admin User</option>
                                        <option value="regular">Front End User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="usr">First Name*:</label>
                                    <input type="text" class="form-control required" name="fname" id="fname" placeholder="Enter First Name" onblur="fname_error()" onKeyPress="fname_blank()">
                                    <span id="fname_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="lusr">Last Name*:</label>
                                    <input type="text" class="form-control required" name="lname" id="lname" placeholder="Enter Last Name" onblur="lname_error()" onKeyPress="lname_blank()">
                                    <span id="lname_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="email">Email*:</label>
                                    <input type="email" class="form-control email required" name="email" id="email" placeholder="Enter email address" onblur="email_error()" onKeyPress="email_blank()">
                                    <span id="email_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="pwd">Password*:</label>
                                    <input type="password" class="form-control required" name="password" id="password" placeholder="Enter password" onblur="pass_error()" onKeyPress="pass_blank()">
                                    <span id="pass_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="cpwd">Confirm Password*:</label>
                                    <input type="password" class="form-control required" name="con_password" id="con_password" placeholder="Enter confirm password" onblur="cpass_error()" onKeyPress="con_pass_blank()">
                                    <span id="cpass_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                    <a href="admin_users.php" class="btn btn-default">Cancel</a>
                                    <input type="submit" class="btn btn-success" value="Register" onClick="return register()">
                            </div>
                        </form><br />
                        <div class="alert alert-warning col-md-4" style="margin-top:10px;">
                            <strong>Fields marked with (*) are mandatory</strong>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include 'includes/footer.php';
?>