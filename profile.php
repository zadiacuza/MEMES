<?php include("config.php"); ?>

<html>

<head>
    <title>Page Title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php include("hotjar.php"); ?>
</head>

<body>
    <nav>
        <p><?php echo ucfirst($_SESSION['username']); ?></p>
        <i class="fa fa-bars" aria-hidden="true"></i>
        <ul class="hidden">
            <li><a href="dashboard.php">Berichten</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    
    <form method="post" id="update" enctype="multipart/form-data">
        
        <?php 

             if(isset($_POST['send'])) {
                 
                $target         = "images/".basename($_FILES['image']['name']);

                $login_id       = $_SESSION['username']; 
                $bericht        = $_POST['bericht'];
                $image          = $_FILES['image']['name'];
                

                $aanmaken = "UPDATE users SET image = '$image' WHERE username = '$login_id'";

                $msqli = mysqli_query($conn, $aanmaken);
                 
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $msg = "Image uploaded successfully";
                    $Pimage         = $row->image;
                    $_SESSION['image']= $Pimage;
                    
                }else{
                    $msg = "Something went wrong!";
                }
            }

        ?>
        
        <input class="file" type="file" name="image" accept="images/*">
        <div>
            <input class="submit" type="submit" name="send" value="Send">
        </div>
    </form>
    
    <div id="wrap">
    
        <?php
    
            $login_id       = $_SESSION['username'];
            $get = "SELECT image FROM acounts WHERE username = '$login_id'";
            $res = mysqli_query($conn, $get);
                
            if($res->num_rows > 0){
                while($row = $res->fetch_assoc()) {
                            
                    echo "<article>";
                    echo "<img class='post_image' width='100%' height='auto' src='images/".$row['image']."' >";
                    echo "</article>";
                }
            }
                
            else {
                    echo "Er zijn nog geen berichten";
            }
        
        ?>
        
        
    </div>
    
    
    <script>
        $(document).ready(function () {
            $("nav .fa").click(function() {
                $("nav ul").toggle();
            });
            
            var hoogte = $("nav").height();
            
            $("nav p").css("lineHeight", hoogte + "px");
            
        });
    </script>
</body>

</html>
