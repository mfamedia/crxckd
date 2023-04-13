<?php
    require "../../functions.php";
    if(isset($_POST['submit'])){
        $response = crxckdLoginUser($_POST['username'], $_POST['password']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="./_auth.css">
</head>
<body>
    <form action="" method="POST">
        <h3>login</h3>
        <input type="text" placeholder="username" name="username" value="<?php echo @$_POST['username']; ?>">
        <input type="password" placeholder="password" name="password" value="<?php echo @$_POST['password']; ?>">
        <button type="submit" name="submit">Submit</button>

        <p class="error"><?php echo @$response; ?></p>
    </form>
</body>
</html>