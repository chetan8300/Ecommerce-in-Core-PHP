<?php
    require_once '../core/init.php';
    $id = $_POST['id'];
    $id = (int)$id;
    $sql = "SELECT * FROM products WHERE id = '".$id."'";
    $product = $db->query($sql);
    $product_result = mysqli_fetch_assoc($product);
    $brand_id = $product_result['brand'];
    $sql2 = "SELECT brand FROM brand WHERE id = '".$brand_id."'";
    $brand_query = $db->query($sql2);
    $brand = mysqli_fetch_assoc($brand_query);
    $sizestring = $product_result['sizes'];
    $size_array = explode(',', $sizestring);
?>
<!-- Details Modal -->
<?php
    ob_start();
?>
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><?php echo $product_result['title']; ?></h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="center-block">
                                <img src="<?php echo $product_result['image']; ?>" alt="<?php echo $product_result['title']; ?>" class="details img-responsive">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h4>Details</h4>
                            <p><?php echo $product_result['description']; ?></p>
                            <hr>
                            <p>Price: $<?php echo $product_result['price']; ?></p>
                            <p>Brand: <?php echo $brand['brand']; ?></p>
                            <form action="add_cart.php" method="post">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-xs-3">
                                            <label for="quantity">Quantity: </label>
                                            <input type="text" class="form-control" id="quantity" name="quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-xs-9">
                                            <label for="size">Size</label>
                                            <select name="size" id="size" class="form-control">
                                                <option value=""></option>
                                                <?php 
                                                    foreach($size_array as $string){  
                                                        $string_array = explode(':', $string);
                                                        $size = $string_array[0];
                                                        $quantity = $string_array[1];
                                                ?>
                                                    <option value="<?php echo $size?>"><?php echo $size?> (<?php echo $quantity?> Available)</option>
                                                <?php } ?>
                                            </select>
                                        </div><br>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" onclick="closeModal()">Close</button>
                        <button class="btn btn-warning" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</button>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function closeModal(){
        jQuery('#details-modal').modal('hide');
        setTimeout(function(){
            jQuery('#details-modal').remove();
            jQuery('.modal-backdrop').remove();
        }, 1000);
    }
    
</script>
<?php echo ob_get_clean();?>