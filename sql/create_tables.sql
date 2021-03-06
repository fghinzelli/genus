CREATE DATABASE IF NOT EXISTS genus;

USE genus;


CREATE TABLE IF NOT EXISTS Estado (
    id       INT          NOT NULL AUTO_INCREMENT,
    codigoUf INT          NOT NULL,
    nome     VARCHAR (50) NOT NULL,
    uf       CHAR 	 (2)  NOT NULL,
    regiao   INT	      NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Municipio (
  id 	 INT 		  NOT NULL AUTO_INCREMENT,
  codigo INT		  NOT NULL,
  nome 	 VARCHAR(255) NOT NULL,
  uf	 CHAR(2)	  NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Diocese(
	id INT NOT NULL AUTO_INCREMENT,
	nome varchar(50) NOT NULL,
	cnpj varchar(14) NULL,
	email varchar(50) NULL,
	telefone varchar(15) NULL,
	logradouro varchar(50) NULL,
	numero varchar(10) NULL,
	complemento varchar(50) NULL,
	bairro varchar(20) NULL,
 	municipioId int(10) NULL,
	cep int(10) NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (municipioId) REFERENCES Municipio(id)
);

CREATE TABLE IF NOT EXISTS Paroquia(
	id INT NOT NULL AUTO_INCREMENT,
	nome varchar(50) NOT NULL,
	cnpj varchar(14) NULL,
	email varchar(50) NULL,
	telefone varchar(15) NULL,
	logradouro varchar(50) NULL,
	numero varchar(10) NULL,
	complemento varchar(50) NULL,
	bairro varchar(20) NULL,
 	municipioId int(10) NULL,
	cep int(10) NULL,
	dioceseId INT(10) NULL,
	status int(1) NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (dioceseId) REFERENCES Diocese(Id),
	FOREIGN KEY (municipioId) REFERENCES Municipio(id)
);

CREATE TABLE IF NOT EXISTS Comunidade (
	id int(11) NOT NULL AUTO_INCREMENT,
	nome varchar(50) NOT NULL,
	paroquiaId int(10) NULL,
	dataFundacao date,
	responsavelCatequese varchar(50) NULL,
	logradouro varchar(50) NULL,
	numero varchar(10) NULL,
	complemento varchar(50) NULL,
	bairro varchar(20) NULL,
 	municipioId int(10) NULL,
	cep int(10) NULL,
	email varchar(50) NULL,
	telefone varchar(15) NULL,
	telefone2 varchar(15) NULL,
	status int(1) NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (municipioId) REFERENCES Municipio(id),
	FOREIGN KEY (paroquiaId) REFERENCES Paroquia(id)
);

CREATE TABLE IF NOT EXISTS SituacaoDizimo (
	id int(11) NOT NULL AUTO_INCREMENT,
	descricao varchar(30) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS SituacaoInscricao (
	id int(11) NOT NULL AUTO_INCREMENT,
	descricao varchar(30) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Escola (
	id int(11) NOT NULL AUTO_INCREMENT,
	nome varchar(100) NOT NULL,
	email varchar(50) NULL,
	telefone varchar(15) NULL,
	pessoaContato varchar(30) NULL,
	observacoes varchar(50) NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS EtapaEscola (
	id int(11) NOT NULL AUTO_INCREMENT,
	descricao varchar(50) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS EtapaCatequese (
	id int(11) NOT NULL AUTO_INCREMENT,
	descricao varchar(50) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS AnoLetivoCatequese (
	id int(11) NOT NULL AUTO_INCREMENT,
	descricao varchar(50) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Turno (
	id int(11) NOT NULL AUTO_INCREMENT,
	descricao varchar(50) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Parentesco (
	id int(11) NOT NULL AUTO_INCREMENT,
	descricao varchar(50) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Pessoa (
	id int(11) NOT NULL AUTO_INCREMENT,
	nome varchar(70) NOT NULL,
	sexo char(1) NULL,
	nomePai varchar(50) NULL,
	nomeMae varchar(50) NULL,
	dataNascimento date NULL,
	telefone1 varchar(12) NULL,
	telefone2 varchar(12) NULL,
	telefone3 varchar(12) NULL,
	cpf varchar(11) NULL,
	rg varchar(15) NULL,
	rgEmissor varchar(10) NULL,
	rgUF char(2) NULL,
	passaporte char(2) NULL,
	nacionalidade varchar(30) NULL,
	email varchar(50) NULL,
	logradouro varchar(50) NULL,
	numero varchar(10) NULL,
	complemento varchar(50) NULL,
	bairro varchar(20) NULL,
 	municipioId int(10) NULL,
	cep int(8) NULL,
	numeroDizimo VARCHAR(20) NULL,
	comunidadeId int(10) NULL,
	observacoes varchar(50) NULL,
	batizado int(1) NULL,
	localBatismo varchar(150) NULL,
	dataBatismo date NULL,
	primeiraEucaristia int(1) NULL,
	localPrimeiraEucaristia varchar(150) NULL,
	dataPrimeiraEucaristia date NULL,
	status int(1) NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (municipioId) REFERENCES Municipio(id)
);

CREATE TABLE IF NOT EXISTS AcessoNivel (
	id int(11) NOT NULL AUTO_INCREMENT,
	descricao varchar(50) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Usuario (
	id int(11) NOT NULL AUTO_INCREMENT,
	username varchar(50) NOT NULL,
	senha varchar(255) NOT NULL,
	pessoaId int(10) NOT NULL,
	token CHAR(16) NULL,
	tokenExpiracao DATETIME NULL,
	status int(1) NOT NULL,
	paroquiaSelecionada int(10) NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (pessoaId) REFERENCES Pessoa(id),
	FOREIGN KEY (paroquiaSelecionada) REFERENCES Paroquia(id)
);

CREATE TABLE IF NOT EXISTS AcessoParoquia(
	id INT NOT NULL AUTO_INCREMENT,
	paroquiaId INT NOT NULL,
	usuarioId INT NOT NULL,
	nivelAcessoId int(10) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (paroquiaId) REFERENCES Paroquia(id),
	FOREIGN KEY (usuarioId) REFERENCES Usuario(id),
	FOREIGN KEY (nivelAcessoId) REFERENCES AcessoNivel(id)
);

CREATE TABLE IF NOT EXISTS Catequista (
	id int(11) NOT NULL AUTO_INCREMENT,
	pessoaId int(10) NOT NULL,
	comunidadeId INT NOT NULL,
	dataInicio date NULL,
	observacoes varchar(100) NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (comunidadeId) REFERENCES Comunidade(id),
	FOREIGN KEY (pessoaId) REFERENCES Pessoa(id)
);

CREATE TABLE IF NOT EXISTS Professor (
	id int(11) NOT NULL AUTO_INCREMENT,
	pessoaId int(10) NOT NULL,
	comunidadeId INT NOT NULL,
	dataInicio date NULL,
	observacoes varchar(100) NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (comunidadeId) REFERENCES Comunidade(id),
	FOREIGN KEY (pessoaId) REFERENCES Pessoa(id)
);

CREATE TABLE IF NOT EXISTS TurmaCatequese (
	id int(11) NOT NULL AUTO_INCREMENT,
	etapaCatequeseId int(10) NOT NULL,
	catequistaId int(10) NOT NULL,
	observacoes varchar(100) NULL,
	turnoId INT NOT NULL,
	diaSemana INT NOT NULL,
	dataInicio date NULL,
	dataTermino date NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	horario varchar(30) NOT NULL,
	comunidadeId INT NOT NULL,
	anoLetivoId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (catequistaId) REFERENCES Catequista(id),
	FOREIGN KEY (etapaCatequeseId) REFERENCES EtapaCatequese(id),
	FOREIGN KEY (comunidadeId) REFERENCES Comunidade(id),
	FOREIGN KEY (turnoId) REFERENCES Turno(id),
	FOREIGN KEY (anoLetivoId) REFERENCES AnoLetivoCatequese(id)
);

CREATE TABLE `InscricaoCatequese` (
	id int(11) NOT NULL AUTO_INCREMENT,,
	pessoaId int(10) NOT NULL,
	etapaCatequeseId int(10) DEFAULT NULL,
	escolaId int(11) DEFAULT NULL,
	turmaId int(11) DEFAULT NULL,
	etapaEscolaId int(11) DEFAULT NULL,
	observacoes varchar(100) DEFAULT NULL,
	situacaoInscricaoId int(11) DEFAULT NULL,
	comunidadeId int(11) DEFAULT NULL,
	dataInscricao date DEFAULT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime DEFAULT NULL,
	usuarioUltimaAlteracaoId int(11) DEFAULT NULL,
	anoLetivoId int(11) NOT NULL,
	livroPago int(1) NULL,
	inscricaoPaga int(1) NULL,
	inscricaoDataPagamento date NULL,
	nomePadrinho varchar(150) NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (pessoaId) REFERENCES Pessoa(id),
	FOREIGN KEY (etapaCatequeseId) REFERENCES EtapaCatequese(id),
	FOREIGN KEY (etapaEscolaId) REFERENCES EtapaEscola(id),
	FOREIGN KEY (comunidadeId) REFERENCES Comunidade(id),
	FOREIGN KEY (situacaoInscricaoId) REFERENCES SituacaoInscricao(id),
	FOREIGN KEY (escolaId) REFERENCES Escola(id),
	FOREIGN KEY (anoLetivoId) REFERENCES AnoLetivoCatequese(id)
);

CREATE TABLE IF NOT EXISTS ResponsavelInscricao (
	id int(11) NOT NULL AUTO_INCREMENT,
	pessoaResponsavelId int(10) NOT NULL,
	inscricaoCatequeseId int(10) NOT NULL,
	observacoes varchar(100) NOT NULL,
	parentescoId INT(10) NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (pessoaResponsavelId) REFERENCES Pessoa(id),
	FOREIGN KEY (inscricaoCatequeseId) REFERENCES InscricaoCatequese(id),
	FOREIGN KEY (parentescoId) REFERENCES Parentesco(id)
);

CREATE TABLE IF NOT EXISTS TurmaCatequeseInscricao (
	id int(11) NOT NULL AUTO_INCREMENT,
	inscricaoCatequeseId int(10) NOT NULL,
	turmaCatequeseId int(10) NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (inscricaoCatequeseId) REFERENCES InscricaoCatequese(id),
	FOREIGN KEY (turmaCatequeseId) REFERENCES TurmaCatequese(id)
);

CREATE TABLE IF NOT EXISTS Curso (
	id int(11) NOT NULL AUTO_INCREMENT,
	descricao varchar(50) NOT NULL,
	paroquiaId INT NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (paroquiaId) REFERENCES Paroquia(id)
);

CREATE TABLE IF NOT EXISTS SituacaoEdicaoCurso (
	id INT NOT NULL AUTO_INCREMENT,
	descricao varchar(50) NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS CursoEdicao (
	id INT NOT NULL AUTO_INCREMENT,
	cursoId INT NOT NULL,
	dataInicio date,
	dataConclusao date,
	diaSemana INT NOT NULL,
	turnoId INT NOT NULL,
	horario varchar(30) NULL,
	professorId INT NOT NULL,
	situacaoEdicaoCursoId INT NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (cursoId) REFERENCES Curso(id),
	FOREIGN KEY (turnoId) REFERENCES Turno(id),
	FOREIGN KEY (professorId) REFERENCES Professor(id),
	FOREIGN KEY (situacaoEdicaoCursoId) REFERENCES SituacaoEdicaoCurso(id)
);

CREATE TABLE IF NOT EXISTS InscricaoCurso (
	id int(11) NOT NULL AUTO_INCREMENT,
	pessoaId int(10) NOT NULL,
	cursoId int(10) NOT NULL,
	observacoes varchar(100) NOT NULL,
	situacao int(1) NOT NULL,
	paroquiaId INT NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (pessoaId) REFERENCES Pessoa(id),
	FOREIGN KEY (cursoId) REFERENCES Curso(id),
	FOREIGN KEY (paroquiaId) REFERENCES Paroquia(id)
);

CREATE TABLE IF NOT EXISTS TurmaCurso (
	id int(11) NOT NULL AUTO_INCREMENT,
	cursoId int(10) NOT NULL,
	professorId int(10) NOT NULL,
	observacoes varchar(100) NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (professorId) REFERENCES Professor(id),
	FOREIGN KEY (cursoId) REFERENCES Curso(id)
);

CREATE TABLE IF NOT EXISTS TurmaCursoInscricao (
	id int(11) NOT NULL AUTO_INCREMENT,
	inscricaoCursoId int(10) NOT NULL,
	turmaCursoId int(10) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (inscricaoCursoId) REFERENCES InscricaoCurso(id),
	FOREIGN KEY (turmaCursoId) REFERENCES TurmaCurso(id)
);

CREATE VIEW view_inscricoesCatequese_incluidas_em_turmas AS
	SELECT I.id, I.anoLetivoId FROM TurmaCatequeseInscricao TCI
	INNER JOIN InscricaoCatequese I ON I.id = TCI.inscricaoCatequeseId
	WHERE TCI.status = 1 AND I.status = 1
	ORDER BY I.id
	
