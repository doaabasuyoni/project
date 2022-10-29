<?php
 include('connected/connected.php');
 include"connected/mec.php";
 $value='';
 $val='';
 $valu='';
 $valut='';
 $vals='';
 for($i=0;$i<1200;$i++){
  //fetch  information in database
  if($i==599){
    //numreq
    $getvalue="SELECT numreq from  memcached ";
    $datquery=mysqli_query($conn, $getvalue);
    $output=mysqli_fetch_assoc($datquery);
    $value= $output['numreq'];
    //totalsize
    $getval="SELECT totalsize from  memcached ";
    $datque=mysqli_query($conn, $getval);
    $outp=mysqli_fetch_assoc($datque);
    $val= $outp['totalsize'];
    //miss rate
    $getvalu="SELECT missrate from  memcached ";
    $datquer=mysqli_query($conn, $getvalu);
    $outpu=mysqli_fetch_assoc($datquer);
    $valu= $outpu['missrate'];
    //hitrate
    $getvalut="SELECT hitrate from  memcached ";
    $datquert=mysqli_query($conn, $getvalut);
    $output=mysqli_fetch_assoc($datquert);
    $valut= $output['hitrate'];
    //numitems
    $getva="SELECT items from  memcached ";
    $datqu=mysqli_query($conn, $getva);
    $outp=mysqli_fetch_assoc($datqu);
    $vals= $outp['items'];
    //capacity
    $get="SELECT capacity from  memcached ";
    $dat=mysqli_query($conn, $get);
    $out=mysqli_fetch_assoc($dat);
    $valk= $out['capacity'];
    $newvalu=200000;
        $addvaluequj="update memcached set capacity= $newvalu";
        $additk=mysqli_query($conn,$addvaluequj);
  }
 }

 if(isset($_POST['clearmemcached'])){
  $sql="SELECT uplode.idimg FROM uplode ";
  $datas=mysqli_query($conn,$sql);
  $images=mysqli_fetch_all($datas,MYSQLI_ASSOC);
  mysqli_free_result($datas);
  $d='';
  foreach($images as $image ):
  $d=$image['idimg'];
  $memcacheD->delete($d);
  endforeach;
  //$memcacheD->clear();
 echo "<script>alert(' memcached clear successfully');</script>";
 }

 if(isset($_POST['clear'])){
   $numitem=0;
   $totalsize=0;
   $numreq=0;
   $miss=0;
   $hit=0;
   $qlo= "UPDATE memcached SET memcached.items=$numitem ,memcached.totalsize=$totalsize,memcached.numreq=$numreq,memcached.missrate=$miss,memcached.hitrate=$hit ";
   $dat=mysqli_query($conn,$qlo);
   echo "<script>alert(' Current Statistices clear successfully');</script>";
 header('Location:current.php');

}







?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Current Statistices</title>
    <link rel="icon" href="img/p.jpg" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="js/bootstrap.min.js">
    <link rel="stylesheet" href="css/current.css">
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
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list"
                            href="Display.php" role="tab" aria-controls="Display
                            Image">Display
                            images</a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list"
                            href="keys.php" role="tab" aria-controls="Display Keys Page">Display Keys Page</a>
                        <a class="list-group-item list-group-item-danger" id="list-settings-list" data-toggle="list"
                            href="current.php" role="tab" aria-controls="Current
                            Statistices Page">Current Statistices</a>
                    </div>

                </aside>
            </div>
            
            <div class="col-9 p-0">
                <main class="main_content pt-5 ps-5 pe-5">
                    <main class="main_content pt-5 ps-5 pe-5">
                        <p id="stat"><b>Display Current Statistices</b></p>
                        <hr />
            <form action="current.php"  method="POST">
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Number Items:</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp " value="<?php echo  $vals; ?>">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Total Size:</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" value="<?php echo $val; ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword2" class="form-label">Number Request:</label>
                    <input type="text" class="form-control" id="exampleInputPassword2"  value="<?php echo $value; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword3" class="form-label">Miss Rate:</label>
                    <input type="text" class="form-control" id="exampleInputPassword3" value="<?php echo  $valu; ?>">
                  </div>

                  <div class="mb-3">
                    <label for="exampleInputPassword4" class="form-label">Hit Rate:</label>
                    <input type="text" class="form-control" id="exampleInputPassword4" value="<?php echo  $valut; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword5" class="form-label">capacity memcached:</label>
                    <input type="text" class="form-control" id="exampleInputPassword5" value="<?php echo  $valk; ?>">
                  </div>
                
                  <div class="mb-3">
                    <button type="submit" name="clearmemcached" class="btn btn-outline-danger btn-lg"  >clear memcached</button>
                    </div>

                    <div class="mb-3">
                    <button type="submit" name="clear" class="btn btn-outline-danger btn-lg"  >clear  Statistices</button>
                    </div>





              </form> 
              </main>
              </main>
              </div>
              </div>
            </div>
    <script src="js/bootstrap.min.js"></script>
</body>



</html>