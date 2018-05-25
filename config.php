<?php
    define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/ecommerce/');
    define('CART_COOKIE','JDSFijnf34532kafsajNEAS9A8');
    define('CART_COOKIE_EXPIRE',  time() + (86400 * 30));
    define('TAXRATE',0.087);
    
    define('CURRENCY','USD');
    define('CHECKOUTMODE', 'TEST'); //can change mode to live when website goes live 
    
    if(CHECKOUTMODE == 'TEST'){
        define('STRIPE_PRIVATE', 'sk_test_NLLjokbhzc1bZpxnzd6HRmfj');
        define('STRIPE_PUBLIC', 'pk_test_wtNzmuymewiBPlbcLVPwacv4');
    }
    
    if(CHECKOUTMODE == 'LIVE'){
        define('STRIPE_PRIVATE', 'sk_live_vojUpOzFBaW2oc3wFU1JmRUh');
        define('STRIPE_PUBLIC', 'pk_live_U161avf2wuScLN1UBUyGBPlh');
    }