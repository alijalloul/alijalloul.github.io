<?php
    if(isset($_POST['contact_submit'])){
        include_once 'dbh.inc.php';
        
        $name = $_POST['fullname'];
        $mailFrom = $_POST['mailfrom'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        if(empty($name) || empty($mailFrom) || empty($message)){
            header("Location: ../contact.php?error=emptyfields");
            exit();
        }else{
            $title = $_POST['title'];
            $content = $_POST['content'];
            $date = date("d ").DateTime::createFromFormat('!m', date("m"))->format('F').date(" Y");

            $sql = "INSERT INTO inbox (Name, mailFrom, Subject, Message, Upload) VALUES (?, ?, ?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../contact.php?error=sqlerror");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "sssss", $name, $mailFrom, $subject, $message, $date);
                mysqli_stmt_execute($stmt);

                header("Location: ../index.php?message=sent!");
                exit();
            }
        }
    }else{
        header("Location: ../contact.php");
        exit();
    }