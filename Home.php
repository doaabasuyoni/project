<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Web Application</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/home.css" rel="stylesheet">
        <link rel="icon" href="img/home.jpg" />
        <script src="js/jquery-3.6.0.min.js">  </script>
        <script>
            $(document).ready(function(){
            $('#d2').click(function(){
            $('body').css({
              'background':'linear-gradient(rgb(13, 30, 61),rgb(69, 69, 70),rgb(133, 133, 134))'
            }) ;
        }) ;
        $('#d1').click(function(){
            $('body').css({
                'background':'linear-gradient(rgb(44, 3, 1),rgb(131, 6, 2),rgb(179, 14, 2))'
            }) ;
        }) ;
        $("#d3").slideUp(2000).slideDown(2000);
    }) ;  
    </script>
    </head>
    <body>
        <div class="container">
            <nav><a href="Home.php" class="logo">Home</a> 
             <ul> 
                <li><a href="#"><button id="d1" title="الوضع نهاري">🌞</button></a></li> 
                <li><a href="#"><button id="d2" title="الوضع الليلي">🌛</button></a></li>   
               <li><a href="Uplode.php">Uplode image</a></li> 
               <li><a href="Display.php">Display image</a></li> 
                <li><a href="keys.php">Display Keys</a></li>
                <li><a href="Current.php">Current statistices</a></li>
                </ul>
                </nav>
             <div class="content">
                 <div class="text">
                 <h2 id="d3"> Welcome to Cloud Computing <br/>secure data storage</h2>
                 </div> 
             </div>
             </div>
         </body>
     
    
    </body>
</html>