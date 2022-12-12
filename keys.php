<?php 
//connected database
include('connected/connected.php');
//fetch  information in database
$sql='SELECT * FROM uplode';
$data=mysqli_query($conn,$sql);
$images=mysqli_fetch_all($data,MYSQLI_ASSOC);
mysqli_free_result($data);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Display Keys</title>
    <link rel="icon" href="img/g.jpg" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/keys.css">
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
                            images">Upload
                            images</a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list"
                            href="Display.php" role="tab" aria-controls="Display
                            Image Page">Display
                            images</a>
                        <a class="list-group-item list-group-item-danger" id="list-settings-list" data-toggle="list"
                            href="keys.php" role="tab" aria-controls="Display Keys Page">Display Keys Page</a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list"
                            href="current.php" role="tab" aria-controls="Current
                            Statistices ">Manager App </a>
                    </div>

                </aside>

            </div>
<div class="col-9 p-0">
    <main class="main_content pt-5 ps-5 pe-5">
        <p id="keys"><b>Display All Keys</b></p>
        <hr>   
        <div class="row">
        <?php foreach($images as $image ):?>
        <div class="col-sm-6">
            <div class="card my-2 bg-danger bg-gradient"> 
            <div class="card-body">  
            <h4 class="card-title">key:<?php echo htmlspecialchars($image['idimg']).'<br>';?></h4>
            <h5 class="card-title">nameimges :<?php echo htmlspecialchars($image['imgname']);?></h5>
        </div>
            </div>
            </div>
 <?php endforeach;?>
 </div>
 </main>
 </div> 
</div>
 </div>
</body>
</html>
       