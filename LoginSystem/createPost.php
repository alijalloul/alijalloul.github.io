<?php
    session_start();
    include_once 'includes/dbh.inc.php';

    if(isset($_SESSION['sessionID'])){
        include_once 'includes/dbh.inc.php';

        echo'<!doctype html>
                <html>
                    <header>
                        <link rel="stylesheet" href="css/nav.css">
                        <link rel="stylesheet" href="css/createPost.css">
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
            
                        <div id="right-nav">';
                        echo'<form action="includes/logout.inc.php">
                                <input class="loginout-btn" type="submit" value="Log Out" name="logout_submit">
                            </form>';
                            
                            $sql = "SELECT * FROM accounts Where ID='".$_SESSION['sessionID']."';";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);

                            if($row['ProfileImgStatus'] == false){
                                echo '<a href="profile.php" id="profile-pic" style="background-size:cover;background-position: center center;background-image: url(\'images/profiles/profileDefaulta.jpeg\');"></a>';
                            }else{
                                $fileName = "images/profiles/profile".$_SESSION['sessionID'].".*";
                                $fileName = "images/profiles/profile".$_SESSION['sessionID'].".".end(explode(".", glob($fileName)[0]));

                                echo '<a href="profile.php" id="profile-pic" style="background-size:cover;background-position: center center;background-image: url('.$fileName .');"></a>';
                            }    
                    echo '</div>     
                    </nav>

                        <section>
                            <form id="createPostForm" action="includes/createPost.inc.php" method="POST">
                                <input type="text" name="title" placeholder="Title">
                                <textarea name="content" rows="10" style="resize: vertical;" placeholder="Content"></textarea>  
                                
                                
                                <div id="button-wrapper">
                                    <input type="button" value="CANCEL" id="createPostCancelBtn">
                                    <input type="submit" value="POST" name="post_submit">
                                </div>
                            </form>
                        </section>
                    <body>
                </html>';
    }else{
        header("Location: login.php?error=notLoggedIn");
        exit();
    }