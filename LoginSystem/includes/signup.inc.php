<?php
    if(isset($_POST['signup_submit'])){
        include_once 'dbh.inc.php';

        $first = $_POST['firstname'];
        $last = $_POST['lastname'];
        $mail = $_POST['mail'];
        $username = $_POST['username'];
        $pass = $_POST['pwd'];
        $passRepeat = $_POST['pwd-repeat'];

        if(empty($first) || empty($last) || empty($mail) || empty($username) || empty($pass) || empty($passRepeat)){
            header("LOCATION: ../signup.php?error=emptyfields&firstname=".$first."&lastname=".$last."&mail=".$mail."&username=".$username);
            exit();
        }else if(!filter_var($mail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("LOCATION: ../signup.php?error=invalidmailuid&firstname=".$first."&lastname=".$last."&mail=".$mail."&username=".$username);
            exit();
        }else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            header("LOCATION: ../signup.php?error=invalidmail&firstname=".$first."&lastname=".$last."&mail=".$mail."&username=".$username);
            exit();
        }else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("LOCATION: ../signup.php?error=invaliduid&firstname=".$first."&lastname=".$last."&mail=".$mail."&username=".$username);
            exit();
        }else if($pass !== $passRepeat){
            header("LOCATION: ../signup.php?error=differentpasswords&firstname=".$first."&lastname=".$last."&mail=".$mail."&username=".$username);
            exit();
        }else{
            $sql = "SELECT Username FROM accounts WHERE Username=?;";
            $stmt = mysqli_stmt_init($conn);

            $sql2 = "SELECT Email FROM accounts WHERE Email=?;";
            $stmt2 = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql) || !mysqli_stmt_prepare($stmt2, $sql2)){
                header("Location: ../signup.php?error=sqlerror");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                $resultCheck = mysqli_stmt_num_rows($stmt);

                mysqli_stmt_bind_param($stmt2, "s", $mail);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_store_result($stmt2);

                $resultCheck2 = mysqli_stmt_num_rows($stmt2);
                if($resultCheck > 0){
                    header("Location: ../signup.php?error=usertaken&firstname=".$first."&lastname=".$last."&username=".$username);
                    exit();
                }else if($resultCheck2 > 0){
                    header("Location: ../signup.php?error=emailtaken&firstname=".$first."&lastname=".$last."&username=".$username);
                    exit();
                }
                else{
                    $sql = "INSERT INTO accounts (Firstname, Lastname, Email, Username, Password) VALUES (?, ?, ?, ?, ?);";
                    $stmt = mysqli_stmt_init($conn);

                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: ../signup.php?error=sqlerror");
                        exit();
                    }else{
                        $hashedPwd = password_hash($pass, PASSWORD_DEFAULT);

                        mysqli_stmt_bind_param($stmt, "sssss", $first, $last, $mail, $username, $hashedPwd);
                        mysqli_stmt_execute($stmt);

                        header("Location: ../index.php?signup=success");
                        exit();
                        }
                    }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }else{
        header("Location: ../index.php?error=notLoggedIn");
        exit();
    }
     