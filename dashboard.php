<?php 
    include("config.php"); 

    if($_SESSION['id'] == '') {
        header('Location: index.php');
    }

    if(isset($_POST['send'])) {
             
        $target         = "images/".basename($_FILES['image']['name']);
        $login_id       = $_SESSION['username']; 
        $Pimg           = $_SESSION['image'];
        $bericht        = $_POST['bericht'];
        $image          = $_FILES['image']['name'];

        $aanmaken = "INSERT INTO messages (message, image, username, date, Pimage)
        VALUES('$bericht', '$image', '$login_id', now(), '$Pimg')";

        $msqli = mysqli_query($conn, $aanmaken);
                 
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        } else{
            $msg = "Something went wrong!";
        }
        
        header('location: dashboard.php');
    }

    if(isset($_POST['thumbUp'])) {
        $user_id    = $_SESSION['id'];
        $up_id      = $_POST['hiddenUp'];
        $getUp = "SELECT * FROM likes WHERE user_id='$user_id ' AND post_id='$up_id'";
        
        $runUp      = mysqli_query($conn, $getUp);
        $rowUp       = mysqli_fetch_object($runUp);
        $checkUp    = mysqli_num_rows($runUp);
        
        if($checkUp > 0) {
        } else {
            $up = "INSERT INTO likes (user_id, post_id) VALUES ('$user_id', $up_id)";
            $msqli = mysqli_query($conn, $up);
            
            $upLike = "UPDATE messages SET up = up + 1 WHERE id = $up_id";
            $msqliUp = mysqli_query($conn, $upLike);
            
            header('location: dashboard.php');
        }  
    }


    if(isset($_POST['thumbDown'])) {
        $user_id    = $_SESSION['id'];
        $down_id      = $_POST['hiddenDown'];
        $getDown = "SELECT * FROM likes WHERE user_id='$user_id ' AND post_id='$down_id'";
        
        $runDown      = mysqli_query($conn, $getDown);
        $rowDown       = mysqli_fetch_object($runDown);
        $checkDown    = mysqli_num_rows($runDown);
        
        if($checkDown > 0) {
        } else {
            $down = "INSERT INTO likes (user_id, post_id) VALUES ('$user_id', $down_id)";
            $msqli = mysqli_query($conn, $down);
            
            $downLike = "UPDATE messages SET down = down + 1 WHERE id = $down_id";
            $msqliDown = mysqli_query($conn, $downLike);
            
            header('location: dashboard.php');
        }  
    }
        

        
    $result = mysqli_query($db, "SELECT * FROM images");
?>
<html>

<head>
    <title>Page Title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php include("hotjar.php"); ?>
</head>

<body>
<nav>
    <div>
        <p><?php echo ucfirst($_SESSION['username']); ?></p>
        <div style="clear: both"></div>
    </div>
    <i class="fa fa-bars" aria-hidden="true"></i>
    <ul class="hidden">
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">logout</a></li>
    </ul>
</nav>
    
<form method="post" id="message" enctype="multipart/form-data">
    <textarea name="bericht" placeholder="Type your message here!!" required></textarea>
    <input class="file" type="file" name="image" accept="images/*">
    <div>
        <input class="submit" type="submit" name="send" value="Send">
    </div>
</form>
    
<div id="messages">  
    <?php
        $get = "SELECT * FROM messages ORDER BY id DESC";
        $res = mysqli_query($conn, $get);
                
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()) {
                            
                echo "<article>";
                echo "<div class='acount_info'>";
                echo "<div class='Pimage' style='background-image: url(images/".$row['Pimage']."'></div>";
                echo "<h2>";
                echo $row['username'];
                echo "</h2> <p class='postMeta'>";
                echo $row['date'];
                echo "</p>";
                echo "</div>";
                echo "<img class='post_image' src='images/".$row['image']."' >";
                echo "<p class='message'>";
                echo htmlspecialchars($row['message']);
                echo "<p>";
                
                echo "<div class='rating'>";
                    
                echo "<form method='post'>";
                echo "<span class='up'>";
                echo "<div>";
                echo "<input type='hidden' name='hiddenUp' value='".$row['id']."'>";
                echo "<input type='submit' name='thumbUp' class='thumbUp' value='up'>";
                echo "<i class='fas fa-thumbs-up'></i>";
                echo "</div>";
                echo "<p>".$row['up']."</p>";
                 echo "<div style='clear: both'></div>";
                echo "</span>";
                echo "</form>";
                    
                echo "<form method='post'>";
                echo "<span class='down'>";
                echo "<div>";
                echo "<input type='hidden' name='hiddenDown' value='".$row['id']."'>";
                echo "<input type='submit' name='thumbDown' class='thumbDown' value='Down'>";
                echo "<i class='fas fa-thumbs-down'></i>";
                echo "</div>";
                echo "<p>".$row['down']."</p>";
                 echo "<div style='clear: both'></div>";
                echo "</span>";
                echo "</form>";
                    
                echo "</div>";
                
                echo "</article>";
            }
        }       
        else {
            echo "Er zijn nog geen berichten";
        }
    ?>    
</div>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">


<script>
    $(document).ready(function () {
        $("nav .fa").click(function() {
            $("nav ul").toggle();
        });
        var hoogte = $("nav").height();            
        $("nav p").css("lineHeight", hoogte + "px");
        
        if ($(".post_image[src=='']").click(function()){
          alert('got me');
        }
    });
    </script>
    
    <footer>
        <a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=H9RMAWJ5KA84G">was deze?</a>
    </footer>
    
</body>

</html>
