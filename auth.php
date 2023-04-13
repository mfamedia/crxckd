<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTH - CRXCKD</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        iframe {
            border: none;
        }
    </style>
</head>
<body>
    <?php
        $page = $_GET['p'];
        if (!$page) {
            echo 'no page requested';
            header('Location: ./');
        } else if ($page == 'register') { // register page
            echo '<iframe width="100%" height="100%" src="./pages/auth/register.php">';
        } else if ($page == 'login') { // login page
            echo '<iframe width="100%" height="100%" src="./pages/auth/login.php">';
        } else if ($page == 'acc-sfd') { // account scheduled for deletion
            echo '<iframe width="100%" height="100%" src="./pages/auth/acc-sfd.php">';
        } else if ($page == 'acc-inmd') { // account inmediate deletion
            echo '<iframe width="100%" height="100%" src="./pages/auth/acc-inmd.php">';
        } else if ($page == 'acc-blocked') { // account blocked
            echo '<iframe width="100%" height="100%" src="./pages/auth/acc-blocked.php">';
        }
    ?>
</body>
</html>