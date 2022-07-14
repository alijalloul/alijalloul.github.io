<?php
    if(isset($_POST['contact_submit'])){
        $name = $_POST['fullname'];
        $mailFrom = $_POST['mailfrom'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        if(empty($name) || empty($mailFrom) || empty($message)){
            header("Location: ../contact.php?error=emptyfields");
            exit();
        }else{
            $mailTo = "ali.z.jalloul@gmail.com";
            $headers = "From: ".$mailFrom;
            $txt = "You have recieved an e-mail from ".$name.".\n\n".$message;
    
            mail($mailTo, $subject, $headers, $txt);
            header("Location: ../index.php?contact=success");
            exit();
        }
    }

    header("Location: ../contact.php");
    exit();