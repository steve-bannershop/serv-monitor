<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Support</title>

    <!-- Include Bootstrap .css -->
    <!--link rel="stylesheet" href="css/bootstrap/css/bootstrap.css"-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Custom .css -->
    <link rel="stylesheet" href="css/custom/custom.css">
    <!-- Custom font -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">

    <link rel="stylesheet" href="fontawesome/css/all.css" />
    <!--link rel="stylesheet" href="fontawesome/css/fontawesome.css" />
    <link rel="stylesheet" href="fontawesome/css/brand.css" />
    <link rel="stylesheet" href="fontawesome/css/solid.css" /-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</head>

<header>
    
    <!-- Navbar -->
    <nav class="navbar navbar-default" style="display: none;">
   
    <div class="container-fluid">
        
        <div class="container">
            
            <!-- Collapse navigation menu for mobiles -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>   <!-- /Collapse menu -->
            
            
            <!-- Logo -->
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php" >
                    <!-- <img src="images/plogo.png" alt="Poise Prelaunch" width="204" height="64"> -->
                </a>    
            </div>  <!-- /Logo -->

            <!-- Navigation buttons -->
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                <?php if(!empty(@$_SESSION['user_id'])): ?>

                    <?php
                        require ("config/dbconnect.php");
                           $stmt = $conn->prepare("SELECT `fillcheck` FROM `users` WHERE `username`= '".@$_SESSION['user_id']."'");
                           $stmt->execute();
                           $result = $stmt->get_result();
                           $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                        
                        if ($row['fillcheck'] === 0) {
                           echo '<li><a href="profile.php"><span class="glyphicon glyphicon-bitcoin"></span> Profile</a></li>';
                        } else {
                           echo '<li><a href="profile1.php"><span class="glyphicon glyphicon-bitcoin"></span> Profile</a></li>';
                        } ?>

                    <li><a href="purchase.php"><span class="glyphicon glyphicon-bitcoin"></span> Donate</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Sign out</a></li>
                <?php else: ?>
                    <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <?php endif; ?>
                </ul>
            </div> <!-- /Navigation buttons -->
            
        </div>  <!-- /Container -->
        
    </div>  <!-- /Container-fluid -->
    
    </nav>  <!-- /Navbar -->
    
</header>
