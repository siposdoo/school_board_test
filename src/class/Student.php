<?php class Student{

// Connection
private $conn;

// Table
private $db_table = "student";

// Columns
public $id;
public $name;
public $school_board;
public $created_at;

// Db connection
public function __construct($db){
    $this->conn = $db;
}

// GET ALL
public function getStudents(){
    $sqlQuery = "SELECT id, name, school_board,   created_at FROM " . $this->db_table . "";
    $stmt = $this->conn->prepare($sqlQuery);
    $stmt->execute();
    return $stmt;
}

// CREATE
public function createStudent(){
    $sqlQuery = "INSERT INTO
                ". $this->db_table ."
            SET
                name = :name, 
                school_board = :school_board";

    $stmt = $this->conn->prepare($sqlQuery);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->school_board=htmlspecialchars(strip_tags($this->school_board));
    

    // bind data
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":school_board", $this->school_board);
   

    if($stmt->execute()){
       return true;
    }
    return false;
}

// READ single
public function getStudent(){
    $sqlQuery = "SELECT
                id,
                name, 
                school_board, 
                created_at
              FROM
                ". $this->db_table ."
            WHERE 
               id = ?
            LIMIT 0,1";

    $stmt = $this->conn->prepare($sqlQuery);

    $stmt->bindParam(1, $this->id);

    $stmt->execute();

    $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if($dataRow){
    $this->name = $dataRow['name'];
    $this->school_board = $dataRow['school_board'];
    $this->created_at = $dataRow['created_at'];
    } 
}        
 
// DELETE
function deleteStudent(){
    $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
    $stmt = $this->conn->prepare($sqlQuery);

    $this->id=htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(1, $this->id);

    if($stmt->execute()){
        return true;
    }
    return false;
}

}
?>