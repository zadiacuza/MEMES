<?php include("config.php");

if(isset($_POST['login'])) {                           
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    
    $sel_user   = "SELECT * FROM users WHERE username='$username' AND password='$pass'";
    $run_user   = mysqli_query($conn, $sel_user);
    $row        = mysqli_fetch_object($run_user);
    $user_id    = $row->id;
    $gebruikersnaam   = $row->username;
    $wachtwoord       = $row->password;
    $Pimage           = $row->image;
    $verification     = $row->verification;
    $check_user = mysqli_num_rows($run_user);
    if($verification > 0){
        if($check_user > 0){
            $_SESSION['id']=$user_id;
            $_SESSION['username']=$gebruikersnaam;
            $_SESSION['password']=$wachtwoord;
            $_SESSION['image']=$Pimage;
            header("Location: dashboard.php");
            exit();
        } else {
            $output = "Je gebruikersnaam of wachtwoord is niet correct";
        }
    } else {
        $output = "Je acount is nog niet geverifieerd door de beheerder";
    }
}
        
?>

<html>

<head>
    <title>Memevote</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>
    <div class="login wrapper">
        <form id="login_form" method="post">
            <img src="assets/images/logo.png">
            <h4>
                <?php echo $output; ?>
            </h4>
            <input autocomplete="off" type="text" name="username" placeholder="username" required pattern="[Aa-Zz0-9]{1,20}">
            <input autocomplete="off" type="password" name="password" placeholder="password" required>
            <div class="formMeta">
                <a href="registreren.php">Register?</a>
                <a href="registreren.php">Forgot password?</a>
                <div style="clear: both"></div>
            </div>
            <input autocomplete="off" class="submit" type="submit" name="login" value="Login">
        </form>
    </div>
</body>

</html>

