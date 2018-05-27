<?php
    define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/ecommerce/');
    define('CART_COOKIE','JDSFijnf34532kafsajNEAS9A8');
    define('CART_COOKIE_EXPIRE',  time() + (86400 * 30));
    define('TAXRATE',0.087);
    
    define('CURRENCY','USD');
    define('CHECKOUTMODE', 'TEST'); //can change mode to live when website goes live 
    
    if(CHECKOUTMODE == 'TEST'){
        define('STRIPE_PRIVATE', 'STRIPE_PRIVATE Test Key');
        define('STRIPE_PUBLIC', 'STRIPE_PUBLIC Test Key');
    }
    
    if(CHECKOUTMODE == 'LIVE'){
        define('STRIPE_PRIVATE', 'STRIPE_PRIVATE Live Key');
        define('STRIPE_PUBLIC', 'STRIPE_PUBLIC Live Key');
    }