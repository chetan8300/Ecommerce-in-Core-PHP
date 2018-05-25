<?php
    require_once 'includes/session.php';
    require_once '../core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
        
    //For Fetching product data from database
    $brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
    $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");

    $sql = "SELECT * FROM products WHERE deleted = 0";
    $product_result = $db->query($sql);
    
    //Add or Remove Featured Products
    if(isset($_GET['featured'])){
        $id = (int)$_GET['id'];
        $featured = (int)$_GET['featured'];
        
        $update_featured = "UPDATE products SET featured = '".$featured."' WHERE id = '".$id."'";
        $db->query($update_featured);
        header('Location: products.php');
    }
    
?>

<h2 class="text-center">Product</h2><hr>
<div class="text-center">
    <a href="add_products.php" class="btn btn-success text-center">Add A Product</a><hr>
</div>
<table class="table table-bordered table-striped">
    <thead>
        <th>Edit</th>
        <th>Delete</th>
        <th>Product</th>
        <th>Price</th>
        <th>Category</th>
        <th>Featured</th>
        <th>Sold</th>
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
                <td><a href="edit_products.php?edit=<?php echo $product['id']; ?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span></a></td>
                <td><a href="delete_products.php?delete=<?php echo $product['id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
                <td><?php echo $product['title']; ?></td>
                <td><?php echo money($product['price']); ?></td>
                <td><?php echo $parent_category['category']; ?> ~ <?php echo $child_category['category']; ?></td>
                <td>
                    <a href="products.php?featured=<?php echo (($product['featured']==0)?'1':'0'); ?>&id=<?php echo $product['id']?>" class="btn btn-default">
                        <span class="glyphicon glyphicon-<?php echo (($product['featured']==1)?'minus':'plus'); ?>"></span>
                    </a>
                    &nbsp <?php echo (($product['featured']==1)?'Featured Product':''); ?>
                </td>
                
                <td><?php echo $product['id']; ?></td>
            </tr>
        <?php endwhile;?>
    </tbody>
</table>

<?php
    include 'includes/footer.php';
?>