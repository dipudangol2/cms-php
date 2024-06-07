<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
secure();
include("includes/header.php");

if (isset($_POST['username'])) {

    if ($stm = $connect->prepare(" UPDATE users SET username = ?, email = ?, active = ? WHERE id = ?")) {
        $stm->bind_param("sssi", $_POST['username'], $_POST['email'], $_POST['active'], $_GET['id']);
        $stm->execute();
        $stm->close();
    } else {
        echo "Error: Couldn't update user!";
    }

    if (isset($_POST["password"])) {

        if ($stm = $connect->prepare(" UPDATE users SET password = ? WHERE id = ?")) {
            $hashed = sha1($_POST['password']);
            $stm->bind_param("si", $hashed, $_GET['id']);
            $stm->execute();
            $stm->close();
        } else {
            echo "Error: Couldn't change password!";
        }
    }
    set_message(sprintf("User %d sucessfully updated!", $_GET['id']));
    header("Location:" . base_url() . "users.php");
    die();
}
if (isset($_GET['id'])) {
    if ($stm = $connect->prepare(" SELECT * FROM users where id= ?")) {
        $stm->bind_param("i", $_GET['id']);
        $stm->execute();

        $result = $stm->get_result();
        $post = $result->fetch_assoc();

        if ($post) {



?>


            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1 class="display-1">Edit Users </h1>

                        <form method="POST">
                            <!-- Username input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="username" name="username" class="form-control active" value="<?php echo $post['username']; ?>" />
                                <label class="form-label" for="form1Example1">Username </label>
                            </div>

                            <!-- Email input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control active" value="<?php echo $post['email']; ?>" />
                                <label class="form-label" for="form1Example1">Email address</label>
                            </div>

                            <!-- Password input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="password" name="password" class="form-control " />
                                <label class="form-label" for="form1Example2">Password</label>
                            </div>

                            <!--Active selection-->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <select name="active" class="form-select" id="active">
                                    <option <?php echo ($post['active']) ? "selected" : ""; ?> value="1">Active</option>
                                    <option <?php echo ($post['active']) ? "" : "selected"; ?> value="2">Inactive</option>
                                </select>
                            </div>
                            <!-- Submit button -->
                            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Update user</button>
                        </form>
                    </div>
                </div>
            </div>

<?php
        }
        $stm->close();
    } else {
        echo "Error: Couldn't find statement!";
    }
} else {
    echo "No user found!";
    die();
}
include("includes/footer.php");
?>