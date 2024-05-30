<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
secure();
include("includes/header.php");
var_dump($_SESSION);
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <h1 class="display-1">Dashboard</h1>
        <div class="col-md-6">
            <a href="<?php echo $base_path; ?>users.php">User Management</a>|
            <a href="<?php echo $base_path; ?>posts.php">Post Mangement</a>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>