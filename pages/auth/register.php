<?php 
	require "../../functions.php";
  
	if(isset($_POST['submit'])){
		$response = crxckdRegisterUser($_POST['username'], $_POST['password'], $_POST['confirm-password']);
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER - CRXCKD</title>
    <link rel="stylesheet" href="./_auth.css">
</head>
<body>
    <form action="" method="POST">
        <h3>register</h3>
        <input type="text" placeholder="username" name="username" value="<?php echo @$_POST['username']; ?>">
        <input type="password" placeholder="password" name="password" value="<?php echo @$_POST['password']; ?>">
        <input type="password" placeholder="confirm password" name="confirm-password" value="<?php echo @$_POST['confirm-password']; ?>">
        <button type="submit" name="submit">Submit</button>

        <?php 
			if(@$response == "success"){
				?>
					<p class="success">The registration was successful</p>
				<?php
			}else{
				?>
					<p class="error"><?php echo @$response; ?></p>
				<?php
			}
		?>
    </form>
</body>
</html>