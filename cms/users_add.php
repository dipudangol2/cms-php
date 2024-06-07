<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
secure();
include("includes/header.php");

if (isset($_POST['username'])) {

    if ($stm = $connect->prepare(" INSERT INTO users (username, email, password, active) VALUES (?, ?, ? ,?)")) {
        $hash = sha1($_POST['password']);
        $stm->bind_param("ssss", $_POST['username'], $_POST['email'], $hash, $_POST['active']);
        $stm->execute();
        set_message(sprintf("User %s sucessfully added!", $_POST['username']));
        header("Location:" . base_url() . "users.php");
        $stm->close();
        die();

        if ($post) {
            $_SESSION['id'] = $post['id'];
            $_SESSION['email'] = $post['email'];
            $_SESSION['username'] = $post['username'];
            set_message(sprintf("Hello %s!", $_SESSION['username']));
            header("Location:" . base_url() . "dashboard.php");
            die();
        }
    } else {
        echo "Error: Couldn't find statement!";
    }
}


?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Add Users </h1>

            <form method="POST">
                <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control" />
                    <label class="form-label" for="username">Username </label>
                </div>

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Email address</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!--Active selection-->
                <div data-mdb-input-init class="form-outline mb-4">
                    <select name="active" class="form-select" id="active">
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                </div>
                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Add user</button>
            </form>
        </div>
    </div>
</div>

<?php

include("includes/footer.php");
?>