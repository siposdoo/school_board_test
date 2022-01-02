<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/database.php';
    include_once '../../class/Student.php';
    $database = new Database();
    $db = $database->getConnection();
    
     
    if(isset($_GET['delete']) && $_GET['delete'] >0){
        $student = new Student($db);
        $student->id =  $_GET['delete'] ;
        echo $student->id;
        if($student->deleteStudent()){
            header('location:index.php');
        }

    }else{
        header('location:index.php'); 
    }
?>