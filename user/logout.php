<?php
require_once "../database/Settings.php";
require_once "../app/auth/Auth.php";
$handler = new Auth($databases);
session_set_save_handler($handler, true);
session_start();
(!empty($handler->read(session_id())))
?
(session_destroy())?header("location:../"):""
:
header("location:../");
