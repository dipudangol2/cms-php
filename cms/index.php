<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
include("includes/header.php");
if (isset($_SESSION['id'])) {
    header(sprintf("Location:%s", base_url() . "dashboard.php"));
    die();
}
if (isset($_POST['email'])) {
    if ($stm = $connect->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND active = 1")) {
        $hash = sha1($_POST['password']);
        $stm->bind_param("ss", $_POST['email'], $hash);
        $stm->execute();

        $result = $stm->get_result();
        $post = $result->fetch_assoc();

        if ($post) {
            $_SESSION['id'] = $post['id'];
            $_SESSION['email'] = $post['email'];
            $_SESSION['username'] = $post['username'];
            set_message(sprintf("Hello %s!", $_SESSION['username']));
            
            header("Location:" . base_url() . "dashboard.php");
            die();
        }
        $stm->close();
    } else {
        echo "Error: Couldn't find statement!";
    }
}
?>
<?php

var_dump($_SESSION);
?>



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST">
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="form1Example1">Email address</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="form1Example2">Password</label>
                </div>

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>