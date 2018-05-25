<?php
    require_once 'includes/session.php';
    require_once '../core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
    
    //Get brands from database
    $sql = "SELECT * FROM brand ORDER BY brand";
    $result = $db->query($sql);
    
    //Edit a Brand
    if(isset($_GET['edit']) && !empty($_GET['edit'])){
        $edit_id = (int) $_GET['edit'];    
        $edit_id = sanitize($edit_id);
        $sql2 = "SELECT * FROM brand WHERE id='".$edit_id."'";
        $edit_result = $db->query($sql2);
        $edit_brand = mysqli_fetch_assoc($edit_result);
    }
    
    //Delete Brand
    if(isset($_GET['delete']) && !empty($_GET['delete'])){
        $delete_id = (int) $_GET['delete'];
        $delete_id = sanitize($delete_id);
        $sql = "DELETE FROM brand WHERE id = ".$delete_id."";
        $db->query($sql);
        header("Location: brands.php");
    }
    
    //If add form is submitted
    if(isset($_POST['add_submit'])){
        $errors = array();
        $brand = sanitize($_POST['brand']);
        if($brand == NULL){
            $errors[] .= 'You must enter a brand';
        }else{
        //check if brand exists in database or not
            $sql2 = "SELECT * FROM brand WHERE brand='".$brand."'";
            if(isset($_GET['edit'])){
                $sql2 = "SELECT * FROM brand WHERE brand='".$brand."' AND id != '".$edit_brand."'";
                $brand_check = $db->query($sql2);    
            }
            else{
                $brand_check = $db->query($sql2);
                $count = mysqli_num_rows($brand_check);
                if($count > 0){
                    $errors[] .= $brand." Already Exists. Please Enter another brand.";
                }
            }
        }
        
        //Display errors
        if(!empty($errors)){
            echo display_errors($errors);
        }
        else{
            //add brand to database
            $sql = "INSERT INTO brand(brand) VALUES ('".$brand."')";
            if(isset($_GET['edit'])){
                $sql = "UPDATE brand SET brand = '".$brand."' WHERE id = '".$edit_id."'";
            }
            $db->query($sql);
            header('location: brands.php');
        }
    }
?>

<h2 class="text-center">Brand</h2><hr>
<!-- Brand Form -->
<div class="text-center">
    <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>" method="post">
        <div class="form-group">
            <?php
                $brand_value = '';
                if(isset($_GET['edit'])){
                    $brand_value = $edit_brand['brand'];
                }
                else{
                    if(isset($_POST['brand'])){
                        $brand_value = sanitize($_POST['brand']); 
                    }
                }
            ?>
            <label for="brand"><?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Brand: </label>
            <input type="text" name="brand" id="brand" class="form-control" value="<?php echo $brand_value; ?>">
            <?php if(isset($_GET['edit'])) { ?>
            <a href="brands.php" class="btn btn-default">Cancel</a>
            <?php }?>
            <input type="submit" name="add_submit" id="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Brand" class="btn btn-success">
        </div>
    </form>
</div><hr>

<!-- Brand Table -->
<table class="table table-bordered table-striped table-hover table-auto">
    <thead>
        <th>Edit</th>
        <th>Brand</th>
        <th>Delete</th>
    </thead>
    <tbody>
        <?php while($brand = mysqli_fetch_assoc($result)) :?>
        <tr>
            <td><a href="brands.php?edit=<?php echo $brand['id'];?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></a></td>
            <td><?php echo $brand['brand']?></td>
            <td><a href="brands.php?delete=<?php echo $brand['id'];?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php
    include 'includes/footer.php';
?>