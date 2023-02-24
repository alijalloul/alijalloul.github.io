<?php
    session_start();
    include_once 'includes/dbh.inc.php';
    
    if(isset($_SESSION['sessionID'])){
        if($_SESSION["sessionUsername"] == "Admin")
        {
            echo'<!doctype html>
            <html>
                <header>
                    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">

                    <link rel="stylesheet" href="css/nav.css">
                    <link rel="stylesheet" href="css/inbox.css">
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
                            echo '
                        </div>     
                    </nav>
                    <section>';
                        $sql = "SELECT * FROM inbox;";
                        $result = mysqli_query($conn, $sql);

                        while($row = mysqli_fetch_assoc($result)){
                            echo '
                                <div class="message-container">
                                        <h1 class="message_title">'.$row['Subject'].'</h1>

                                        <h5 class="message_upload">'.$row['Upload'].'</h5>

                                        <h4 class="message_content">'.$row['Message'].'</h4>
                                        <div class="other">
                                            <h5 class="message_name">'.$row['Name'].'</h5>
                                            <h5 class="message_from">'.$row['mailFrom'].'</h5>
                                        </div>
                                </div> ';
                        }echo'  
                    </section>
                </body>
            </html>';
        }else{
            header("Location: index.php?error=notAdmin");
            exit(); 
        }
    }else{
        header("Location: index.php?error=notAdmin");
        exit();
    }