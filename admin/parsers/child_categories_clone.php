<?php
    require_once '../../core/init.php';

    $parentID = (int)$_POST['id'];
    $query = "SELECT * FROM categories WHERE parent = '".$parentID."' ORDER BY category";
    $child_result = $db->query($query);
?>
        
<?php  ob_start(); ?>
        <option value=""></option>
    <?php while($child_category = mysqli_fetch_assoc($child_result)):  ?>
        <option value="<?php echo $child_category['id']; ?>"><?php echo $child_category['category']; ?></option>
    <?php endwhile; ?>
<?php echo ob_get_clean(); ?>