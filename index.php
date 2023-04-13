<?php 
	require "functions.php";
	
	if(!isset($_SESSION['user'])){
		header("location: $URL_REDIRECT_IF_NOT_LOGGED_IN");
		exit();
	}

    if(isset($_GET['logout'])){
		crxckdLogoutUser();
	}

    require "CAS.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRXCKD</title>
</head>
<body>
    <h1>Welcome to crxckd, <?php echo $_SESSION['user'];?></h1>
    <p>Your role on the site: <?php if ($_SESSION['account_type'] == 1){
        echo 'USER/GUEST';
    } else if ($_SESSION['account_type'] == 2) {
        echo 'ADMIN';
    }?></p>

    <a href="?logout">logout</a>
</body>
</html>