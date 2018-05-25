<?php
    require_once 'core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
    include 'includes/headerfull.php';
    include 'includes/left-sidebar.php';
    
    $sql = "SELECT * FROM products WHERE featured = 1 AND deleted = 0";
    $featured = $db->query($sql);
?>

<!-- Main Content -->
<div class="col-md-8">
    <h3 class="text-center">Featured Products</h3>
    <div class="row">
        <?php while($product = mysqli_fetch_assoc($featured)) : ?>
        <div class="thumbnail">
            <img src="<?php echo $product['image']; ?>" class="img-size" alt="<?php echo $product['title']; ?>">
            <div class="caption">
                <h4 class="text-center">M.F.Hussain</h4>
                <p><?php echo $product['description']; ?></p>
                <p class="text-danger">List Price: <s>$<?php echo $product['list_price']; ?></s></p>
                <p>Our Price: $<?php echo $product['price']; ?></p>
                <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-success">Details</a>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <h4><?php echo $product['title']; ?></h4>
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>" class="thumbnail img-thumb" />
            <p class="text-danger">List Price: <s>$<?php echo $product['list_price']; ?></s></p>
            <p>Our Price: $<?php echo $product['price']; ?></p>
            <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-success">Details</a>
        </div>
        <?php endwhile; ?>
    </div>
</div>


<?php
    include 'includes/right-sidebar.php';
    include 'includes/footer.php';
?>