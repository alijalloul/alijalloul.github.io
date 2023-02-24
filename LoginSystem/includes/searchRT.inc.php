<?php
    if(isset($_POST['search_submit'])){
        include_once 'dbh.inc.php';

        $search = "%".$_POST['search']."%";

        $sql = "SELECT * FROM posts WHERE Title LIKE ? OR Content LIKE ? OR Upload LIKE ? OR Username LIKE ?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../index.php?error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "ssss", $search, $search, $search, $search);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)){
                echo '
                    <div class="post-container">
                    <div style="position:absolute;opacity:0.6;left:-25px;border-right:2px solid black; height: 150px;width:10px;"></div>
                        <h1 class="postTitle">'.$row['Title'].'</h1>
                        <h4 class="postContent">'.$row['Content'].'</h4>
                        <div class="otherinfo-container">
                            <h5 class="postDate">'.$row['Upload'].'</h5>
                            <h5 class="postUsername">'.$row['Username'].'</h5>
                        </div>
                    </div>';
            }
        }
    }
    