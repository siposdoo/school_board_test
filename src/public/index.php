<?php
include_once '../config/Database.php';
include_once '../class/Student.php';
include_once '../class/SchoolBoard.php';
include_once '../class/Grade.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$database = new Database();
$db = $database->getConnection();

if (isset($_POST['add_student'])) {
  $student = new Student($db);
  $student->name = $_POST['name'];
  $student->school_board = $_POST['s_board'];
  if ($student->createStudent()) {
    header('location:index.php');
  }
}
if (isset($_POST['add_grade'])) {
  $grade = new Grade($db);
  $grade->student_id = $_POST['student_id'];
  $grade->grade = $_POST['grade'];
  if ($grade->create()) {
    header('location:index.php');
  }
}


$items = new Student($db);
$sboard = new SchoolBoard($db);

$allSboards = $sboard->getAll();
$stmt = $items->getStudents();
$itemCount = $stmt->rowCount();



// all of our endpoints start with /person
// everything else results in a 404 Not Found
if ($uri[1] == 'students' && !isset($uri[2])) {

  if ($itemCount > 0) {


    $studentArr = array();


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $sboard->id = $school_board;
      $sboard->get();
      $gradeTmp = new Grade($db);
      $e = array(
        "id" => $id,
        "name" => $name,
        "school_board" => $sboard->name,
        "AVG" => $gradeTmp->getAverageGradesForStudent($id),
        "Grades" => $gradeTmp->getAllforStudent($id),
        "Status" => $gradeTmp->checkPassOrFail($school_board, $id),
        "created_at" => $created_at
      );

      array_push($studentArr, $e);
    }
    echo json_encode($studentArr);
  } else {
    http_response_code(404);
    echo json_encode(
      array("message" => $itemCount . ": record found.")
    );
  }

  exit;
}
if ($uri[1] == 'students' && isset($uri[2]) && (int)$uri[2] > 0) {
  $item = new Student($db);

  $item->id =  $uri[2];

  $item->getStudent();
  if ($item->school_board == 1) {
    header('Content-Type: application/json');

    if ($item->name != null) {
      // create array
      $sboard->id = $item->school_board;
      $sboard->get();
      $gradeTmp = new Grade($db);
      $emp_arr = array(
        "id" =>  $item->id,
        "name" => $item->name,
        "school_board" => $sboard->name,
        "AVG" => $gradeTmp->getAverageGradesForStudent($item->id),
        "Grades" => $gradeTmp->getAllforStudent($item->id),
        "Status" => $gradeTmp->checkPassOrFail($item->school_board, $item->id),
        "created_at" => $item->created_at
      );

      http_response_code(200);
      echo json_encode($emp_arr);
    } else {
      http_response_code(404);
      echo json_encode("Student not found.");
    }
    exit;
  } else {


    if ($item->name != null) {
      header("Content-type: text/xml");

      // create array
      $sboard->id = $item->school_board;
      $sboard->get();
      $gradeTmp = new Grade($db);
      $xml_output = "<?xml version=\"1.0\"?>\n";
      $xml_output .= "\t<student>\n";
      $xml_output .= "\t<id>" . $item->id . "</id>\n";
      $xml_output .= "\t<name>" . $item->name . "</name>\n";
      $xml_output .= "\t<school_board>" . $item->school_board . "</school_board>\n";
      $xml_output .= "\t<AVG>" . $gradeTmp->getAverageGradesForStudent($item->id) . "</AVG>\n";
      $xml_output .= "\t<Grades>";
      foreach($gradeTmp->getAllforStudent($item->id) as $grade){
       $xml_output .= "\t<grade>" . $grade. "</grade>\n";
      }
       $xml_output .="</Grades>\n";
      $xml_output .= "\t<Status>" . $gradeTmp->checkPassOrFail($item->school_board, $item->id) . "</Status>\n";
    
     

      $xml_output .= "\t</student>\n";
      
      echo $xml_output;
    } else {
      http_response_code(404);
      echo json_encode("Student not found.");
    }
    exit;
  }
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
            <form action="" method="post" enctype="multipart/form-data">

              <div class="form-group">
                <label for="name">Student name</label>
                <input type="text" name="name" value="" class="form-control" placeholder="Enter name" required>
              </div>

              <div class="form-group">
                <label for="name">School board</label>
                <select name="s_board" class="form-control" required>
                  <?php

                  while ($row = $allSboards->fetch(PDO::FETCH_ASSOC)) {
                    extract($row); ?>
                    <option value="<?= $id; ?>"><?= $name; ?></option>
                  <?php } ?>
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
              <select name="student_id" class="form-control" required>
                <?php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                ?>
                  <option value="<?= $id; ?>"><?= $name; ?></option>
                <?php
                }
                ?>
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
              <th>Avg</th>
              <th>Board</th>
              <th>Created at</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $stmt = $items->getStudents();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $sboard->id = $school_board;
              $sboard->get();
              $gradeTmp = new Grade($db);



            ?>

              <tr>
                <td><?= $id; ?> </td>
                <td> <?= $name; ?></td>
                <td> <?= $gradeTmp->getAverageGradesForStudent($id); ?></td>
                <td><?= $sboard->name; ?> </td>
                <td> <?= $created_at; ?></td>
                <td>
                  <a href="api/student.php?delete=<?= $id; ?>" class="badge badge-danger p-2" onclick="return confirm('Do you want delete this record?');">Delete</a>
                </td>
              </tr>
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