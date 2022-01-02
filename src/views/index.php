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
        <li class="nav-item">
          <a class="nav-link" href="/endpoints">Endpoints</a>
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
            <input type="text" name="name" value="" class="form-control" placeholder="Enter name" required>
          </div>
          
          <div class="form-group">
            <select   name="s_board"  class="form-control"  required>
                <option></option>
            </select>
          </div>
           
          <div class="form-group">
            
             
            <input type="submit" name="add" class="btn btn-primary btn-block" value="Add Record">
            
          </div>
        </form>
            </div>
            </div>
            <div class="col-md-12">
        <h3 class="text-center text-info">Add Grade</h3>
        <form action="action.php" method="post" enctype="multipart/form-data">
          
          <div class="form-group">
            <input type="number" name="grade" value="" class="form-control" placeholder="Enter grade" required>
          </div>
          
          <div class="form-group">
            <select   name="student"  class="form-control"  required>
                <option></option>
            </select>
          </div>
           
          <div class="form-group">
            
             
            <input type="submit" name="add" class="btn btn-primary btn-block" value="Add Grade">
            
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
             
            <tr>
              <td> </td>
              <td> </td>
              <td> </td>
              <td> </td>
               <td>
                <a href="details.php?details=" class="badge badge-primary p-2">Check grades</a> |
                <a href="action.php?delete=" class="badge badge-danger p-2" onclick="return confirm('Do you want delete this record?');">Delete</a> |
               </td>
            </tr>
           
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