<?php
    include "dbh.inc.php";
    
    $sql = "SELECT * FROM posts;";
    $result = mysqli_query($conn, $sql);

    $data = array();
    $data2 = array();

    while($row = mysqli_fetch_assoc($result))
    {
        $sql2 =  "SELECT * FROM accounts WHERE Username='".$row['Username']."';";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);

        $data[] = $row;
        $data2[] = $row2;
    }

    $i = 0;
    while($i < mysqli_num_rows($result)){
        echo '
            <div class="post-container">
                <div style="position:absolute;opacity:0.6;left:-25px;border-right:2px solid black; height: 150px;width:10px;"></div>
                    <h1 class="postTitle">'.$data[mysqli_num_rows($result) - 1 - $i]['Title'].'</h1>
                    <div class="content-container">
                        <h4 class="postContent">'.$data[mysqli_num_rows($result) - 1 - $i]['Content'].'</h4>';
                        if($data2[mysqli_num_rows($result) - 1 - $i]['ProfileImgStatus'] == 0){
                            echo'<div class="postProfile" style="background-image: url(\'images/profiles/profileDefaulta.jpeg\');"></div>';
                        }
                        else
                        {
                            $fileUserName = "../images/profiles/profile".$data2[mysqli_num_rows($result) - 1 - $i]['ID'].".*";
                            $fileUserName = "images/profiles/profile".$data2[mysqli_num_rows($result) - 1 - $i]['ID'].".".end(explode(".", glob($fileUserName)[0]));
                            

                            echo'<div class="postProfile" style="background-image: url('.$fileUserName.');"></div>';

                        }
                        echo'
                    </div>
                    <div class="otherinfo-container">
                        <h5 class="postdata">'.$data[mysqli_num_rows($result) - 1 - $i]['Upload'].'</h5>
                        <h5 class="postUsername">'.$data[mysqli_num_rows($result) - 1 - $i]['Username'].'</h5>
                    </div>
            </div>';    

            $i++;
    }