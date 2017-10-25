<?php

class Pessoa {
    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function getPessoas() {
        $sql = "SELECT * FROM Pessoa";
        $query = $this->db->query($sql);
        $pessoas = $query->fetchAll(PDO::FETCH_OBJ);
        echo "{\"pessoas\":" . json_encode($pessoas) . "}";
    }
    
    function getPessoa($id)
    {
      $sql = "SELECT * FROM Pessoa WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $pessoa = $query->fetchObject();
    
      //municipio
      $sql = "SELECT * FROM Municipio WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id",$pessoa->municipioId);
      $query->execute();
      $pessoa->municipio =  $query->fetchObject();
    
      echo json_encode($pessoa);
    }

    function addPessoa($nome, $sexo, $dataNascimento, $telefone1, $telefone2, $cpf, $rg, $email, $logradouro, $numero, $complemento, $bairro, $municipioId, $dataCadastramento, $status) {
        //$request = \Slim\Slim::getInstance()->request();
        //$pessoa = json_decode($request->getBody());
        $sql = "INSERT INTO Pessoa (`nome`, `sexo`, `dataNascimento`, `telefone1`, `telefone2`, `cpf`, `rg`, `email`, `logradouro`, `numero`, `complemento`, `bairro`, `municipioId`, `dataCadastramento`, `status`) 
                VALUES (:nome, :sexo, :dataNascimento, :telefone1, :telefone2, :cpf, :rg, :email, :logradouro, :numero, :complemento, :bairro, :municipioId, :dataCadastramento, :status) ";
        $query = $this->db->prepare($sql);
        $query->bindParam("nome",$pessoa->nome);
        $query->bindParam("sexo",$pessoa->sexo);
        $query->bindParam("dataNascimento",$pessoa->dataNascimento);
        $query->bindParam("telefone1",$pessoa->telefone1);
        $query->bindParam("telefone2",$pessoa->telefone2);
        $query->bindParam("cpf",$pessoa->cpf);
        $query->bindParam("rg",$pessoa->rg);
        $query->bindParam("email",$pessoa->email);
        $query->bindParam("logradouro",$pessoa->logradouro);
        $query->bindParam("numero",$pessoa->numero);
        $query->bindParam("complemento",$pessoa->complemento);
        $query->bindParam("bairro",$pessoa->bairro);
        $query->bindParam("municipioId",$pessoa->municipioId);
        $query->bindParam("dataCadastramento",$pessoa->dataCadastramento);
        $query->bindParam("status",$pessoa->status);
        $query->execute();
        $produto->id = $conn->lastInsertId();
        echo json_encode($produto);
    }
    
    
    
    
    function savePessoa($id)
    {
      $request = \Slim\Slim::getInstance()->request();
      $pessoa = json_decode($request->getBody());
      $sql = "UPDATE Pessoa SET nome=:nome,sexo=:sexo,dataNascimento=:dataNascimento,telefone1=:telefone1,
                telefone2=:telefone2,cpf=:cpf,rg=:rg,email=:email,logradouro=:logradouro,numero=:numero,
              complemento=:complemento,bairro=:bairro,municipioId=:municipioId,dataCadastramento=:dataCadastramento,status=:status
                WHERE id=:id";
      $conn = getConn();
      $query = $conn->prepare($sql);
      $query->bindParam("nome",$pessoa->nome);
      $query->bindParam("sexo",$pessoa->sexo);
      $query->bindParam("dataNascimento",$pessoa->dataNascimento);
      $query->bindParam("telefone1",$pessoa->telefone1);
      $query->bindParam("telefone2",$pessoa->telefone2);
      $query->bindParam("cpf",$pessoa->cpf);
      $query->bindParam("rg",$pessoa->rg);
      $query->bindParam("email",$pessoa->email);
      $query->bindParam("logradouro",$pessoa->logradouro);
      $query->bindParam("numero",$pessoa->numero);
      $query->bindParam("complemento",$pessoa->complemento);
      $query->bindParam("bairro",$pessoa->bairro);
      $query->bindParam("municipioId",$pessoa->municipioId);
      $query->bindParam("dataCadastramento",$pessoa->dataCadastramento);
      $query->bindParam("status",$pessoa->status);
      $query->bindParam("id",$id);
      $query->execute();
      echo json_encode($pessoa);
    
    }
    
    function deletePessoa($id)
    {
      $sql = "DELETE FROM Pessoa WHERE id=:id";
      $conn = getConn();
      $query = $conn->prepare($sql);
      $query->bindParam("id",$id);
      $query->execute();
      echo "{'message':'Pessoa apagada'}";
    }
}
?>