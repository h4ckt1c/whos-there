<?php require_once("reset-password.php"); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Anwesenheitsliste</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container" style="width: 400px">
        <div class="page-header">
            <h1>Who's there?! - Reset</h1>
        </div>
        <form method="post">
            <input class="form-control" type="password" name="password" placeholder="Password..."><br>
            <input style="width: 120px; margin: 5px;" type="submit" class="btn btn-submit" value="Submit!">
        </form>
    </div>
    <?php
        if(isset($_POST['password']) && $_POST['password'] == $password) {
            fclose(fopen("user.txt", "w"));
            header('Location: index.php');
        }
    ?>
</body>
</html>

