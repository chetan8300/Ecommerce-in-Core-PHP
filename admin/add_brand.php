<?php
    require_once 'includes/session.php';
    //If add form is submitted
    
        $brand = $_POST['brand'];
        if($brand == NULL){
            $errors[] .= 'You must enter a brand';
        }else{
        //check if brand exists in database or not
            $sql2 = "SELECT * FROM brand WHERE brand='$brand'";
            $brand_check = $db->query($sql2);
            $count = mysqli_num_rows($brand_check);
            if($count > 0){
                $errors[] .= $brand." Already Exists. Please Enter another brand.";
            }
        }
    
    
    
    //Display errors
    if(!empty($errors)){
        header('location: brands.php');
    }
    else{
        //add brand to database
        $sql = "INSERT INTO brand(brand) VALUES ('".$brand."')";
        $db->query($sql);
        header('location: brands.php');
        
    }
?>