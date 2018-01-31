<?php


class Pessoa {
    private $db;
    public $id;
    public $nome;
    public $sexo;
    public $nomePai;
    public $nomeMae;
    public $dataNascimento;
    public $telefone1;
    public $telefone2;
    public $telefone3;
    public $cpf;
    public $rg;
    public $rgEmissor;
    public $rgUF;
    public $passaporte;
    public $nacionalidade;
    public $email;
    public $logradouro;
    public $numero;
    public $complemento;
    public $bairro;
    public $municipioId;
    public $cep;
    public $numeroDizimo;
    public $comunidadeId;
    public $observacoes;
    public $batizado;
    public $localBatismo;
    public $dataBatismo;
    public $primeiraEucaristia;
    public $localPrimeiraEucaristia;
    public $dataPrimeiraEucaristia;
    public $status;
    public $dataUltimaAlteracao;
    public $usuarioUltimaAlteracaoId;
    
    function __construct($db) {
        $this->db = $db;
    }

    function loadData($id, $nome, $sexo, $nomePai, $nomeMae, $dataNascimento, $telefone1, $telefone2, $telefone3,
                      $cpf, $rg, $rgEmissor, $rgUF, $passaporte, $nacionalidade, $email, $logradouro, 
                      $numero, $complemento, $bairro, $municipioId, $cep,
                      $numeroDizimo, $comunidadeId, $observacoes, $batizado, $localBatismo, $dataBatismo, $primeiraEucaristia,
                      $localPrimeiraEucaristia, $dataPrimeiraEucaristia, $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
        $this->id = $id;
		$this->nome = $nome;
        $this->sexo = $sexo;
        $this->nomePai = $nomePai;
        $this->nomeMae = $nomeMae;
		$this->dataNascimento = converterDataToISO($dataNascimento);
		$this->telefone1 = $telefone1;
        $this->telefone2 = $telefone2;
        $this->telefone3 = $telefone3;
		$this->cpf = $cpf;
        $this->rg = $rg;
        $this->rgEmissor = $rgEmissor;
        $this->rgUF = $rgUF;
        $this->passaporte = $passaporte;
        $this->nacionalidade = $nacionalidade;
		$this->email = $email;
		$this->logradouro = $logradouro;
		$this->numero = $numero;
		$this->complemento = $complemento;
		$this->bairro = $bairro;
        $this->municipioId = $municipioId;
        $this->cep = $cep;
        $this->numeroDizimo = $numeroDizimo;
        $this->comunidadeId = $comunidadeId;
        $this->comunidade = 
        $this->observacoes = $observacoes;
        $this->batizado = (int)$batizado;
        $this->localBatismo = $localBatismo;
        $this->dataBatismo = converterDataToISO($dataBatismo);
        $this->primeiraEucaristia = (int)$primeiraEucaristia;
        $this->localPrimeiraEucaristia = $localPrimeiraEucaristia;
        $this->dataPrimeiraEucaristia = converterDataToISO($dataPrimeiraEucaristia);
        $this->status = $status;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
    } 

    function getPessoas() {
        $sql = "SELECT * FROM Pessoa WHERE status = 1 ORDER BY nome;";
        $query = $this->db->query($sql);
        $pessoas = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($pessoas as $pessoa) {
            // Busca de dados relacionados
            // COMUNIDADE
            $pessoa->dataNascimento = converterDataFromISO($pessoa->dataNascimento);
            $pessoa->dataBatismo = converterDataFromISO($pessoa->dataBatismo);
            $pessoa->dataPrimeiraEucaristia = converterDataFromISO($pessoa->dataPrimeiraEucaristia);
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $this->db->prepare($sqlc);
            $queryc->bindParam("id",$pessoa->comunidadeId);
            $queryc->execute();
            $pessoa->comunidade =  $queryc->fetchObject();
            // MUNICIPIO
            $sqlm = "SELECT * FROM Municipio WHERE id=:id";
            $querym = $this->db->prepare($sqlm);
            $querym->bindParam("id",$pessoa->municipioId);
            $querym->execute();
            $pessoa->municipio =  $querym->fetchObject();
        }
        echo json_encode($pessoas);
    }
    
