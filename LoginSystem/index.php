<?php
    session_start();
    include_once 'includes/dbh.inc.php'
?>

<!doctype html>
<html>
    <header>
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/section.css">
    </header>
    <body>
        <nav id="main-nav">
            <div id="left-nav">
              <a id="logo" href="index.php"></a>
              <a href="index.php">Home</a>
              <a href="index.php">Settings</a>
              <a href="profile.php">Profile</a>
              <a href="Contact.php">Contact</a>
            </div>
            
            <div id="middle-nav">
                <form action="" method="POST">
                    <input type="text" id="searchBox" placeholder="Search" name="search">
                    <label for="search_submitH" id="search_submitV">
                        <img src="images/search.png" alt="" id="search_submitV">
                    </label>
                    <input type="submit" name="search_submit" id="search_submitH" style="display:none">
                </form>
            </div>

            <div id="right-nav">
                <?php
                    if(isset($_SESSION['sessionID'])){
                        echo'<form action="includes/logout.inc.php">
                                <input type="submit" value="Log Out" name="logout_submit">  
                            </form>';
                            
                            $sql = "SELECT * FROM accounts Where ID='".$_SESSION['sessionID']."';";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);

                            if($row['ProfileImgStatus'] == false){
                                echo '<a href="profile.php" id="profile-pic" style="background-size:cover;background-position: center center;background-image: url(\'images/profiles/profileDefaulta.jpg\');"></a>';
                            }else{
                                $fileName = "images/profiles/profile".$_SESSION['sessionID'].".*";
                                $fileName = "images/profiles/profile".$_SESSION['sessionID'].".".explode(".", glob($fileName)[0])[1];

                                echo '<a href="profile.php" id="profile-pic" style="background-size:cover;background-position: center center;background-image: url('.$fileName .');"></a>';
                            }        
                    }
                    else{
                        echo'<form action="includes/login.inc.php" method="POST">
                                <div id="EP">
                                    <input type="text" placeholder="E-mail or Username" name="mailuid">
                                    <input type="password" placeholder="Password" name="login-pwd">
                                </div>
                                <input type="submit" value="Log In" name="login_submit">
                                <a href="signup.php" id="signup-btn">Sign Up</a>
                            </form>';  
                    }
                ?>
            </div>     
        </nav>
        <section>
            <?php
                if(isset($_POST['search_submit'])){
                    
                    $search = "%".$_POST['search']."%";
            
                    if($search != "")
                    {
                        $sql = "SELECT * FROM posts WHERE Title LIKE ? OR Content LIKE ? OR Upload LIKE ? OR Username LIKE ?;";
                        $stmt = mysqli_stmt_init($conn);
                
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            header("Location: ../index.php?error=sqlerror");
                            exit();
                        }else{
                            mysqli_stmt_bind_param($stmt, "ssss", $search, $search, $search, $search);
                            mysqli_stmt_execute($stmt);
                
                            $result = mysqli_stmt_get_result($stmt);
                        }
                    }else{
                        $sql = "SELECT * FROM posts;";
                        $result = mysqli_query($conn, $sql);
                    }

                    while($row = mysqli_fetch_assoc($result)){
                        echo '
                            <div class="post-container">
                            <div style="position:absolute;opacity:0.6;left:-25px;border-right:2px solid black; height: 150px;width:10px;"></div>
                                <h1 class="postTitle">'.$row['Title'].'</h1>
                                <h4 class="postContent">'.$row['Content'].'</h4>
                                <div class="otherinfo-container">
                                    <h5 class="postDate">'.$row['Upload'].'</h5>
                                    <h5 class="postUsername">'.$row['Username'].'</h5>
                                </div>
                            </div>';
                    }
                }else{
                    $sql = "SELECT * FROM posts;";
                    $result = mysqli_query($conn, $sql);

                    while($row = mysqli_fetch_assoc($result)){
                        echo '
                            <div class="post-container">
                            <div style="position:absolute;opacity:0.6;left:-25px;border-right:2px solid black; height: 150px;width:10px;"></div>
                                <h1 class="postTitle">'.$row['Title'].'</h1>
                                <h4 class="postContent">'.$row['Content'].'</h4>
                                <div class="otherinfo-container">
                                    <h5 class="postDate">'.$row['Upload'].'</h5>
                                    <h5 class="postUsername">'.$row['Username'].'</h5>
                                </div>
                            </div>';
                    }
                }
            ?>
            <a href="createPost.php" id="create-btn"></a>
        </section>
    </body>
</html>