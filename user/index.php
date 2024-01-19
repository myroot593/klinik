<?php
require "../database/Settings.php";
require "../app/core/Splautoload.php";
session_set_save_handler($handler,true);
session_start();
if(empty($handler->read(session_id())))
{
	header("location:../");
}
else
{
	$_SESSION['created']=time();
	$module->Runuser('../',$_SESSION['user_id']);
}
?>

