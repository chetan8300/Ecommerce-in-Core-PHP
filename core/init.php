<?php
    $db = mysqli_connect('localhost', 'root', '', 'gift_wrapper');
	
    if(mysqli_connect_errno()){
        echo 'Database Connection failed with following errors: '. mysqli_connect_errno();
        die();
    }
    
	require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/config.php';
    require_once BASEURL.'helpers/helpers.php';
    require BASEURL.'vendor/autoload.php';
    
    $cart_id = NULL;
    
	if(isset($_COOKIE[CART_COOKIE])){
        $cart_id = sanitize($_COOKIE[CART_COOKIE]);
	}