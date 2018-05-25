<?php
$sql = "SELECT * FROM categories WHERE parent=0";
$parent_query = $db->query($sql);
?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand">Gift eCommerce</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <?php while ($parent = mysqli_fetch_assoc($parent_query)) : ?>
                    <?php
                    $parent_id = $parent['id'];
                    $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
                    $child_query = $db->query($sql2);
                    ?>
                    <!-- Menu Items -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category']; ?><span class="caret"></span></a>

                        <ul class="dropdown-menu" role="menu">
                            <?php while ($child = mysqli_fetch_assoc($child_query)) : ?>
                                <li><a href="category.php?cat=<?php echo $child['id']; ?>"><?php echo $child['category']; ?></a></li>
                            <?php endwhile; ?>
                        </ul>

                    </li>
                <?php endwhile; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="cart.php"><strong><span class="fa fa-shopping-bag"></span> My Cart</strong></a></li>
            </ul>
        </div>
    </div>
</nav>