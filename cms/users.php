<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
secure();
include("includes/header.php");

if (isset($_GET['delete'])) {

    if ($stm = $connect->prepare("DELETE FROM users WHERE id = ?")) {
        $stm->bind_param("i", $_GET['delete']);
        $stm->execute();
        set_message(sprintf("User %d sucessfully deleted!", $_GET['delete']));
        header("Location:" . base_url() . "users.php");
        $stm->close();
        die();
    } else {
        echo "Error: Couldn't delete user!";
    }
}
if ($stm = $connect->prepare("SELECT * FROM users")) {
    $stm->execute();

    $result = $stm->get_result();

    if ($result->num_rows > 0) {

?>


        <div class="container mt-5">
            <div class="row justify-content-center">
                <h1 class="display-1">Users Management</h1>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Edit|Delete</th>
                    </tr>
                    <?php
                    while ($record = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $record['id']; ?></td>
                            <td><?php echo $record['username']; ?></td>
                            <td><?php echo $record['email']; ?></td>
                            <td>
                                <?php
                                if ($record['active'] == 1) {
                                    echo "Active";
                                } else {
                                    echo "Inactive";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo $base_path; ?>user_edit.php?id=<?php echo $record['id']; ?>">Edit</a>|
                                <a href="<?php echo $base_path; ?>users.php?delete=<?php echo $record['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php }

                    ?>
                </table>
                <a href="<?php echo $base_path ?>users_add.php">Add new user</a>
            </div>
        </div>

<?php
    } else {

        echo "No users found!";
    }
    $stm->close();
} else {
    echo "Error: Couldn't find statement!";
}

include("includes/footer.php");
?>