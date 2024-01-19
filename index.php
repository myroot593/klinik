<?php
require "database/Settings.php";
require "app/core/Splautoload.php";
session_set_save_handler($handler,true);
session_start();
if(!empty($handler->read(session_id())))header("location:user/?page=home");
$handler->gc(200000);
$login->login_index();
?>

