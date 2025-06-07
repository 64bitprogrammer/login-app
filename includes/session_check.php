<?php

if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_email']))
{
	header('location: logout.php?msg=please-log-in');
	exit ;
}
