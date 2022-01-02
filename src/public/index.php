<?php
 include_once '../config/database.php';
 include_once '../class/Student.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$database = new Database();
$db = $database->getConnection();

 
$items = new Student($db);

$stmt = $items->getStudents();
$itemCount = $stmt->rowCount();


 
// all of our endpoints start with /person
// everything else results in a 404 Not Found
if ($uri[1] == 'students' && !isset($uri[2])) {
 
  if($itemCount > 0){
      
     
      $studentArr= array();
      

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $e = array(
              "id" => $id,
              "name" => $name,
             "school_board" => $school_board,
              "created_at" => $created_at
          );

          array_push($studentArr, $e);
      }
      echo json_encode($studentArr);
  }

  else{
      http_response_code(404);
      echo json_encode(
          array("message" => $itemCount.": record found.")
      );
  }
  
  exit;
}
if($uri[1] == 'students' && isset($uri[2]) && (int)$uri[2] > 0 ){
  $item = new Student($db);

  $item->id =  $uri[2] ;

  $item->getStudent();
  if($item->name != null){
    // create array
    $emp_arr = array(
        "id" =>  $item->id,
        "name" => $item->name,
        "school_board" => $item->school_board,
        "created_at" => $item->created_at
    );
  
    http_response_code(200);
    echo json_encode($emp_arr);
}
  
else{
    http_response_code(404);
    echo json_encode("Student not found.");
}
  exit;
}
 
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Sahil Kumar">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SCHOOL BOARD TEST</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />

  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="#">SCHOOL BOARD TEST</a>
    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/">HOME</a>
        </li>
        
        
      </ul>
    </div>
 
  </nav>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h3 class="text-center text-dark mt-2">School board test for QUANTOX</h3>
        <hr>
      
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
      <div class="row">
      <div class="col-md-12">
        <h3 class="text-center text-info">Add Student</h3>
        <form action="action.php" method="post" enctype="multipart/form-data">
          
          <div class="form-group">
          <label for="name">Student name</label>
            <input type="text" name="name" value="" class="form-control" placeholder="Enter name" required>
          </div>
          
          <div class="form-group">
          <label for="name">School board</label>
            <select   name="s_board"  class="form-control"  required>
                <option></option>
            </select>
          </div>
           
          <div class="form-group">
            
             
            <input type="submit" name="add_student" class="btn btn-primary btn-block" value="Add Student">
            
          </div>
        </form>
            </div>
            </div>
            <div class="col-md-12">
        <h3 class="text-center text-info">Add Grade</h3>
        <form action="" method="post" enctype="multipart/form-data">
          
          <div class="form-group">
            <input type="number" name="grade" value="" class="form-control" placeholder="Enter grade" required>
          </div>
          
          <div class="form-group">
            <select   name="student"  class="form-control"  required>
                <option></option>
            </select>
          </div>
           
          <div class="form-group">
            
             
            <input type="submit" name="add_grade" class="btn btn-primary btn-block" value="Add Grade">
            
          </div>
        </form>
            </div>
            </div>
      
      <div class="col-md-8">
        
        <h3 class="text-center text-info">Students In The Database</h3>
        <table class="table table-hover" id="data-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Board</th>
              <th>Created at</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
             <?php 

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
  extract($row);?>
 
            <tr>
              <td><?= $id; ?> </td>
              <td> <?= $name; ?></td>
              <td><?= $school_board; ?> </td>
              <td> <?= $created_at; ?></td>
               <td>
                 <a href="api/student.php?delete=" class="badge badge-danger p-2" onclick="return confirm('Do you want delete this record?');">Delete</a> 
               </td>
            </tr>";
            <?php } ?>
           
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function() {
    $('#data-table').DataTable({
      paging: true
    });
  });
  </script>
</body>

</html>