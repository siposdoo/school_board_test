<?php class SchoolBoard
{

    // Connection
    private $conn;

    // Table
    private $db_table = "school_boards";

    // Columns
    public $id;
    public $name;
    public $created_at;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getAll()
    {
        $sqlQuery = "SELECT id, name,  created_at FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }


    // CREATE
    public function create()
    {
        $sqlQuery = "INSERT INTO
                " . $this->db_table . "
            SET
                name = :name";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));

        // bind data
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ single
    public function get()
    {
        $sqlQuery = "SELECT
                id,
                name,
                created_at
              FROM
                " . $this->db_table . "
            WHERE 
               id = ?
            LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($dataRow) {
            $this->name = $dataRow['name'];
            $this->created_at = $dataRow['created_at'];
        }
    }  // READ single
    
    // DELETE
    function delete()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
