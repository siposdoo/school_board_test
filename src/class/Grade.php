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
        try{
            $sqlQuery->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
        $grades = array();
        while ($row = $sqlQuery->fetch(PDO::FETCH_ASSOC)) {
           array_push( $grades,$row['grade']);
        }
         return $grades;
    }  
    public function checkPassOrFail($boardId,$studentId)
    {
        switch($boardId){
            case 1:
                $sqlQuery =  $this->conn->prepare("SELECT AVG(grade) FROM " . $this->db_table ." where student_id=".$studentId);
                try{
                    $sqlQuery->execute();
                }catch(PDOException $e){
                    die($e->getMessage());
                }
                if($sqlQuery->fetchColumn()>=7){
                    return "Pass";
                }else{
                    return "Fail";
                }
                break;
             case 2:
                    $sqlQuery =  $this->conn->prepare("SELECT grade FROM " . $this->db_table ." where student_id=".$studentId ." order by grade DESC LIMIT 0,2" );
                    try{
                        $sqlQuery->execute();
                    }catch(PDOException $e){
                        die($e->getMessage());
                    }
                    
                    $gradecount=0;
                    $hgrade=0;
                   
                    while ($row = $sqlQuery->fetch(PDO::FETCH_ASSOC)) {
                            $gradecount++;
                            if($hgrade<$row["grade"]){
                                $hgrade=$row["grade"];
                            }
                        }
                    
                    if($gradecount>1 && $hgrade>8 ){
                        return "Pass";
                    }else{
                        return "Fail";
                    }
                    break;

        }
       
        
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
