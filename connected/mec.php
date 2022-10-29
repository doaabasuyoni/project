 <?php
  include"memcached.php";
  $serv = '127.0.0.1';
  $port = 11211;
  $memcacheD= new Memcached();
  // Add server
  if ($memcacheD->addServer($serv, $port)) {
    
}
else {
    echo "** issue while creating a server **\n";
}
 
?>