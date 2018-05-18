<?php 

include("config.php");
        
if(isset($_POST['registreren'])) {           
    $username       = $_POST['username'];
    $password       = $_POST['password'];
    $passwordCheck  = $_POST['passwordCheck'];
                
    $query_check = "SELECT username FROM users WHERE username= '$username'";
    $result = mysqli_query($conn, $query_check);  
    $count = mysqli_num_rows($result);
                
    if($count == 0) {
        if ($password == $passwordCheck) {
            $sql = "INSERT INTO users (username, password)
            VALUES ('".mysqli_real_escape_string($conn, $username)."',
                    '".mysqli_real_escape_string($conn, md5($password))."')";
            mysqli_query($conn, $sql);
            $output = 'Deze gebruiker is succesvol toegevoegd <br> Wacht tot je account geverifieerd is door de beheerder'; 
        } else {
            $output = "Wachtwoord komt niet overeen";
        }
    } else {
        $output = "Gebruiker bestaat al";
    }
                
}
?>
    
<html>

<head>
    <title>Dsquad - MEMES</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>
    <div class="login">
    <form id="login_form" method="post">   
        <a href="index.php">
            <img src="assets/images/logo.png">
        </a>
        <h4><?php echo $output; ?></h4>
        <input autocomplete="off" type="text" name="username" pattern="[Aa-Zz0-9]{1,20}" placeholder="Username" required>
        <input autocomplete="off" type="password" name="password" placeholder="password" required>
        <input autocomplete="off" type="password" name="passwordCheck" placeholder="password check" required>
        <div class="formMeta">
            <a href="index.php">Heeft u al een acount?</a>
            <div style="clear: both"></div>
        </div>
        <input autocomplete="off" class="submit" type="submit" name="registreren" value="Registreren">
    </form>
    </div>
</body>
</html>
