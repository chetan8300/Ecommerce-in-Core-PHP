<?php
    require_once 'includes/session.php';
    require_once '../core/init.php';
    
    //Restore A Product
    if(isset($_GET['restore']) && !empty($_GET['restore'])){
        $restore_id = $_GET['restore'];
        $restore_query = "UPDATE products SET deleted = 0 WHERE id = '".$restore_id."'";
        $db->query($restore_query);
        header("Location: archived.php");
    }
?>