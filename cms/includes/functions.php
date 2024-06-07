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
        $_SESSION['error'] = true;
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
        $type = isset($_SESSION['error']) ? 'error' : 'success';
        echo "<script type='text/javascript'> showToast('" . $_SESSION['message'] . "','top right','" . $type . "')</script>";
        unset($_SESSION['message']);
        unset($_SESSION['error']);
    }
}
