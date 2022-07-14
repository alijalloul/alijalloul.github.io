<?php   
    if(isset($_POST['login_submit'])){
        include_once 'dbh.inc.php';

        $mailuid = $_POST['mailuid'];
        $pass = $_POST['login-pwd'];

        if(empty($mailuid) || empty($pass)){
            header("Location: ../index.php?error=emptyfields");
            exit();
        }else{
            $sql = "SELECT * FROM accounts WHERE Username=? OR Email=?;";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../index.php?error=sqlerror");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if($row = mysqli_fetch_assoc($result)){
                    $pwdCheck = password_verify($pass, $row['Password']);

                    if($pwdCheck == false){
                        header("Location: ../index.php?error=wrongpassword");
                        exit();
                    }else if($pwdCheck == true){
                        session_start();

                        $_SESSION['sessionID'] = $row['ID'];
                        $_SESSION['sessionUsername'] = $row['Username'];

                        echo password_hash('a', PASSWORD_DEFAULT);
                        header("Location: ../index.php?login=success");
                        exit();
                    }else{
                        header("Location: ../index.php?error=wrongpassword");
                        exit();
                    }
                }else{
                    header("Location: ../index.php?error=userdoesnotexist");
                    exit();
                }
            }
        }
    }else{
        header("Location: ../index.php");
        exit();
    }