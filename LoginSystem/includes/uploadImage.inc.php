<?php  
    session_start();

    function createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir){
        $path = $uploadDir . '/' . $image_name;

        $mime = getimagesize($path);

        if($mime['mime']=='image/png') { 
            $src_img = imagecreatefrompng($path);
        }
        if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
            $src_img = imagecreatefromjpeg($path);
        }   

        $old_x          =   imageSX($src_img);
        $old_y          =   imageSY($src_img);

        if($old_x > $old_y) 
        {
            $thumb_w    =   $new_width;
            $thumb_h    =   $old_y*($new_width/$old_x);
        }

        else if($old_x < $old_y) 
        {
            $thumb_w    =   $old_x*($new_height/$old_y);
            $thumb_h    =   $new_height;
        }

        else if($old_x == $old_y) 
        {
            $thumb_w    =   $new_width;
            $thumb_h    =   $new_height;
        }

        $dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);

        imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 


        //New save location
        $new_thumb_loc = $moveToDir;

        if($mime['mime']=='image/png') {
            $result = imagepng($dst_img,$new_thumb_loc,100);
        }
        else if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
            $result = imagejpeg($dst_img,$new_thumb_loc,100);
        }
        echo "imageName: ".$image_name."<br>upload: ".$uploadDir."<br>moveTo: ".$moveToDir."<br>dst: ".$dst_img."<br>src: ".$src_img."<br>";

        imagedestroy($dst_img);
        imagedestroy($src_img);

        return $result;
    }

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

            $allowedExt = array('jpeg', 'jpeg', 'png');

            /*if(in_array($fileExt, $allowedExt)){        
                
            }else{
                header("Location: ../profile.php?error=wrongExtension");
                exit();
            }*/
            if($fileError == 0){
                if($fileSize < 10000000){
                    $fileNewName = "profile".$_SESSION['sessionID'].".".$fileExt;
                    $fileDestination = $fileNewName;
                    
                    createThumbnail($fileNewName, 300, 300, $fileTempName, "test.jpeg");
                    print_r($newIMG);
                    echo '<br><img src="' . $fileDestination . '"/>';
                    
                    

                    move_uploaded_file($fileTempName, $fileDestination);

                    $sql = "UPDATE accounts SET ProfileImgStatus=1 WHERE ID='".$_SESSION['sessionID']."';";
                    mysqli_query($conn, $sql);
                
                    /*header("Location: ../profile.php?upload=success");
                    exit();*/
                }else{
                    header("Location: ../profile.php?error=largesize");
                    exit();
                }
            }else{
                header("Location: ../profile.php?error=uploadError");
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

    