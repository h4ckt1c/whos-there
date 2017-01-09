<!DOCTYPE html>
<html lang="de">
<head>
    <title>Who's There?!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="30" URL="<?php echo $_SERVER['PHP_SELF']; ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php
    function ist_da($user) {
        if(strpos(file_get_contents("user.txt"), $user) === false) {
            file_put_contents("user.txt", $user . "\n", FILE_APPEND);
        }
    }
    function verify_cookie($pins) {
        $user = $_COOKIE['usr'];
        $pin = $_COOKIE['Pin'];
        if(!empty($user) && !empty($pin)) {
            if($pins[$user] == $pin) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    function verify_post($pins) {
        $user = $_POST['user'];
        $pin = $_POST['pin'];
        if(!empty($user) && !empty($pin)) {
            if($pins[$user] == $pin) {
                setcookie("usr", $user, time()+60*60*24*365);
                setcookie("Pin", $pin, time()+60*60*24*365);
                return true;
            }
            else {
                return false;
            }
        }
        return false;
    }

    /*
    Manage users in users.php in format:

    $pins = [
        "User1" => "1336",
        "User2" => "1337",
        "User3" => "1338",
    ];

    */
    require_once("users.php");
    $im_dienst = file_get_contents("user.txt");

    $loginform = false;
    if(isset($_COOKIE['usr'])) {
        if(verify_cookie($pins)) {
            if(isset($_POST['user'])) {
                $user = $_POST['user'];
                if(array_key_exists($user, $pins)) {
                    if($user == $_COOKIE['usr'])
                        ist_da($user);
                }
            }
        }
        else
            $loginform = true;
    }
    elseif(isset($_POST['user'])) {
        if(verify_post($pins)) {
            ist_da($_POST['user']);
            header('Location: ' . $_SERVER['PHP_SELF']);
        }
        else
            $loginform = true;
    }

?>

    <div class="container">
        <div class="page-header">
            <h1>Who's there?!</h1>
            <h3><?php echo count(file("user.txt")) . " von " . count($pins); ?></h3>
        </div>
        <form method="post">
        <?php
        if(isset($_COOKIE['usr'])) {
            $user = $_COOKIE['usr'];;
            $msg = $user . " is there";
            echo "<input style=\"width: 120px; margin: 5px;\" name=\"user\" type=\"submit\" class=\"btn btn-primary\" value=\"$user\">'s there</input><br>\n";
        echo "</form>";
        echo "<hr>";
        }
        ?>
        <form method="post">
        <p>
        <?php
            $i = 1;
            foreach($pins as $soldat => $pin) {
                if(strpos(file_get_contents("user.txt"), $soldat) !== false)
                    $class ="btn-success";
                else
                    $class = "btn-danger";
                $br = ($i % 2 == 0) ? "<br>" : null;
                echo "<input style='width: 120px; margin: 5px;' name='user' type='submit' class='btn $class' value='$soldat'></input>$br\n";
                $i++;
            }
            echo "</form>";
            echo "</p>";
            if($loginform) { ?>

            <script>
            $(document).ready(function() {
                $("#login-modal").modal("show");
            })
            </script>
            <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog">
                    <div class="loginmodal-container">
                        <h1>PIN eingeben</h1><br>
                        <form method="post">
                            <input type="tel" name="pin" id="pin" placeholder="PIN" class="login loginmodal">
                            <input type="hidden" name="user" value="<?php echo $_POST['user'];?>">
                            <input type="submit" class="login loginmodal-submit">
                        </form>
                    </div>
                </div>
            </div>
            <?php
            }
            if(isset($_POST['cookie'])) {
                unset($_COOKIE['usr']);
                setcookie("usr", null, -1);
                unset($_COOKIE['Pin']);
                setcookie("Pin", null, -1);
                header("Location: " . $_SERVER['PHP_SELF']);
            }
            if(isset($_COOKIE['usr']) || isset($_COOKIE['Pin'])) {
            ?>
            <form method="post">
                <p>
                <input name="cookie" type="submit" type="submit" class="btn" value="Logout">
                </p>
            </form>
            <?php } ?>
    </div>
    <div class="container">
        <p>
            The source code is available on <a href="https://github.com/h4ckt1c/whos-there">GitHub</a>.
        </p>
    </div>
    <footer class="footer">
        <div class="container">
        <p>
            Contact: <a href="https://twitter.com/h4ckt1c">@h4ckt1c</a> | <a href="mailto:h@ckerbu.de">h@ckerbu.de</a>
        </p>
        </div>
    </footer>
</body>
</html>

