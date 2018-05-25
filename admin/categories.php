<?php
    require_once 'includes/session.php';
    require_once '../core/init.php'; 
    include 'includes/head.php';
    include 'includes/navigation.php';
    
    $sql = "SELECT * FROM categories WHERE parent = 0";
    $category = $db->query($sql);
    $add_cat = '';
    $post_parent = 0;
    
    //Edit A Category
    if(isset($_GET['edit']) && !empty($_GET['edit'])){
        $edit_id = (int)$_GET['edit'];
        $edit_id = sanitize($edit_id);
        $edit_sql = "SELECT * FROM categories WHERE id = '".$edit_id."'";
        $cat_result = $db->query($edit_sql);
        $edit_category = mysqli_fetch_assoc($cat_result);
    }
    
    //Delete A Category
    if(isset($_GET['delete']) && !empty($_GET['delete'])){
        $delete_id = (int)$_GET['delete'];
        $delete_id = sanitize($delete_id);
        $sql = "SELECT * FROM categories WHERE id = '".$delete_id."'";
        //to check for sub category and delete it
        $check_subcat = $db->query($sql);
        $subcat = mysqli_fetch_assoc($check_subcat);
        //it will check if the category which is going to be deleted is parent category or not
        if($subcat['parent'] == 0){
            $delete_query = "DELETE FROM categories WHERE parent = '".$delete_id."'";
            $db->query($delete_query);
        }
        $delete_query = "DELETE FROM categories WHERE id = '".$delete_id."'";
        $db->query($delete_query);
        header('Location: categories.php');
    }
    
    //Process Form and Check Category
    if(isset($_POST['submit_form']) && !empty($_POST['submit_form'])){
        $errors = array();
        $post_parent = sanitize($_POST['parent']);
        $add_cat = sanitize($_POST['category']);
        
        //If category is empty
        if($add_cat == ''){
            $errors[] .= "You must enter Category before submitting Form.";
        }else{
            $sql2 = "SELECT * FROM categories WHERE category='".$add_cat."' AND parent = '".$post_parent."'";
            if(isset($_GET['edit'])){
                $id = $edit_category['id'];
                $sql2 = "SELECT * FROM categories WHERE category='".$add_cat."' AND parent = '".$post_parent."' AND id != '".$id."'";
            }
            $category_check = $db->query($sql2);
            $count = mysqli_num_rows($category_check);
            if($count > 0){
                $errors[] .= $add_cat." Already Exists. Please Enter another Category.";
            }
        }
        
        //Display errors or Update or Add in database
        if(!empty($errors)){
            $display_errors = display_errors($errors); ?>
        <script>
            jQuery('document').ready(function(){
                jQuery('#display_errors').html('<?php echo "<b>".$display_errors."</b>"; ?>');
            });
        </script>
        <?php }
            else{
                //update or add category to database
                $add_query = "INSERT INTO categories(category, parent) VALUES ('".$add_cat."', '".$post_parent."')";
                if(isset($_GET['edit'])){
                    $add_query = "UPDATE categories SET category = '".$add_cat."', parent = '".$post_parent."' WHERE id = '".$edit_id."'";
                }
                echo 
                $db->query($add_query); 
                header('Location: categories.php');
            }
    }
    
    $category_name = '';
    $parent_value = 0;
    if(isset($_GET['edit'])){
        $category_name = $edit_category['category'];
        $parent_value = $edit_category['parent'];
    }
    else{
        if(isset($_POST)){
            $category_name = $add_cat;
            $parent_value = $post_parent;
        }
    }
    
?>
<h2 class="text-center">Category</h2><hr>

<div class="row">
    <!-- Form -->
    
    <div class="col-md-6">
        <form class="form" action="categories.php<?php echo ((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
            <legend class="text-center"><?php echo ((isset($_GET['edit']))?'Edit A':'Add A');?> Category</legend>
            <div id="display_errors"></div>
            <div class="form-group">
                <label for="parent">Parent</label>
                <select class="form-control" name="parent" id="parent">
                    <option value="0"<?php echo (($parent_value == 0)?' selected=selected':''); ?>>Parent</option>
                    <?php 
                        $sql = "SELECT * FROM categories WHERE parent = 0";
                        $category = $db->query($sql);
                        while($category_result = mysqli_fetch_assoc($category)){ ?>
                        <option value="<?php echo $category_result['id']; ?>"<?php echo (($parent_value == $category_result['id'])?' selected=selected':''); ?>><?php echo $category_result['category']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php if(isset($_GET['edit'])) echo $category_name; ?>">
            </div>
            <div class="form-group text-center">
                <?php if(isset($_GET['edit'])) { ?>
                <a href="categories.php" class="btn btn-default">Cancel</a>
                <?php } ?>
                <input type="submit" name="submit_form" class="btn btn-success" value="<?php echo ((isset($_GET['edit']))?'Edit':'Add');?> Category">
            </div>
        </form>
    </div>
    
    <!-- Categories Table -->
    
    <div class="col-md-6">
        <table class="table table-bordered text-center">
            <thead class="text-center">
                <th>Category</th>
                <th>Parent</th>
                <th>Edit</th>
                <th>Delete</th>
            </thead>
            <tbody>
                <?php
                    $category = $db->query($sql);
                    while($category_result = mysqli_fetch_assoc($category)) {
                        $parent_id = (int)$category_result['id'];
                        $sql2 = "SELECT * FROM categories WHERE parent = '".$parent_id."'";
                        $subcategory = $db->query($sql2);
                ?>
                    <tr class="bg-primary">
                        <td><?php echo $category_result['category'];?></td>
                        <td>Parent</td>
                        <td>
                            <a href="categories.php?edit=<?php echo $category_result['id']?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></a>
                        </td>
                        <td>
                            <a href="categories.php?delete=<?php echo $category_result['id']?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
                        </td>
                    </tr>
                    <?php while($subcategory_result = mysqli_fetch_assoc($subcategory)){?>
                        <tr class="bg-info">
                            <td><?php echo $subcategory_result['category'];?></td>
                            <td><?php echo $category_result['category'];?></td>
                            <td>
                                <a href="categories.php?edit=<?php echo $subcategory_result['id']?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></a>
                            </td>
                            <td>
                                <a href="categories.php?delete=<?php echo $subcategory_result['id']?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<?php
    include 'includes/footer.php';
?>