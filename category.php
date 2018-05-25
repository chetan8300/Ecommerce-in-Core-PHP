<?php
    require_once 'core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
    include 'includes/left-sidebar.php';
    
    if(isset($_GET['cat']) && !empty($_GET['cat'])){
        $category_id = $_GET['cat'];
    }
    
    
    $sql = "SELECT * FROM products WHERE category='".$category_id."'";
    $productQuery = $db->query($sql);
    $category = get_category($category_id);
?>

<!-- Main Content -->
<div class="col-md-8">
    <h3 class="text-center"><?php echo $category['parent']." / ".$category['child'];?></h3>
    <div class="row">
        <?php while($product = mysqli_fetch_assoc($productQuery)) : ?>
            <div class="col-md-4 text-center">
                <div class="thumbnail">
                    <div class="img-thumbnail">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>" style="width: 200px; height: 242px; overflow: auto">
                    </div>
                    <div class="caption">
                        <h4 class="text-center"><?php echo $product['title']; ?></h4>
                        <p class="text-danger">List Price: <s>$<?php echo $product['list_price']; ?></s></p>
                        <p>Our Price: $<?php echo $product['price']; ?></p>
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-success">Details</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>


<?php
    include 'includes/right-sidebar.php';
    include 'includes/footer.php';
?>