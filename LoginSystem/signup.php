<?php
    session_start();

    if(!isset($_SESSION['sessionID'])){
        echo'<!doctype html>
            <html>
                <header>
                    <link rel="stylesheet" href="css/nav.css">
                    <link rel="stylesheet" href="css/signupform.css">
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
                        echo '
                        <div class="loginSignin">
                            <a href="login.php" class="loginout-btn" name="login_submit">Log In</a>
                            <a href="signup.php" id="signup-btn">Sign Up</a>
                        </div>';
                echo '</div>     
                </nav>

                    <section>
                        <form id="signupform" action="includes/signup.inc.php" method="POST">
                            <h1 style="opacity:0.8;">Sign Up</h1>    
                            
                            <div id="FL">';
                                    if(isset($_GET['firstname'])){
                                        echo '<input type="text" placeholder="Firstname" name="firstname" value="'.$_GET['firstname'].'">';
                                    }else{
                                        echo '<input type="text" placeholder="Firstname" name="firstname">';
                                    }
                                    if(isset($_GET['lastname'])){
                                        echo '<input type="text" placeholder="Lastname" name="lastname" value="'.$_GET['lastname'].'">';
                                    }else{
                                        echo '<input type="text" placeholder="Lastname" name="lastname">';
                                    }
                        echo'</div>';
                                if(isset($_GET['mail'])){
                                    echo '<input type="text" placeholder="E-mail" name="mail" value="'.$_GET['mail'].'">';
                                }else{
                                    echo '<input type="text" placeholder="E-mail" name="mail">';
                                }
                                if(isset($_GET['username'])){
                                    echo '<input type="text" placeholder="Username" name="username" value="'.$_GET['username'].'">';
                                }else{
                                    echo '<input type="text" placeholder="Username" name="username">';
                                }

                        echo'<input type="password" placeholder="Password" name="pwd">
                            <input type="password" placeholder="Repeat Password" name="pwd-repeat">
                            <div id="button-wrapper">
                                <input type="button" value="CANCEL" id="signupcancelbtn">
                                <input type="submit" value="Sign In" name="signup_submit">
                            </div>';
                                $fullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                                if(strpos($fullURL, "error=emptyfields") == true){
                                    echo '
                                        <script>
                                            function appendIt (a){
                                                let errormsg = document.createElement("h5");
                                                errormsg.innerHTML = "You need to fill this field!";
                                                errormsg.style = "padding:5px 0;margin: 0;font-size: 10px;opacity: 1;color: red;";
                                                a.appendChild(errormsg);                                    
                                            };

                                            let firstname = document.getElementsByName("firstname")[0];
                                            let lastname = document.getElementsByName("lastname")[0];
                                            let mail = document.getElementsByName("mail")[0];
                                            let username = document.getElementsByName("username")[0];
                                            let pwd = document.getElementsByName("pwd")[0];
                                            let pwd_repeat = document.getElementsByName("pwd-repeat")[0];

                                            let FL = document.getElementById("FL");
                                            let signupform = document.getElementById("signupform");
                                            let btnwrapper = document.getElementById("button-wrapper");

                                            if(firstname.value == ""){
                                                let errorContainer1 = document.createElement("div");

                                                firstname.style = "margin-bottom:0;outline:none;border:1px solid red;box-shadow: 0 0 5px red;width: 90%;"

                                                FL.append(errorContainer1);

                                                errorContainer1.append(firstname);
                                                appendIt(errorContainer1);
                                            }
                                            if(lastname.value == ""){
                                                let errorContainer2 = document.createElement("div");

                                                lastname.style = "margin-bottom:0;outline:none;border:1px solid red;box-shadow: 0 0 5px red;width: 100%;"

                                                FL.append(errorContainer2);

                                                errorContainer2.append(lastname);
                                                appendIt(errorContainer2);
                                            }
                                            if(mail.value == ""){               
                                                let errorContainer3 = document.createElement("div");

                                                mail.style = "margin-bottom:0;outline:none;border:1px solid red;box-shadow: 0 0 5px red;width: 100%;"

                                                signupform.insertBefore(errorContainer3, btnwrapper);

                                                errorContainer3.append(mail);
                                                appendIt(errorContainer3);
                                            }
                                            if(username.value == ""){
                                                let errorContainer4 = document.createElement("div");

                                                username.style = "margin-bottom:0;outline:none;border:1px solid red;box-shadow: 0 0 5px red;width: 100%;"

                                                signupform.insertBefore(errorContainer4, btnwrapper);

                                                errorContainer4.append(username);
                                                appendIt(errorContainer4);
                                            }
                                            
                                            if(pwd.value == ""){
                                                let errorContainer5 = document.createElement("div");

                                                pwd.style = "margin-bottom:0;outline:none;border:1px solid red;box-shadow: 0 0 5px red;width: 100%;"

                                                signupform.insertBefore(errorContainer5, btnwrapper);

                                                errorContainer5.append(pwd);
                                                appendIt(errorContainer5);
                                            }
                                            if(pwd_repeat.value == ""){
                                                let errorContainer6 = document.createElement("div");

                                                pwd_repeat.style = "margin-bottom:0;outline:none;border:1px solid red;box-shadow: 0 0 5px red;width: 100%;"

                                                signupform.insertBefore(errorContainer6, btnwrapper);

                                                errorContainer6.append(pwd_repeat);
                                                appendIt(errorContainer6);
                                            }
                                        </script>';
                                }
                    echo'</form> 
                        <!--<div id="designcircle"></div>-->
                    </section>
                            
                    <script src="js/signupCancel.js"></script>
                </body>
            </html>';
    }else{
        header("Location: index.php?error=LoggedIn");
        exit();
    }