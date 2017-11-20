<?php
    class Usuario {
        private $db;
        public $id;
        public $username;
        public $senha;
        public $pessoaId;
        public $token;
        public $tokenExpiracao;
        public $status;
        public $paroquiaSelecionada;
        public $dataUltimaAlteracao;
        public $usuarioUltimaAlteracaoId;
        
        function __construct($db) {
            $this->db = $db;
        }

        function loadData($id, $username, $senha, $pessoaId, $token, $tokenExpiracao,  
        $status, $paroquiaSelecionada, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
        $this->id = $id;
        $this->username = $username;
        $this->senha = $senha;
        $this->pessoaId = $pessoaId;
        $this->token = $token;
        $this->tokenExpiracao = $tokenExpiracao;
        $this->status = $status;
        $this->paroquiaSelecionada = $paroquiaSelecionada;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
        }

        function getUsuarios() {
        $sql = "SELECT U.* FROM Usuario U INNER JOIN Pessoa P ON U.pessoaId = P.id ORDER BY P.nome;";
        $query = $this->db->query($sql);
        $usuarios = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($usuarios as $usuario) {
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $this->db->prepare($sqlp);
            $queryp->bindParam("id",$usuario->pessoaId);
            $queryp->execute();
            $usuario->pessoa =  $queryp->fetchObject();
            // PAROQUIA SELECIONADA
            $sqlpa = "SELECT * FROM Paroquia WHERE id=:id";
            $querypa = $this->db->prepare($sqlpa);
            $querypa->bindParam("id",$usuario->paroquiaSelecionada);
            $querypa->execute();
            $usuario->paroquia =  $querypa->fetchObject();
        }
        echo json_encode($usuarios);
        }

        function getUsuario($id) {
          $sql = "SELECT * FROM Usuario WHERE id=:id";
          $query = $this->db->prepare($sql);
          $query->bindParam("id", $id);
          $query->execute();
          $usuario = $query->fetchObject();
    
          // PESSOA
          $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
          $queryp = $this->db->prepare($sqlp);
          $queryp->bindParam("id",$usuario->pessoaId);
          $queryp->execute();
          $usuario->pessoa =  $queryp->fetchObject();
    
          // PAROQUIA
          $sqlpa = "SELECT * FROM Paroquia WHERE id=:id";
          $querypa = $this->db->prepare($sqlpa);
          $querypa->bindParam("id",$paroquia->paroquiaSelecionada);
          $querypa->execute();
          $usuario->paroquia =  $querypa->fetchObject();
          
          echo json_encode($usuario);
        }

        function checkUser($username, $senha) {
            // Se o usuario existir, retorna sua senha (hash)
            $dbPasswordHash = $this->getUserHash($username)['senha'];
            if($dbPasswordHash === false) return false;
            // Testa se a senha é valida
            $validPassword = $this->isValidPassword($senha, $dbPasswordHash);
            if($validPassword === false) return false;
            // Retorna um array com os dados
            $token = bin2hex(openssl_random_pseudo_bytes(8)); // Gera um token aleatorio
            $arrayRetorno['username'] = $username;
            $arrayRetorno['token'] = $token;
            // Atualiza o token no registro do usuario
            $this->updateUserToken($username, $token);
            echo json_encode($arrayRetorno);
        }

        function userExists($username) {
            // Testa se ja existe o username 
            $sql = "SELECT username
                    FROM Usuario
                    WHERE username = :username";
            $query = $this->db->prepare($sql);
            $query->bindParam(':username', $username);
            $query->execute();
            return $query->rowCount() > 0;
        }

        function isValidToken($token) {
            // Verifica se o token é valido
            $sql = "SELECT username 
                    FROM Usuario 
                    WHERE token = :token"; //AND TIMESTAMPDIFF(MINUTE, tokenExpiracao, CURRENT_TIMESTAMP) < 30";
            $query = $this->db->prepare($sql);
            $query->bindParam(':token', $token, PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0) {
                $this->updateExpirateToken($token);
                return true;
            } else {
                return false;
            }
        }

        function getByToken($token) {
            $sql = "SELECT username 
                    FROM Usuario 
                    WHERE token = :token AND TIMESTAMPDIFF(MINUTE, tokenExpiracao, CURRENT_TIMESTAMP) < 30";
            $query = $this->db->prepare($sql);
            $query->bindParam(':token', $token);
            $query->execute();
            $this->username = $query->fetch(PDO::FETCH_ASSOC)['username'];
        }

        private function getUserHash($username) {
            // Verifica se a combinacao usuario senha existe
            $sql = "SELECT senha FROM Usuario WHERE username = :username";
            $query = $this->db->prepare($sql);
            $query->bindParam(':username', $username);
            $query->execute();
            if($query->rowCount() === 0) return false;
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        function updateUserToken($username, $token) {
            $tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $sql = "UPDATE Usuario SET token = :token, tokenExpiracao = :tokenExpiracao WHERE username = :username";
			$query = $this->db->prepare($sql);
			$query->bindParam(":username", $username);
			$query->bindParam(":token", $token);
			$query->bindParam(":tokenExpiracao", $tokenExpiration);
			$query->execute();
        }

        function updateExpirateToken($token) {
            $tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $sql = "UPDATE Usuario SET token = :token, tokenExpiracao = :tokenExpiracao WHERE token = :token";
			$query = $this->db->prepare($sql);
			$query->bindParam("token", $token);
			$query->bindParam("tokenExpiracao", $tokenExpiration);
			$query->execute();
        }
        
        function getHash($senha) {
            // gera um hash da senha do usuario
            return password_hash($password, PASSWORD_DEFAULT);
        }

        private function isValidPassword($senha, $dbPasswordHash) {
            // Verifica se a senha informada é valida
            return password_verify($senha, $dbPasswordHash);
        }

        
        function addUser($username, $senha, $pessoaId, $status, $usuarioAlteracao) {
            // Adiciona um novo registro de usuario se o username ainda não existir
            if ($this->userExists($username)) return false;
            $hashedPassword = $this->getHash($senha);
            return $this->insertUser($username, $hashedPassword, $pessoaId, $status, $usuarioAlteracao);
        }

        function addUsuario() {
            $sql = "INSERT INTO Usuario (`username`, `senha`, `pessoaId`, `token`, `tokenExpiracao`, 
                                        `status`, `paroquiaSelecionada`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
                    VALUES (:username, :senha, :pessoaId, :token, :tokenExpiracao, :status, :paroquiaSelecionada, NOW(), :usuarioUltimaAlteracaoId)";
            $query = $this->db->prepare($sql);
            $query->bindParam(":username",$this->username);
            $query->bindParam(":senha",$this->senha);
            $query->bindParam(":pessoaId",$this->pessoaId);
            $query->bindParam(":token",$this->token);
            $query->bindParam(":tokenExpiracao",$this->tokenExpiracao);
            $query->bindParam(":status",$this->status);
            $query->bindParam(":paroquiaSelecionada",$this->paroquiaSelecionada);
            $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
            $query->execute();
            $this->id = $this->db->lastInsertId();
            echo json_encode($this);
        }


        function saveUsuario()
        {
            $sql = "UPDATE Usuario SET username=:username, senha=:senha, pessoaId=:pessoaId, token=:token, tokenExpiracao=:tokenExpiracao, 
                                      status=:status, paroquiaSelecionada=:paroquiaSelecionada, dataUltimaAlteracao=NOW(), usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId 
                    WHERE id=:id";
          $query = $this->db->prepare($sql);
          $query->bindParam(":id",$this->id);
          $query->bindParam(":username",$this->username);
          $query->bindParam(":senha",$this->senha);
          $query->bindParam(":pessoaId",$this->pessoaId);
          $query->bindParam(":token",$this->token);
          $query->bindParam(":tokenExpiracao",$this->tokenExpiracao);
          $query->bindParam(":status",$this->status);
          $query->bindParam(":paroquiaSelecionada",$this->paroquiaSelecionada);
          $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
          $query->execute();
          echo json_encode($this);
        }
        
        function deleteUsuario()
        {
          $sql = "DELETE FROM Usuario WHERE id=:id";
          $query = $this->db->prepare($sql);
          $query->bindParam(":id",$this->id);
          $query->execute();
          echo json_encode("{'message': 'Usuario apagado'}");
        }

    }
?>