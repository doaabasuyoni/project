<?php
 include('connected/connected.php');
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
                            Statistices Page">  Manager App</a>
                    </div>

                </aside>
            </div>
            
            <div class="col-9 p-0">
                <main class="main_content pt-5 ps-5 pe-5">
                    <main class="main_content pt-5 ps-5 pe-5">
                        <p id="stat"><b>Display Current Statistices</b></p>
                        <hr />
                        <div>
         <canvas id="myChart"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
        <script>
         const ctx = document.getElementById('myChart');

         new Chart(ctx, {
           type: 'bar',
           data: {
           labels: ['NUM Workers', 'MISS Rate', 'Hit Rate', 'NUM Items', 'Total Size', 'NUM request'],
           datasets: [{
           label: '# num',
           data: [3,5, 2, 1,10, 6],
           borderWidth: 1
           }]
           },
         options: {
         scales: {
          y: {
          beginAtZero: true
          }
         }
         }
         });
        </script>
        <br>
        <div class="mb-3">
                    <label for="exampleInputPassword" class="form-label">capacity memcached:</label>
                    <input type="number" class="form-control" id="exampleInputPassword" min="1" max="8">
        </div>
        
        <div class="form-floating">
         <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
         <option selected disabled>Choose a Replacement Policy</option>
          <option value="Random">Random Replacement</option>
          <option value="Least">Least Recently Used</option>
    
         </select>
         <label for="floatingSelect">Policy</label>
         <br>
         <div class="mb-3">
                   <label for="exampleInputPassword1" class="form-label">Resizing Memcache Pool</label>
                   <br>
                   <label for="exampleInputPassword2" class="form-label">1- Manual Mode</label>
                   <br>
                    <button type="button" class="btn btn-danger"> - Shrinking</button>
                    <button type="button" class="btn btn-danger"> + Growing</button>
                    <br>
                    <br>
                    <label for="exampleInputPassword3" class="form-label">2- Automatic </label>
        </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword4" class="form-label">Max Miss Rate:</label>
                    <input type="text" class="form-control" id="exampleInputPassword4" >
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword5" class="form-label">Min Miss Rate:</label>
                    <input type="text" class="form-control" id="exampleInputPassword5" >
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword6" class="form-label">Ratio to expand:</label>
                    <input type="text" class="form-control" id="exampleInputPassword6" >
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword7" class="form-label">Ratio to shrink:</label>
                    <input type="text" class="form-control" id="exampleInputPassword7" >
                  </div>
                  <div class="mb-3">
                  <button type="button" class="btn btn-danger"> Delete Database</button>
                    </div>
                    <div class="mb-3">
                    <button type="button" class="btn btn-danger"> Delete S3</button>
                    </div>

                    <div class="mb-3">
                    <button type="button" class="btn btn-danger"> clear  memcached</button>
                    </div>

         <br>

        
</div>
         
            
                </main>
                </main>
              </div>
              </div>
            </div>
    <script src="js/bootstrap.min.js"></script>
</body>



</html>