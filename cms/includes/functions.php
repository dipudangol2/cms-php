<?php

function base_url()
{

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";


    $hostName = $_SERVER['HTTP_HOST'];


    $path = '';
    if (strpos($hostName, 'localhost') !== false) {
        if ($_SERVER['SERVER_PORT'] == 3000) {
            $path = '/';
        } else {

            $path = '/cms/';
        }
    }

    return $protocol . $hostName . $path;
}


function secure()
{
    if (!isset($_SESSION['id'])) {
        set_message("You are not logged in!!");
        header("Location:" . base_url());
        die();
    }
}

function set_message($message)
{

    $_SESSION['message'] = $message;
}
function get_message()
{
    if (isset($_SESSION['message'])) {
        echo "<p>" . $_SESSION['message'] . "<p> <br>";
        unset($_SESSION['message']);
    }
}
