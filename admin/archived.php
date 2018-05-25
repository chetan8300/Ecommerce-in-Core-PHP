<?php
    require_once 'includes/session.php';
    require_once '../core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
        
    //For Fetching archived product data from database
    $brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
    $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");

    $sql = "SELECT * FROM products WHERE deleted = 1";
    $product_result = $db->query($sql);
?>
<h2 class="text-center">Archived</h2><hr>
<table class="table table-bordered table-striped">
    <thead>
        <th>Restore Product</th>
        <th>Product</th>
        <th>Price</th>
        <th>Category</th>
        <th>Featured</th>
    </thead>
    <tbody class="text-center">
        <?php 
            while($product = mysqli_fetch_assoc($product_result)):
            $childID = $product['category'];
            $subcategory_query = "SELECT * FROM categories WHERE id = '".$childID."'";
            $sub_result =  $db->query($subcategory_query);
            $child_category = mysqli_fetch_assoc($sub_result);
            $parentID = $child_category['parent'];
            $maincategory_query = "SELECT * FROM categories WHERE id = '".$parentID."'";
            $main_result =  $db->query($maincategory_query);
            $parent_category = mysqli_fetch_assoc($main_result);
        ?>
            <tr>
                <td><a href="restore_products.php?restore=<?php echo $product['id']; ?>" class="btn btn-info"><span class="glyphicon glyphicon-refresh"></span></a></td>
                <td><?php echo $product['title']; ?></td>
                <td><?php echo money($product['price']); ?></td>
                <td><?php echo $parent_category['category']; ?> ~ <?php echo $child_category['category']; ?></td>
                <td>
                    <a href="products.php?featured=<?php echo (($product['featured']==0)?'1':'0'); ?>&id=<?php echo $product['id']?>" class="btn btn-default">
                        <span class="glyphicon glyphicon-<?php echo (($product['featured']==1)?'minus':'plus'); ?>"></span>
                    </a>
                    &nbsp <?php echo (($product['featured']==1)?'Featured Product':''); ?>
                </td>
            </tr>
        <?php endwhile;?>
    </tbody>
</table>

<?php
    include 'includes/footer.php';
?>
