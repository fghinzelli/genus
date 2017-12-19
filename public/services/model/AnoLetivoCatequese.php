<?php

class AnoLetivoCatequese {
    private $db;
    public $id;
    public $descricao;
    public $status;
    
    function __construct($db) {
        $this->db = $db;
    }

    function getAnosLetivos()
    {
        $sql = "SELECT * FROM AnoLetivoCatequese";
        $query = $this->db->query($sql);
        $anosLetivos = $query->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($anosLetivos);
    }
}

?>