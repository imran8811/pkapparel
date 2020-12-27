<?php
    include_once("init.php");
    $user = new User();
    $logout = $user->logout();
    if($logout){
        header("Location: index.php");
	}
?>