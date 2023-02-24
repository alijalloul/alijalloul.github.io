<?php   
    session_start();
    include_once 'dbh.inc.php';

    if(isset($_POST['post_submit'])){
        $title = $_POST['title'];
        $content = $_POST['content'];
        //$date = date("d ").DateTime::createFromFormat('!m', date("m"))->format('F').date(" Y");
        date_default_timezone_set('Asia/Beirut');
        $date = date('m/d/Y, h:i A');
        $username = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Username From accounts WHERE ID='".$_SESSION['sessionID']."';"))['Username'];
        
        $sql = "INSERT INTO posts (Title, Content, Upload, Username) VALUE (?, ?, '$date', '$username');";
        $stmt = mysqli_stmt_init($conn);

        if(mysqli_stmt_prepare($stmt, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $title, $content);
            mysqli_stmt_execute($stmt);

            header("Location: ../index.php?post=success");
            exit();
        }else{
            header("Location: ../createPost.php?error=stmtPrepareFailed");
            exit();
        }
    }else{
        header("Location: ../createPost.php?error=noSubmit");
        exit();
    }