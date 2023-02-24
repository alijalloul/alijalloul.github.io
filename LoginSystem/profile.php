<?php
    session_start();

    if(isset($_SESSION['sessionID'])){
        include_once 'includes/dbh.inc.php';

        echo'<!DOCTYPE html>
            <html>
                <header>
                    <link rel="stylesheet" href="css/nav.css">
                    <link rel="stylesheet" href="css/profile.css">
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
                    <section id="main-section">
                        <div id="right-sec">'; 
                            $sql = "SELECT * FROM accounts Where ID='".$_SESSION['sessionID']."';";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);

                            if($row['ProfileImgStatus'] == false){
                                echo '<img src="images/profiles/profileDefaulta.jpeg" alt="profielPic">';
                            }else{
                                $fileName = "images/profiles/profile".$_SESSION['sessionID'].".*";
                                $fileName = "images/profiles/profile".$_SESSION['sessionID'].".".end(explode(".", glob($fileName)[0]));
                                echo '
                                    <div id="profileImageContainer">
                                        <form action="includes/removeImage.inc.php" method="POST">
                                            <label for="removeSubmit" id="delete-btn">
                                                <input id="removeSubmit" type="submit" name="deleteProfilePicBtn" style="display:none;">
                                            </label>
                                        </form>
                                        <img src="'.$fileName.'" id="profileImage">
                                    </div>';
                            }
                                $profileID = $_SESSION['sessionID'];
                                $sql = "SELECT Username FROM accounts WHERE ID='".$profileID."';";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_array($result);
                                echo '<h1>'.$row['Username'].'</h1>';
                        echo'
                            <form action="includes/uploadImage.inc.php" method="POST" enctype="multipart/form-data">
                                <label for="file-upload" id="uploadProfilePic">
                                    Edit Profile Picture
                                </label>
                                <input type="file" name="profilePic" id="file-upload" onchange="this.form.submit();" style="display:none;">
                            </form>
                        </div>
                    </section>
                </body>
            </html>';
    }else{
        header("Location: login.php?error=notLoggedIn");
        exit();
    }