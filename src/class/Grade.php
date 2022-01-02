<?php class Grade
{

    // Connection
    private $conn;

    // Table
    private $db_table = "student_grades";

    // Columns
    public $student_id;
    public $grade;
    public $created_at;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getAllforStudent($id)
    {
        $sqlQuery =  $this->conn->prepare("SELECT grade FROM " . $this->db_table ." where student_id=".$id);
        try{
            $sqlQuery->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
         return $sqlQuery;
    }
    public function getAverageGradesForStudent($id)
    {
        $sqlQuery =  $this->conn->prepare("SELECT AVG(grade) FROM " . $this->db_table ." where student_id=".$id);
        try{
            $sqlQuery->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
        return $sqlQuery->fetchColumn();
    }
    

    // CREATE
    public function create()
    {
        $sqlQuery =  $this->conn->prepare("SELECT COUNT(grade) FROM " . $this->db_table ." where student_id=".$this->student_id);
        try{
            $sqlQuery->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
        if($sqlQuery->fetchColumn()<=4){

        $sqlQuery = "INSERT INTO
                " . $this->db_table . "
            SET
            student_id = :student_id,
            grade = :grade ";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));

        // bind data
        $stmt->bindParam(":student_id", $this->student_id);
        $stmt->bindParam(":grade", $this->grade);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }else{
        return false;
 
    }
    }

    
}