    function getPessoa($id)
    {
      $sql = "SELECT * FROM Pessoa WHERE status = 1 AND id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $pessoa = $query->fetchObject();
      $pessoa->dataNascimento = converterDataFromISO($pessoa->dataNascimento);
      $pessoa->dataBatismo = converterDataFromISO($pessoa->dataBatismo);
      $pessoa->dataPrimeiraEucaristia = converterDataFromISO($pessoa->dataPrimeiraEucaristia);

      // COMUNIDADE
      $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
      $queryc = $this->db->prepare($sqlc);
      $queryc->bindParam("id",$pessoa->comunidadeId);
      $queryc->execute();
      $pessoa->comunidade =  $queryc->fetchObject();
    
      //MUNICIPIO
      $sqlm = "SELECT * FROM Municipio WHERE id=:id";
      $querym = $this->db->prepare($sqlm);
      $querym->bindParam("id",$pessoa->municipioId);
      $querym->execute();
      $pessoa->municipio =  $querym->fetchObject();


      
      echo json_encode($pessoa);
    }

    function addPessoa() {
        $sql = "INSERT INTO Pessoa (`nome`, `sexo`, `nomePai`, `nomeMae`, `dataNascimento`, `telefone1`, `telefone2`, `telefone3`, 
                                    `cpf`, `rg`, `rgEmissor`, `rgUF`, `passaporte`, `nacionalidade`, `email`, `logradouro`, 
                                    `numero`, `complemento`, `bairro`, `municipioId`, `cep`, 
                                    `numeroDizimo`, `comunidadeId`, `observacoes`, `batizado`, `localBatismo`, `dataBatismo`,
                                    `primeiraEucaristia`, `localPrimeiraEucaristia`, `dataPrimeiraEucaristia`,
                                    `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
                VALUES (:nome, :sexo, :nomePai, :nomeMae, :dataNascimento, :telefone1, :telefone2, :telefone3,
                        :cpf, :rg, :rgEmissor, :rgUF, :passaporte, :nacionalidade, :email, :logradouro, :numero, 
                        :complemento, :bairro, :municipioId, :cep, 
                        :numeroDizimo, :comunidadeId, :observacoes, :batizado, :localBatismo, :dataBatismo,
                        :primeiraEucaristia, :localPrimeiraEucaristia, :dataPrimeiraEucaristia,
                        :status, NOW(), :usuarioUltimaAlteracaoId)";
        $query = $this->db->prepare($sql);
        $query->bindParam(":nome",$this->nome);
        $query->bindParam(":sexo",$this->sexo);
        $query->bindParam(":nomePai",$this->nomePai);
        $query->bindParam(":nomeMae",$this->nomeMae);
        $query->bindParam(":dataNascimento",$this->dataNascimento);
        $query->bindParam(":telefone1",$this->telefone1);
        $query->bindParam(":telefone2",$this->telefone2);
        $query->bindParam(":telefone3",$this->telefone3);
        $query->bindParam(":cpf",$this->cpf);
        $query->bindParam(":rg",$this->rg);
        $query->bindParam(":rgEmissor",$this->rgEmissor);
        $query->bindParam(":rgUF",$this->rgUF);
        $query->bindParam(":passaporte",$this->passaporte);
        $query->bindParam(":nacionalidade",$this->nacionalidade);
        $query->bindParam(":email",$this->email);
        $query->bindParam(":logradouro",$this->logradouro);
        $query->bindParam(":numero", $this->numero);
        $query->bindParam(":complemento", $this->complemento);
        $query->bindParam(":bairro", $this->bairro);
        $query->bindParam(":municipioId", $this->municipioId);
        $query->bindParam(":cep", $this->cep);
        $query->bindParam(":numeroDizimo", $this->numeroDizimo);
        $query->bindParam(":comunidadeId", $this->comunidadeId);
        $query->bindParam(":observacoes", $this->observacoes);
        $query->bindParam(":batizado", $this->batizado);
        $query->bindParam(":localBatismo", $this->localBatismo);
        $query->bindParam(":dataBatismo",$this->dataBatismo);
        $query->bindParam(":primeiraEucaristia", $this->primeiraEucaristia);
        $query->bindParam(":localPrimeiraEucaristia", $this->localPrimeiraEucaristia);
        $query->bindParam(":dataPrimeiraEucaristia",$this->dataPrimeiraEucaristia);
        $query->bindParam(":status",$this->status);
        //$query->bindParam(":dataUltimaAlteracao", $this->dataUltimaAlteracao);
        $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }
    
    function savePessoa()
    {
        $sql = "UPDATE Pessoa SET nome=:nome, sexo=:sexo, nomePai=:nomePai, nomeMae=:nomeMae, 
                                  dataNascimento=:dataNascimento, telefone1=:telefone1, telefone2=:telefone2, telefone3=:telefone3, 
                                  cpf=:cpf, rg=:rg, rgEmissor=:rgEmissor, rgUF=:rgUF, passaporte=:passaporte, nacionalidade=:nacionalidade,
                                  email=:email, logradouro=:logradouro, numero=:numero, 
                                  complemento=:complemento, bairro=:bairro, municipioId=:municipioId, cep=:cep,
                                  numeroDizimo=:numeroDizimo, comunidadeId=:comunidadeId, observacoes=:observacoes, 
                                  batizado=:batizado, localBatismo=:localBatismo, dataBatismo=:dataBatismo, primeiraEucaristia=:primeiraEucaristia, 
                                  localPrimeiraEucaristia=:localPrimeiraEucaristia, dataPrimeiraEucaristia=:dataPrimeiraEucaristia, status=:status, 
                                  dataUltimaAlteracao=NOW(), usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId 
                WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->bindParam(":nome",$this->nome);
      $query->bindParam(":sexo",$this->sexo);
      $query->bindParam(":nomePai",$this->nomePai);
      $query->bindParam(":nomeMae",$this->nomeMae);
      $query->bindParam(":dataNascimento",$this->dataNascimento);
      $query->bindParam(":telefone1",$this->telefone1);
      $query->bindParam(":telefone2",$this->telefone2);
      $query->bindParam(":telefone3",$this->telefone3);
      $query->bindParam(":cpf",$this->cpf);
      $query->bindParam(":rg",$this->rg);
      $query->bindParam(":rgEmissor",$this->rgEmissor);
      $query->bindParam(":rgUF",$this->rgUF);
      $query->bindParam(":passaporte",$this->passaporte);
      $query->bindParam(":nacionalidade",$this->nacionalidade);
      $query->bindParam(":email",$this->email);
      $query->bindParam(":logradouro",$this->logradouro);
      $query->bindParam(":numero", $this->numero);
      $query->bindParam(":complemento", $this->complemento);
      $query->bindParam(":bairro", $this->bairro);
      $query->bindParam(":municipioId", $this->municipioId);
      $query->bindParam(":cep", $this->cep);
      $query->bindParam(":numeroDizimo", $this->numeroDizimo);
      $query->bindParam(":comunidadeId", $this->comunidadeId);
      $query->bindParam(":observacoes", $this->observacoes);
      $query->bindParam(":batizado", $this->batizado);
      $query->bindParam(":localBatismo", $this->localBatismo);
      $query->bindParam(":dataBatismo",$this->dataBatismo);
      $query->bindParam(":primeiraEucaristia", $this->primeiraEucaristia);
      $query->bindParam(":localPrimeiraEucaristia", $this->localPrimeiraEucaristia);
      $query->bindParam(":dataPrimeiraEucaristia", $this->dataPrimeiraEucaristia);
      $query->bindParam(":status",$this->status);
      //$query->bindParam(":dataUltimaAlteracao", $this->dataUltimaAlteracao);
      $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
      $query->execute();
      echo json_encode($this);
    }
    
    function deletePessoa()
    {
      //$sql = "DELETE FROM Pessoa WHERE id=:id";
      $sql = "UPDATE Pessoa SET status = 0 WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Pessoa apagada'}");
    }
}
?>