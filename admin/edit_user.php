<?php
    require_once 'includes/session.php';
    require_once '../core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
    $errors = array();
    
    if(isset($_GET) && !empty($_GET)){
        
        //To Fetch Data and fill fields
        $edit_id = sanitize($_GET['edit']);
        $type = sanitize($_GET['type']);
        if($type == "admin"){
            $fetch_user_query = "SELECT * FROM admin WHERE id='".$edit_id."'";
            $user_result = $db->query($fetch_user_query);
            $select = "Admin User";
        }
        elseif($type == "regular"){
            $fetch_user_query = "SELECT * FROM users WHERE id='".$edit_id."'";
            $user_result = $db->query($fetch_user_query);
            $select = "Front End User";
        }
        $user = mysqli_fetch_assoc($user_result);
        $saved_password = $user['password'];
        
        
        //To update user data
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
                        $update = "UPDATE admin SET firstname='".$firstname."', lastname='".$lastname."', email='".$email."', password='".$hashed_password."', last_login='".$last_login."' WHERE id ='".$edit_id."'";
                        $db->query($update);
                        header("Location: admin_users.php");
                    }
                    elseif($user_type == "regular"){
                        $update = "UPDATE users SET firstname='".$firstname."', lastname='".$lastname."', email='".$email."', password='".$hashed_password."', last_login='".$last_login."' WHERE id='".$edit_id."'";
                        $db->query($update);
                        header("Location: front_end_users.php");
                    }
                }
            }
    }
    
?>


<div id="login-form" >
    <div>
        <?php
            
        ?>
    </div>
    <h2 class="text-center">Edit A User</h2><hr>
    <div class="row">
        <div class="container">
            <div class=" col-sm-12 col-md-12 col-lg-12">
                <div>
                    <div class="container">
                        <form id="register_form" method="post" action="edit_user.php?edit=<?php echo $edit_id; ?>&type=<?php echo $type;?>" name="register_form">
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="type">Select User Type*:</label>
                                    <select class="form-control" name="user" id="user">
                                        <option selected disabled><?php echo $select;?></option>
                                        <option value="admin">Admin User</option>
                                        <option value="regular">Front End User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="usr">First Name*:</label>
                                    <input type="text" class="form-control required" value="<?php echo $user['firstname'];?>" name="fname" id="fname" placeholder="Enter First Name" onblur="fname_error()" onKeyPress="fname_blank()">
                                    <span id="fname_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="lusr">Last Name*:</label>
                                    <input type="text" class="form-control required" value="<?php echo $user['lastname'];?>" name="lname" id="lname" placeholder="Enter Last Name" onblur="lname_error()" onKeyPress="lname_blank()">
                                    <span id="lname_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="email">Email*:</label>
                                    <input type="email" class="form-control email required" value="<?php echo $user['email'];?>" name="email" id="email" placeholder="Enter email address" onblur="email_error()" onKeyPress="email_blank()">
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
                                    <input type="submit" class="btn btn-success" value="Update" onClick="return register()">
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