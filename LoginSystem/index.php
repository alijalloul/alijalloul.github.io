<?php
    session_start();
    include_once 'includes/dbh.inc.php';    
?>

<!doctype html>
<html>
    <header>
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/section.css">

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </header>
    <body>
        <nav id="main-nav">
            <div id="left-nav">
              <a id="logo" href="index.php"></a>
              <a href="index.php">Home</a>
              <a href="index.php">Settings</a>
              <a href="profile.php">Profile</a>
              <a href="Contact.php">Contact</a>
            </div>
            
            <div id="middle-nav">
                <form action="" method="POST">
                    <input type="text" id="searchBox" placeholder="Search" name="search">
                    <button type="submit" value="" name="search_submit" id="search_submitV">
                </form>
            </div>

            <div id="right-nav">
                <?php
                    if(isset($_SESSION['sessionID'])){
                        echo'<form action="includes/logout.inc.php">
                                <input class="loginout-btn" type="submit" value="Log Out" name="logout_submit">
                            </form>';
                            
                            $sql = "SELECT * FROM accounts Where ID='".$_SESSION['sessionID']."';";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);

                            if($row['ProfileImgStatus'] == 0){
                                echo '<a href="profile.php" id="profile-pic" style="background-size:cover;background-position: center center;background-image: url(\'images/profiles/profileDefaulta.jpeg\');"></a>';
                            }else{
                                $fileName = "images/profiles/profile".$_SESSION['sessionID'].".*";
                                $fileName = "images/profiles/profile".$_SESSION['sessionID'].".".end(explode(".", glob($fileName)[0]));

                                echo '<a href="profile.php" id="profile-pic" style="background-size:cover;background-position: center center;background-image: url('.$fileName .');"></a>';
                            }        
                    }
                    else{
                        echo '
                        <div class="loginSignin">
                            <a class="loginout-btn" href="login.php"  name="login_submit">Log In</a>
                            <a href="signup.php" id="signup-btn">Sign Up</a>
                        </div>';
                    }
                ?>
            </div>     
        </nav>
        <section>
            <?php
                if(isset($_POST['search_submit'])){
                    
                    $search = "%".$_POST['search']."%";
            
                    if($search != "")
                    {
                        $sql = "SELECT * FROM posts WHERE Title LIKE ? OR Content LIKE ? OR Upload LIKE ? OR Username LIKE ?;";
                        $stmt = mysqli_stmt_init($conn);
                
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            header("Location: ../index.php?error=sqlerror");
                            exit();
                        }else{
                            mysqli_stmt_bind_param($stmt, "ssss", $search, $search, $search, $search);
                            mysqli_stmt_execute($stmt);
                
                            $result = mysqli_stmt_get_result($stmt);
                        }
                    }else{
                        $sql = "SELECT * FROM posts;";
                        $result = mysqli_query($conn, $sql);
                    }

                    while($row = mysqli_fetch_assoc($result)){
                        echo '
                            <div class="post-container">
                            <div style="position:absolute;opacity:0.6;left:-25px;border-right:2px solid black; height: 80px;width:10px;"></div>
                                <h1 class="postTitle">'.$row['Title'].'</h1>
                                <h4 class="postContent">'.$row['Content'].'</h4>
                                <div class="otherinfo-container">
                                    <h5 class="postDate">'.$row['Upload'].'</h5>
                                    <h5 class="postUsername">'.$row['Username'].'</h5>
                                </div>
                            </div>';
                    }
                }else{
                    
        
                        echo '
                                <div id="link_wrapper">
                                </div>
                            ';    
                }
            ?>
            <a href="createPost.php" id="create-btn"></a>
        </section>
    </body>
</html>

<script>
function loadXMLDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("link_wrapper").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "includes/server.inc.php", true);
  xhttp.send();
}
setInterval(() => {
    loadXMLDoc();
}, 1000);

window.onload = loadXMLDoc;
</script>