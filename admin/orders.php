<?php
    require_once 'includes/session.php';
    require_once '../core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
    
    
    //Complete Order
    if(isset($_GET['complete']) && $_GET['complete']==1){
        $complete = sanitize($_GET['complete']);
        $cart_id = sanitize((int)$_GET['cart_id']);
        $db->query("UPDATE cart SET shipped = 1 WHERE id ='{$cart_id}'");
        header("Location: index.php");
    }

    $txn_id = sanitize($_GET['txn_id']);
    $txnQuery = $db->query("SELECT * FROM transaction WHERE id ='$txn_id'");
    $txn = mysqli_fetch_assoc($txnQuery);
    $cart_id = $txn['cart_id'];
    $cartQ = "SELECT * FROM cart WHERE id='$cart_id'";
    $cart_ref = $db->query($cartQ);
    $cart = mysqli_fetch_assoc($cart_ref);
    $items = json_decode($cart['items'], TRUE);
    $idArray = array();
    $products = array();
    foreach ($items as $item){
        $idArray[] = $item['id'];
    }
    $ids = implode(',', $idArray);
    $productQ = "SELECT i.id as 'id',i.title as 'title',c.id as 'cid',c.category as 'child', p.category as 'parent'
                FROM products i
                LEFT JOIN categories c ON i.category = c.id
                LEFT JOIN categories p ON c.parent = p.id
                WHERE i.id IN ({$ids})";
                
    $product_ref = $db->query($productQ);
    while($p = mysqli_fetch_assoc($product_ref)){
        foreach ($items as $item){
            if($item['id'] == $p['id']){
                $x = $item;
                continue;
            }
        }
        $products[] = array_merge($x,$p);
    }
?>
<h2 class="text-center">Items Ordered</h2>
<table class="table table-condensed table-bordered text-center table-striped">
    <thead>
        <th>Quantity</th>
        <th>Title</th>
        <th>Category</th>
        <th>Size</th>
    </thead>
    <tbody>
        <?php foreach ($products as $product){?>
            <tr>
                <td><?php echo $product['quantity'];?></td>
                <td><?php echo $product['title'];?></td>
                <td><?php echo $product['parent']."/".$product['child'];?></td>
                <td><?php echo $product['size'];?></td>
            </tr>
        <?php }?>
    </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <h3 class="text-center">Order Details</h3>
        <table class="table table-condensed table-bordered text-center table-striped">
            <tbody>
                <tr>
                    <td>Subtotal</td>
                    <td><?php echo $txn['sub_total']; ?></td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td><?php echo $txn['tax']; ?></td>
                </tr>
                <tr>
                    <td>Grand Total</td>
                    <td><?php echo $txn['grand_total']; ?></td>
                </tr>
                <tr>
                    <td>Order Date</td>
                    <td><?php echo $txn['txn_date']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h3 class="text-center">Shipping Address</h3>
        <address class="text-center">
            <?php echo $txn['full_name']; ?><br>
            <?php echo $txn['email']; ?><br>
            <?php echo $txn['street']; ?><br>
            <?php echo (($txn['street2'] != '')?$txn['street2'].'<br>':''); ?>
            <?php echo $txn['city'].", ".$txn['state'].", ".$txn['zip_code']; ?><br>
            <?php echo $txn['country']; ?>
        </address>
    </div>
</div>

<div class="pull-right">
    <a href="index.php" class="btn btn-large btn-default">Cancel</a>
    <a href="orders.php?complete=1&cart_id=<?php echo $cart_id; ?>" class="btn btn-large btn-primary">Complete Order</a>
</div>

<?php
    include 'includes/footer.php';
?>