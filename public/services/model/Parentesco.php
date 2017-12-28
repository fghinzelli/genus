<?php

class Parentesco {
    private $db;
    public $id;
    public $descricao;
    public $status;
    
    function __construct($db) {
        $this->db = $db;
    }

    function getParentescos()
    {
        $sql = "SELECT * FROM Parentesco";
        $query = $this->db->query($sql);
        $parentescos = $query->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($parentescos);
    }
}

?>