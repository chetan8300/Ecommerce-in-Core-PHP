<?php
    require_once 'core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
    include 'includes/left-sidebar.php';

    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM products WHERE id = '" . $id . "'";
    $product = $db->query($sql);
    $product_result = mysqli_fetch_assoc($product);
    $brand_id = $product_result['brand'];
    $sql2 = "SELECT brand FROM brand WHERE id = '" . $brand_id . "'";
    $brand_query = $db->query($sql2);
    $brand = mysqli_fetch_assoc($brand_query);
    $sizestring = $product_result['sizes'];
    $size_array = explode(',', $sizestring);
?>
<div class="col-md-8">
    <div class="container-fluid">
        <h2 class="text-center"><?php echo $product_result['title']; ?></h2>
        <div class="row">
            <span id="product_errors" class="bg-danger"></span>
            <div class="col-md-6">
                <div class="center-block">
                    <img src="<?php echo $product_result['image']; ?>" alt="<?php echo $product_result['title']; ?>" class="img-responsive">
                </div>
            </div>
            <div class="col-md-6">
                <h4>Details</h4>
                <p><?php echo $product_result['description']; ?></p>
                <hr>
                <p class="text-danger"><b>Price: <s>$<?php echo $product_result['list_price']; ?></s></b></p>
                <p><b>Our Price: $<?php echo $product_result['price']; ?></b></p>
                <p><b>Brand: <?php echo $brand['brand']; ?></b></p>
                <form action="add_cart.php" method="post" id="add_product_form">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <input type="hidden" name="available" id="available" value="">
                    <div class="row top-buffer">
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label for="quantity">Quantity: </label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="12">
                            </div>
                        </div>
                    </div>
                    <div class="row top-buffer">
                        <div class="form-group">
                            <div class="col-xs-9">
                                <label for="size">Size</label>
                                <select name="size" id="size" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    foreach ($size_array as $string) {
                                        $string_array = explode(':', $string);
                                        $size = $string_array[0];
                                        $available = $string_array[1];
                                        if($available > 0){
                                        ?>
                                            <option value="<?php echo $size ?>" data-available="<?php echo $available?>"><?php echo $size ?> (<?php echo $available ?> Available)</option>
                                    <?php 
                                        }
                                    } 
                                    ?>
                                </select>
                            </div><br>
                        </div>
                    </div>
                    <div class="row top-buffer">
                        <div class="pull-right">
                            <a href="index.php" class="btn btn-warning">Back to Featured Products</a>
                            <button class="btn btn-danger" onclick="add_to_cart(); return false;"><span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
        $("#size").change(function(){
        var available = $("#size option:selected").data("available");
        $("#available").val(available);
        });
</script>

<?php
    include 'includes/right-sidebar.php';
    include 'includes/footer.php';
?>