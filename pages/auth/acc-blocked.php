<?php
	require "../../functions.php";
	
	if(!isset($_SESSION['user'])){
		header("location: $URL_REDIRECT_IF_NOT_LOGGED_IN");
		exit();
	}

    if(isset($_GET['logout'])){
		crxckdLogoutUser();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>acc blocked</title>
</head>
<body>
    <a href="../../index.php?logout">logout</a>
</body>
</html>