<?php
include('includes/config.php');
include('includes/functions.php');
session_destroy();

header("Location:".base_url());
die();
