<?php
    require_once 'includes/session.php';
    require_once '../core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
?>
<!-- Orders To Fill -->
<?php
    $txnQuery = "SELECT t.id,t.cart_id,t.full_name,t.description,t.txn_date,t.grand_total,c.items,c.paid,c.shipped 
                FROM transaction t 
                LEFT JOIN cart c ON t.cart_id = c.id 
                WHERE c.paid=1 AND c.shipped=0 
                ORDER BY t.txn_date";
    $txn_ref = $db->query($txnQuery);
?>

<div class="col-md-12">
    <h3 class="text-center">Orders To Ship</h3>
    <table class="table table-condensed table-bordered table-striped text-center">
        <thead>
            <th></th>
            <th>Name</th>
            <th>Description</th>
            <th>Total</th>
            <th>Date</th>
        </thead>
        <tbody>
        <?php while($txn_product = mysqli_fetch_assoc($txn_ref)){?>
            <tr>
                <td><a href="orders.php?txn_id=<?php echo $txn_product['id'];?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-info-sign"></span></a></td>
                <td><?php echo $txn_product['full_name'];?></td>
                <td><?php echo $txn_product['description'];?></td>
                <td><?php echo $txn_product['grand_total'];?></td>
                <td><?php echo $txn_product['txn_date'];?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php
    include 'includes/footer.php';
?>