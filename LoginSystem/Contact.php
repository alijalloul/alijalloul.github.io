<?php
    session_start();
    include_once 'includes/dbh.inc.php';
    
    if(isset($_SESSION['sessionID'])){
        include_once 'includes/dbh.inc.php';

        echo'<!doctype html>
        <html>
            <header>
                <link rel="stylesheet" href="css/nav.css">
                <link rel="stylesheet" href="css/section.css">
                <link rel="stylesheet" href="css/contact.css">
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
                <section>
                    <form id="contactForm" action="includes/contact.inc.php" method="POST">
                        <h1>Contact Us</h1>
                        <input type="text" placeholder="Full Name" name="fullname">
                        <input type="text" placeholder="E-mail" name="mailfrom">
                        <input type="text" placeholder="Subject" name="subject">
                        <textarea placeholder="Type your message here!" name="message" id="" rows="10" style="resize: vertical;"></textarea>

                        <div id="button-wrapper">
                            <input type="button" value="CANCEL" id="createPostCancelBtn">
                            <input type="submit" value="SEND" name="contact_submit">
                        </div>
                    </form>
                </section>
            </body>
        </html>';
    }else{
        header("Location: login.php?error=notLoggedIn");
        exit();
    }