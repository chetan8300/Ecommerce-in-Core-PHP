<?php
    require_once 'includes/session.php';
    require_once '../core/init.php';
    $delete_id = sanitize($_GET['delete']); 
    $type = sanitize($_GET['type']); 
    if($type == "admin"){
        $delete_query = "DELETE FROM admin WHERE id='".$delete_id."'";
        $db->query($delete_query);
        header("Location: admin_users.php");
    }
    elseif($type == "regular"){
        $delete_query = "DELETE FROM users WHERE id='".$delete_id."'";
        $db->query($delete_query);
        header("Location: front_end_users.php");
    }

