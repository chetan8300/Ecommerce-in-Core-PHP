<?php
    require_once '../../core/init.php';
    $mode = sanitize($_POST['mode']);
    $edit_id = sanitize($_POST['edit_id']);
    $edit_size = sanitize($_POST['edit_size']);
    
    $cart_query = "SELECT * FROM cart WHERE id ='{$cart_id}'";
    $cart_ref = $db->query($cart_query);
    $result = mysqli_fetch_assoc($cart_ref);
    
    $items = json_decode($result['items'], TRUE);
    $updated_items = array();
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:FALSE;
    if($mode == "removeone"){
        foreach($items as $item){
            if($item['id'] == $edit_id && $item['size'] == $edit_size){
                $item['quantity'] = $item['quantity'] - 1; 
            }
            if($item['quantity'] > 0){
                $updated_items[] = $item;
            }
        }
    }
    if ($mode == "addone"){
        foreach($items as $item){
            if($item['id'] == $edit_id && $item['size'] == $edit_size){
                $item['quantity'] = $item['quantity'] + 1; 
            }
            $updated_items[] = $item;
        }
    }
    
    if(!empty($updated_items)){
         $json_updated = json_encode($updated_items);
         $update_cart = "UPDATE cart SET items='{$json_updated}' WHERE id='{$cart_id}'";
         $db->query($update_cart);
    }
    
    if(empty($updated_items)){
        $db->query("DELETE FROM cart WHERE id='{$cart_id}'");
        setcookie(CART_COOKIE,'',1,"/",$domain,false);
    }
?>