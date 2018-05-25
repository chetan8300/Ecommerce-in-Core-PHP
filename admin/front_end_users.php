<?php
    require_once 'includes/session.php';
    require_once '../core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
    $i=1;
    $user_fetch_query = "SELECT * FROM users";
    $user_fetch = $db->query($user_fetch_query);
?>
<div class="container">
    <h3 class="text-center">Front End Users</h3><hr>
    <div class="text-center">
        <a href="add_user.php" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-user"></span> Add User</a>
    </div><hr>
    <table class="table table-bordered table-striped text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = mysqli_fetch_assoc($user_fetch)){ ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $user['firstname']." ".$user['lastname']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><a href="edit_user.php?edit=<?php echo $user['id']; ?>&type=regular" class="btn btn-info"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a href="delete_user.php?delete=<?php echo $user['id']; ?>&type=regular" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>    
</div>
<?php
    include 'includes/footer.php';
?>