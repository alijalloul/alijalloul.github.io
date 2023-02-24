<?php
    session_start();

    if(!isset($_SESSION['sessionID'])){
        echo'<!doctype html>
            <html>  
                <header>
                    <link rel="stylesheet" href="css/nav.css">
                    <link rel="stylesheet" href="css/loginform.css">
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
        
                    <div id="right-nav">';
                        echo'
                        <div class="loginSignin">
                            <a href="login.php" class="loginout-btn"  name="login_submit">Log In</a>
                            <a href="signup.php" id="signup-btn">Sign Up</a>
                        </div>'; 
                echo '</div>     
                </nav>

                    <section>
                        <form id="loginform" action="includes/login.inc.php" method="POST">
                            <h1 style="opacity:0.8;">Log In</h1>    

                            <input type="text" placeholder="E-mail or Username" name="mailuid">
                            <input type="password" placeholder="Password" name="login-pwd">

                            <div id="button-wrapper">
                                <input type="button" value="CANCEL" id="logincancelbtn">
                                <input type="submit" value="Log In" name="login_submit">
                            </div>
                        </form>
                    </section>
                    <script src="js/loginCancel.js"></script>
                </body>
            </html>';
    }else{
        header("Location: index.php?error=LoggedIn");
        exit();
    }
