<?php 
//connected database
include('connected/connected.php');
//errors input
$error=['iderror'=>'',
'fileerror'=>''];
//Uplode image
if(isset($_POST['upload'])){
    //varibales
$id=$_POST['iddata'];
 $filename=$_FILES['file']["name"];
 $filetype=$_FILES['file']["type"];
 $filesize=$_FILES['file']["size"];
 $temp=$_FILES['file']["tmp_name"];
 $folder ="images/".$filename;
 //array vaild image
$extension = substr($filename,strlen($filename)-5,strlen($filename));
$allowed_extensions = array(".jpg",".jpeg",".png",".gif",".PNG");
//validation input
    if(empty( $filename)){
        $error['fileerror']='please enter the  image';
    }
    elseif(!in_array($extension,$allowed_extensions))
    {
        $error['fileerror']= 'Invalid format. Only jpg / jpeg/ png /gif /PNG format allowed';
    }
    if(empty($id)){
    $error['iderror']='please enter the id';
    }
    elseif(!filter_var($id,FILTER_VALIDATE_INT)){
        $error['iderror']='please enter the id integer';
    }
      //insert image && updata image in same key
  
   if($id!=""&& $filename!=""&&in_array($extension,$allowed_extensions)&&filter_var($id,FILTER_VALIDATE_INT))
     {
        //updata image in same key
      $sql="SELECT uplode.idimg FROM uplode WHERE uplode.idimg=$id";
      $datas=mysqli_query($conn,$sql);
      $images=mysqli_fetch_all($datas,MYSQLI_ASSOC);
      mysqli_free_result($datas);
      $d='';
      foreach($images as $image ):
      $d=$image['idimg'];
      endforeach;
       if($d==$id){
        $qlo= "UPDATE uplode SET uplode.imgname='$filename' WHERE uplode.idimg=$id";
        $dat=mysqli_query($conn,$qlo);
        if($dat){
         echo "<script>alert('image Update successfully');</script>";
         move_uploaded_file($temp,$folder);
        }
         else{
            echo "<script>alert('image not Update ');</script>";
         }
        }
         //سؤال
         
        //insert image 
    else{
          $query="insert into uplode(imgname,idimg) values ('$filename',$id)";
          $data=mysqli_query($conn,$query);
       if($data){
        move_uploaded_file($temp,$folder);
        echo "<script>alert('image inserted successfully');</script>";
       }
        else
        echo "<script>alert('image not inserted');</script>"; 
          
        
}
    
  
    mysqli_close($conn);
}
}
?>
<!DOCTYPE 
html>
<html lang="en">
    <head>
        <title>Uplode images</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/Uplode.css" rel="stylesheet">
        <link rel="icon" href="img/images.jpg" />
        <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="js/bootstrap.min.js">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
<div class="container-fluid" >
    <div class="row" >
        <div class="col-3 p-0" >
            <aside class="main_menu p-3 pt-5">
                <h4>My Files</h4>
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list"
                            href="Home.php" role="tab" aria-controls="home">Home</a>
                        <a class="list-group-item list-group-item-danger" id="list-profile-list" data-toggle="list"
                            href="Uplode.php" role="tab" aria-controls="Upload
                            Page">Upload
                            images</a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list"
                            href="Display.php" role="tab" aria-controls="Display
                            Image Page">Display
                            images</a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list"
                            href="keys.php" role="tab" aria-controls="Display Keys Page">Display Keys</a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list"
                            href="current.php" role="tab" aria-controls="Current
                            Statistices Page">Manager App</a>
                    </div>
    
            </aside>
        </div>
         
<div class="col-9 p-0" >
    <main class="main_content pt-5 ps-5 pe-5" >
        <main class="main_content pt-5 ps-5 pe-5" >
            <p id="stat"><b>Welcome to Uplode page</b></p>
            <hr />    
                <form enctype="multipart/form-data" action="Uplode.php"  method="POST">
                    <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Uplode images</label>
                    <input type="file" name="file" accept="image/*" class="form-control" id="exampleInputEmail1"  aria-describedby="emailHelp" />
                    <div  class="form-text error "><?php echo $error['fileerror']?></div>
                    </div>
                    <div class="mb-3">
                    <label for="exampleInputPassword2" class="form-label"> Key:</label>
                    <input type="text" name="iddata" class="form-control" id="exampleInputPassword2"  placeholder="input key" />
                    <div  class="form-text error form-label"><?php echo $error['iderror'] ?></div>
                    </div>
                    <div class="mb-3">
                    <button type="submit" name="upload"class="btn btn-outline-danger btn-lg"  >Uplode Key</button>
                    </div>
                </form>
      </main>
    </main>
</div>

<script src="js/bootstrap.min.js"></script>
</body>
</html>
