<?php
    require_once 'includes/session.php';
    require_once '../core/init.php';
    
    //Delete A Product
    if(isset($_GET['delete']) && !empty($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_query = "UPDATE products SET deleted = 1 WHERE id = '".$delete_id."'";
        $db->query($delete_query);
        header("Location: products.php");
    }
?>