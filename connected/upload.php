<?php include('connected.php');

if(isset($_POST["save"])){
    echo"hhhhhhhhhhhhhhh";
    $name=$_POST["name"];
    echo $name;
    $id=$_POST["keys"];
    echo $id;
    $filename=$_FILES["upload"]["name"];
    echo $filename;
    $temp=$_FILES["upload"]["tmp_name"];
    echo $temp;
    $folder = "images/".$filename;
    echo $folder;
    move_uploaded_file($temp,$folder);
    if($id!=""&&$name!=""&& $filename!="")
     {
      
          $query="insert into uplode(imgname,idimg) values ('$filename',$id)";
          echo"hello";
          $data=mysqli_query($conn,$query);
       if($data)
         echo"uploade img";
        else
        echo "welcome"; 

     }
    }




?>
<?php include('connected/connected.php');
if(isset($_POST['upload'])){
    $name=$_POST['data'];
    $id=$_POST['iddata'];
    $filename=$_FILES['file']["name"];
    $filetype=$_FILES['file']["type"];
    $temp=$_FILES['file']["tmp_name"];
    $folder = "images/".$filename;
    if((empty($name)&&empty( $filename))||(!empty($name)&&!empty( $filename))){
        echo"please enter the choice file image or input image by hand";
    }
  elseif($filetype!="jpg"||$filetype!="jpeg"||$filetype!="png"){
         echo"This is not an image";
    }
    elseif(empty($id)){
        echo"please enter the id";
    }
    elseif(!filter_var($id,FILTER_VALIDATE_INT)){
        echo"please enter the id integer";
    }
else{
      if($id!=""&&$name!=""&&empty($filename)){
       move_uploaded_file($tempname,  $foldername);
       $query="insert into uplode(imgname,idimg) values (' $name',$id)";
       $data=mysqli_query($conn,$query);
        if($data){
        echo"uploade imges";
        header('Location:Uplode.php');
        }
       else
         echo "error:".mysqli_error($conn); 
      }

   if($id!=""&& $filename!=""&&empty($name))
     {

        move_uploaded_file($temp,$folder);
          $query="insert into uplode(imgname,idimg) values ('$filename',$id)";
          $data=mysqli_query($conn,$query);
       if($data){
         echo"uploade imges";
         header('Location:Uplode.php');
       }
        else
        echo "error:".mysqli_error($conn);  
     }
    }
}
<!-- </div>
                    <div class="mb-3"  >
                      <label for="exampleInputPassword1" class="form-label">Or Name image:</label>
                      <input type="text" name="nameimg" class="form-control" id="exampleInputPassword1"  placeholder="input Name image" >-->
                   <!-- </div>
                   <input type="text" name="data" / >
                 
                   $filenames=mysqli_real_escape_string($conn,$_POST['$filename']);
                   header('Location:Uplode.php');
                   $before=memory_get_usage();