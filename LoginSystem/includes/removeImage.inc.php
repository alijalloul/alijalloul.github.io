<?php
    session_start();
    include_once 'dbh.inc.php';

    if($_SESSION['sessionID'])
    {
        $fileName = "../images/profiles/profile".$_SESSION['sessionID'].".*";

        $fileName = "../images/profiles/profile".$_SESSION['sessionID'].".".explode(".", glob($fileName)[0])[3];
        if(!unlink($fileName))
        {
            header("Location: ../profile.php?error=imageRemoveFailded");
            exit();
        }else {
            $sql = "SELECT * FROM accounts Where ID='".$_SESSION['sessionID']."';";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
    
            $sql = "UPDATE accounts SET ProfileImgStatus=0 WHERE ID='".$_SESSION['sessionID']."';";
            mysqli_query($conn, $sql);
    
            header("Location: ../profile.php");
            exit();
        }
    }else{
        header("Location: ../index.php?error=notLoggedIn");
        exit();
    }