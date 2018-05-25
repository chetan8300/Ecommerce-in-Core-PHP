<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <a href="index.php" class="navbar-brand">Admin Panel</a>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <!-- Menu Items -->
                <li><a href="brands.php">Brands</a></li>
                <li><a href="categories.php">Category</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="archived.php">Archived</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="admin_users.php">Admin Users</a></li>
                        <li><a href="front_end_users.php">Front End Users</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="profile-ava">
                            <img alt="" src="/ecommerce/assets/images/mini.jpg">
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="eborder-top">
                            <a href="#" class="btn"><span class="fa fa-male"></span> My Profile</a>
                        </li>
                        <li>
                            <a href="logout.php" class="btn"><span class="fa fa-sign-out"></span> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>