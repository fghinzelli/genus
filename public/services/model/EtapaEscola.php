<?php

class EtapaEscola {
    private $db;
    public $id;
    public $descricao;
    public $status;
    
    function __construct($db) {
        $this->db = $db;
    }

    function getEtapasEscola()
    {
        $sql = "SELECT * FROM EtapaEscola";
        $query = $this->db->query($sql);
        $etapasEscola = $query->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($etapasEscola);
    }
}

?>