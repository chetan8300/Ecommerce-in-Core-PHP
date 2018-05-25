<?php
    require_once '../../core/init.php';
    
    $product_id = sanitize($_POST['product_id']);
    $size = sanitize($_POST['size']);
    $available = sanitize($_POST['available']);
    $qunatity = sanitize($_POST['quantity']);
    
    $item = array();
    
    $item[] = array(
        'id'        => $product_id,
        'size'      => $size,
        'quantity'  => $qunatity,
    );
    
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
    
    $sql = "SELECT * FROM products WHERE id = '".$product_id."'";
    
    $query = $db->query($sql);
    $product = mysqli_fetch_assoc($query);
    
    //check if the cart cookie exists
    
    if($cart_id != NULL) {
        $cart_query = "SELECT * FROM cart WHERE id = '{$cart_id}'";
        $cart_ref = $db->query($cart_query);
        $cart = mysqli_fetch_assoc($cart_ref);
        $previous_items = json_decode($cart['items'],true);
        $item_match = 0;
        $new_items = array();
        foreach($previous_items as $previous_item){
            if($item[0]['id'] == $previous_item['id'] && $item[0]['size'] == $previous_item['size']){
                $previous_item['quantity'] = $previous_item['quantity'] + $item[0]['quantity'];
                if($previous_item['quantity'] > $available){
                    $previous_item['quantity'] = $available;
                }
                $item_match = 1;
            }
            $new_items[] = $previous_item;
        }
        if($item_match != 1){
            $new_items = array_merge($item, $previous_items);
        }
        $items_json = json_encode($new_items);
        $cart_expire = date("Y-m-d H:i:s",  strtotime("+30 days"));
        $update_cart = "UPDATE cart SET items='{$items_json}', expire_date='{$cart_expire}' WHERE id='{$cart_id}'";
        $db->query($update_cart);
        setcookie(CART_COOKIE,'',1,"/",$domain,false);
        setcookie(CART_COOKIE, $cart_id, CART_COOKIE_EXPIRE, '/', $domain, false);
    }
    else {
        //add the cart to database and set cookie
        $items_json = json_encode($item);
        $cart_expire = date("Y-m-d H:i:s",  strtotime("+30 days"));
        $db->query("INSERT INTO cart(items, expire_date) VALUES ('{$items_json}','{$cart_expire}')");
        $cart_id = $db->insert_id; //insert_id is inbuilt mysql function to return last inserted id
        setcookie(CART_COOKIE, $cart_id, CART_COOKIE_EXPIRE, '/', $domain, false);
    }