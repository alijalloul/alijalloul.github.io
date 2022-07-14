<?php  
    session_start();

    if($_SESSION['sessionID'])
    {
        if($_FILES['profilePic']['size'] != 0 && $_FILES['profilePic']['error'] == 0){
            
            include_once 'dbh.inc.php';

            $file = $_FILES['profilePic'];

            $fileName = $file['name'];
            $fileType = $file['type'];
            $fileTempName = $file['tmp_name'];
            $fileError = $file['error'];
            $fileSize = $file['size'];

            $fileExt = strtolower(explode('.',$fileName)[1]);

            $allowedExt = array('jpg', 'jpeg', 'png');

            if(in_array($fileExt, $allowedExt)){        
                if($fileError == 0){
                    if($fileSize < 1000000){
                        $fileNewName = "profile".$_SESSION['sessionID'].".".$fileExt;
                        $fileDestination = "../images/profiles/".$fileNewName;
                        move_uploaded_file($fileTempName, $fileDestination);

                        $sql = "UPDATE accounts SET ProfileImgStatus=1 WHERE ID='".$_SESSION['sessionID']."';";
                        mysqli_query($conn, $sql);
                    
                        header("Location: ../profile.php?upload=success");
                        exit();
                    }else{
                        header("Location: ../profile.php?error=largesize");
                        exit();
                    }
                }else{
                    header("Location: ../profile.php?error=uploadError");
                    exit();
                }
            }else{
                header("Location: ../profile.php?error=wrongExtension");
                exit();
            }
        }else{
            echo $_FILES['profilePic']['size']."<br>";
            echo $_FILES['profilePic']['error'];
            //header("Location: ../profile.php?error=nullImage");
            exit(); 
        }
    }
    else{
        header("Location: ../index.php?error=notLoggedIn");
        exit();
    }