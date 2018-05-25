<?php
    require_once '../core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
    
    //Delete A Product
    if(isset($_GET['delete']) && !empty($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_query = "UPDATE products SET deleted = 1 WHERE id = '".$delete_id."'";
        $db->query($delete_query);
        header("Location: products.php");
    }
    
    //Add A New Product or Edit A Product
    if(isset($_GET['add']) || (isset($_GET['edit']) && !empty($_GET['edit']))){
        $brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
        $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
        $errors = array();
        
        //For Editing a Product
        if(isset($_GET['edit'])){
            $edit_id = (int)$_GET['edit'];
            
        }
        
        //For Adding a Product
        if($_POST){
            $title = sanitize($_POST['title']);
            $brand = sanitize($_POST['brand']);
            $categories = sanitize($_POST['child']);
            $price = sanitize($_POST['price']);
            $list_price = sanitize($_POST['list_price']);
            $sizes = sanitize($_POST['sizes']);
            $description = sanitize($_POST['description']);
            $dbpath = '';
            if(!empty($_POST['sizes'])){
                $sizes_qtys_String = sanitize($_POST['sizes']);
                $sizes_qtys_string_Array = explode(',', $sizes_qtys_String);
                $sizesArray = array();
                $qtysArray = array();
                foreach($sizes_qtys_string_Array as $sizestr){
                    $sizes_qtys_array = explode(':', $sizestr);
                    $sizesArray = $sizes_qtys_array[0];
                    $qtysArray = $sizes_qtys_array[1];
                }
            }
            else{
                $sizeArray = array();
            }
            
            $required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
            foreach ($required as $field){
                if($_POST[$field] == ''){
                    $errors[] .= "All fields with Asterisk(*) are required.";
                    break;
                }
            }
            if(!empty($_FILES)){
                $photo = $_FILES['photo'];
                $name = $photo['name'];
                $nameArray = explode('.', $name);
                $fileName = $nameArray[0];
                $fileExtension = $nameArray[1];
                $mime = explode('/', $photo['type']);
                $mimeType = $mime[0];
                $mimeExtension = $mime[1];
                $tmpLocation = $photo['tmp_name'];
                $fileSize = $photo['size'];
                $allowed_file_extensions = array('png', 'jpg', 'jpeg', 'gif');
                $uploadName = md5(microtime()).'.'.$fileExtension;
                $uploadPath = BASEURL.'assets/images/products/'.$uploadName;
                $dbPath = '/ecommerce/assets/images/products/'.$uploadName;
                if($mimeType != 'image'){
                    $errors[] .= "The file must be an Image";
                }
                if (!in_array($fileExtension, $allowed_file_extensions)){
                        $errors[] .= "The Photo Extension must be PNG, JPG, JPEG or GIF.";
                }
                if($fileSize > 1000000){
                    $errors[] .= "The Photo size must be less than 10MB.";
                }
                if($fileExtension != $mimeExtension && ($mimeExtension == 'jpeg' && $fileExtension != 'jpg')){
                    $errors[] .= "The File extension does not match the file";
                }
            }
            if(!empty($errors)){
                echo display_errors($errors);
            }
            else{
                //Upload image file and insert into database
                move_uploaded_file($tmpLocation, $uploadPath);
                $insertProduct = "INSERT INTO `products`(`title`, `price`, `list_price`, `brand`, `category`, `image`, `description`, `sizes`)
                                  VALUES ('".$title."','".$price."','".$list_price."','".$brand."','".$categories."','".$dbPath."','".$description."','".$sizes."')";
                $db->query($insertProduct);
                header("Location: products.php");
            }
        }
    ?>
    
    <h2 class="text-center"><?php echo ((isset($_GET['edit']))?'Edit a':'Add a')?> Product</h2><hr>
    <form class="form" action="products.php?<?php echo ((isset($_GET['edit']))?'edit='.$edit_id:'add=1')?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="form-group col-md-3">
                <label for="title">Title*: </label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo ((isset($_POST['title']))?sanitize($_POST['title']):''); ?>">
            </div>
            <div class="form-group col-md-3">
                <label for="brand">Brand*:</label>
                <select class="form-control" name="brand" id="brand"> 
                    <option value="" <?php echo (((isset($_POST['brand']) && $_POST['brand'] == ''))?'':'selected=selected');?>></option>
                    <?php while ($brand_result = mysqli_fetch_assoc($brandQuery)): ?>
                    <option value="<?php echo $brand_result['id'];?>" <?php echo (((isset($_POST['brand']) && $_POST['brand'] == $brand_result['id']))?' selected=selected':'');?>><?php echo $brand_result['brand'];?></option>
                    <?php endwhile;?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="parent">Parent Category*:</label>
                <select class="form-control" id="parent" name="parent">
                    <option value="" <?php echo (((isset($_POST['parent']) && $_POST['parent'] == ''))?' selected=selected':'');?>></option>
                    <?php while ($parent_result = mysqli_fetch_assoc($parentQuery)): ?>
                    <option value="<?php echo $parent_result['id'];?>" <?php echo (((isset($_POST['parent']) && $_POST['parent'] == $parent_result['id']))?' selected=selected':'');?>><?php echo $parent_result['category'];?></option>
                    <?php endwhile;?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="child">Child Category*:</label>
                <select class="form-control" name="child" id="child">
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="price">Price*:</label>
                <input type="text" class="form-control" name="price" id="price" value="<?php echo ((isset($_POST['price']))?sanitize($_POST['price']):'')?>">
            </div>
            <div class="form-group col-md-3">
                <label for="list_price">List Price:</label>
                <input type="text" class="form-control" name="list_price" id="list_price" value="<?php echo ((isset($_POST['list_price']))?sanitize($_POST['list_price']):'')?>">
            </div>
            <div class="form-group col-md-3">
                <label>Quantity & Sizes*:</label>
                <button class="btn btn-default form-control" onclick="jQuery('#sizeModal').modal('toggle');return false;">Quantity & Sizes</button>
            </div>
            <div class="form-group col-md-3">
                <label for="sizes">Sizes & Quantity Preview</label>
                <input type="text" class="form-control" id="sizes" name="sizes" value="<?php echo ((isset($_POST['sizes']))?$_POST['sizes']:''); ?>" readonly>  
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="photo">Product Photo:</label>
                <input type="file" name="photo" id="photo" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control" rows="6"><?php echo ((isset($_POST['description']))?$_POST['description']:''); ?></textarea>
            </div>
        </div>
        <div class="pull-right">
            <a href="products.php" class="btn btn-default">Cancel</a>
            <input type="submit" value="<?php echo ((isset($_GET['edit']))?'Edit ':'Add ')?>Product" class="btn btn-success">
        </div>
    </form>
        <!-- Modal For Sizes & Quantity -->
        <div class="modal fade" id="sizeModal" tabindex="-1" aria-labelledby="sizesModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="sizesModalLabel">Sizes & Quantity</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <?php for($i=1; $i<=10; $i++): ?>
                            <div class="form-group col-md-4">
                                <label for="size<?=$i;?>">Size: </label>
                                <input type="text" class="form-control" name="size<?=$i;?>" id="size<?=$i;?>" value="<?php echo ((!empty($sizesArray[$i-1]))?$sizesArray[$i-1]:''); ?>"> 
                            </div>
                            <div class="form-group col-md-2">
                                <label for="qty<?=$i;?>">Quantity: </label>
                                <input type="number" class="form-control" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?php echo ((!empty($qtysArray[$i-1]))?$qtysArray[$i-1]:''); ?>"> 
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateSizes(); jQuery('#sizeModal').modal('toggle'); return false;">Save changes</button>
                </div>
            </div>
          </div>
        </div>
    <?php
    }
    
    else{

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
    <a href="products.php?add=1" class="btn btn-success text-center">Add A Product</a><hr>
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
                <td><a href="products.php?edit=<?php echo $product['id']; ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
                <td><a href="products.php?delete=<?php echo $product['id']; ?>" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
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
    } include 'includes/footer.php';
?>