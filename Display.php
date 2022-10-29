<?php 
//connected database
    include('connected/connected.php');
    include"connected/mec.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Display images</title>
    <link rel="icon" href="img/h.jpg" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="js/bootstrap.min.js">
    <link rel="stylesheet" href="css/Display.css">
  
</head>
<!-- comment -->

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 p-0">
                <aside class="main_menu p-3 pt-5">
                    <h4>My Files</h4>
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list"
                            href="Home.php" role="tab" aria-controls="home">Home</a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
                            href="Uplode.php" role="tab" aria-controls="Upload
                            Page">Upload
                            images</a>
                        <a class="list-group-item list-group-item-danger" id="list-messages-list" data-toggle="list"
                            href="Display.php" role="tab" aria-controls="Display
                            Image Page">Display
                            images</a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list"
                            href="keys.php" role="tab" aria-controls="Display Keys Page">Display Keys</a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list"
                            href="current.php" role="tab" aria-controls="Current
                            Statistices Page">Current
                            Statistices</a>
                    </div>

                </aside>
            </div>
           <div class="col-9 p-0" action="" method="post">
                <main class="main_content pt-5 ps-5 pe-5">
                    <form action="Display.php" method="GET">
                    <div class="input-group mb-3">
                            <input type="text" name="key" class="form-control" placeholder="Enters image key">
                            <button class="btn btn-danger" name="search" type="submit">Get Image</button>
                        </div>
                    </form>
                    <div class="image_container d-flex justify-content-center align-items-center">
                        <?php
                            try {
                                if(isset($_GET['search'])){ 
                                    $key = $_GET['key'];
                                    if (filter_var($key, FILTER_VALIDATE_INT) === 0 || !filter_var($key, FILTER_VALIDATE_INT) === false) {
                                       if($memcacheD->get( $key)){
                                          $val=$memcacheD->get( $key);
                                          echo '<img src="images/'.$val. '" class="img-thumbnail">';
                                          echo "<script>alert('image get in memcached');</script>";  
                                          $getvalue="SELECT numreq from  memcached ";
                                          $datquery=mysqli_query($conn, $getvalue);
                                          $output=mysqli_fetch_assoc($datquery);
                                          $value= $output['numreq'];
                                          $newvalue=1+$value;
                                          $addvaluequery="update memcached set numreq= $newvalue";
                                          $addit=mysqli_query($conn,$addvaluequery);
                                          //hitsrate
                                          $getvalu="SELECT hitrate from  memcached ";
                                          $datquer=mysqli_query($conn, $getvalu);
                                          $outpu=mysqli_fetch_assoc($datquer);
                                          $valu= $outpu['hitrate'];
                                          $newvalu=1+$valu;
                                          $addvaluequer="update memcached set hitrate= $newvalu";
                                          $addit=mysqli_query($conn,$addvaluequer);
                                        
                                        }
                                      else{
                                        $sql="select imgname from uplode where idimg = " . $key;
                                        $result= $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                            echo '<img src="images/'.$row["imgname"]. '" class="img-thumbnail">';
                                          //miss
                                          $getvalu="SELECT missrate from  memcached ";
                                          $datquer=mysqli_query($conn, $getvalu);
                                          $outpu=mysqli_fetch_assoc($datquer);
                                          $valu= $outpu['missrate'];
                                          $newvalu=1+$valu;
                                          $addvaluequer="update memcached set missrate= $newvalu";
                                          $addit=mysqli_query($conn,$addvaluequer);
                                        
                                       
                                            }
                                        } else {
                                            echo "<div class='alert alert-warning'>No Data Found</div>";
                                        }
                          echo "<script>alert('image get in DataBase');</script>";  

                                        $conn->close();

                                    }
                                }
                                    
                                    else {
                                        echo "<div class='alert alert-danger'>Please Enter Valid Key</div>";
                                    }
                                    
                                }else {
                                    echo "<img class='placeholderImage' src='assets/images/placeholder-image.png'  ";
                                } 
                            }
                            
                            catch(Exception $e) {
                                echo 'Message: ' .$e->getMessage();
                            }
                           

                        ?>
                    </div>

                </main>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.min.js"></script>
</body>



</html>
