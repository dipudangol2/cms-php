<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
$pageStyles = "css/post.css";
secure();

include("includes/header.php");

if (isset($_GET['delete'])) {

    if ($stm = $connect->prepare("DELETE FROM posts WHERE id = ?")) {
        $stm->bind_param("i", $_GET['delete']);
        $stm->execute();
        set_message(sprintf("Post %d sucessfully deleted!", $_GET['delete']));
        header("Location:" . base_url() . "posts.php");
        $stm->close();
        die();
    } else {
        echo "Error: Couldn't delete post!";
    }
}
if ($stm = $connect->prepare("SELECT * FROM posts")) {
    $stm->execute();

    $result = $stm->get_result();

    if ($result->num_rows > 0) {

?>


        <div class="container mt-5">
            <div class="row justify-content-center">
                <h1 class="display-1">Posts Management</h1>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author's ID</th>
                        <th>Content</th>
                        <th>Edit|Delete</th>
                    </tr>
                    <?php
                    while ($record = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $record['id']; ?></td>
                            <td><?php echo $record['title']; ?></td>
                            <td><?php echo $record['author']; ?></td>
                            <td><?php echo $record['content']; ?></td>
                            <td>
                                <a href="<?php echo $base_path; ?>posts_edit.php?id=<?php echo $record['id']; ?>">Edit</a>|
                                <a href="<?php echo $base_path; ?>posts.php?delete=<?php echo $record['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php }

                    ?>
                </table>
                <a href="<?php echo $base_path ?>posts_add.php">Add new Post</a>
            </div>
        </div>


    <?php
    } else { ?>
        No Posts found!
        <a href="<?php echo $base_path ?>posts_add.php">Add new Post</a>
<?php
    }
    $stm->close();
} else {
    echo "Error: Couldn't find statement!";
}

include("includes/footer.php");
?>