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
	cnpj varchar(14) NOT NULL,
	email varchar(50) NOT NULL,
	telefone varchar(15) NULL,
	logradouro varchar(50) NULL,
	numero varchar(10) NULL,
	complemento varchar(50) NULL,
	bairro varchar(20) NULL,
 	municipioId int(10) NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Paroquia(
	id INT NOT NULL AUTO_INCREMENT,
	nome varchar(50) NOT NULL,
	cnpj varchar(14) NOT NULL,
	email varchar(50) NOT NULL,
	telefone varchar(15) NULL,
	logradouro varchar(50) NULL,
	numero varchar(10) NULL,
	complemento varchar(50) NULL,
	bairro varchar(20) NULL,
 	municipioId int(10) NULL,
	dioceseId INT(10) NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (dioceseId) REFERENCES Diocese(Id)
);

CREATE TABLE IF NOT EXISTS Comunidade (
	id int(11) NOT NULL AUTO_INCREMENT,
	nome varchar(50) NOT NULL,
	padroeiro varchar(50) NULL,
	paroquiaId int(10) NOT NULL,
	dataFuncacao datetime,
	responsaveCatequese varchar(50) NULL,
	logradouro varchar(50) NULL,
	numero varchar(10) NULL,
	complemento varchar(50) NULL,
	bairro varchar(20) NULL,
 	municipioId int(10) NULL,
	email varchar(50) NOT NULL,
	telefone varchar(15) NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS SituacaoDizimo (
	id int(11) NOT NULL AUTO_INCREMENT,
	descricao varchar(30) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Escola (
	id int(11) NOT NULL AUTO_INCREMENT,
	nome varchar(50) NOT NULL,
	email varchar(50) NOT NULL,
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

CREATE TABLE IF NOT EXISTS Turno (
	id int(11) NOT NULL AUTO_INCREMENT,
	descricao varchar(50) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Pessoa (
	id int(11) NOT NULL AUTO_INCREMENT,
	nome varchar(70) NOT NULL,
	sexo char(1) NOT NULL,
	nomePai varchar(50) NULL,
	nomeMae varchar(50) NULL,
	dataNascimento datetime NOT NULL,
	telefone1 varchar(12) NULL,
	telefone2 varchar(12) NULL,
	cpf varchar(11) NULL,
	rg varchar(15) NULL,
	email varchar(50) NOT NULL,
	logradouro varchar(50) NULL,
	numero varchar(10) NULL,
	complemento varchar(50) NULL,
	bairro varchar(20) NULL,
 	municipioId int(10) NULL,
	numeroDizimo INT NULL,
	comunidadeId int(10) NOT NULL,
	observacoes varchar(50) NOT NULL,
	batizado int(1) NOT NULL,
	localBatismo varchar(30) NULL,
	primeiraEucaristia int(1) NOT NULL,
	localEucaristia varchar(30) NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
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
	usuario varchar(50) NOT NULL,
	senha varchar(50) NOT NULL,
	pessoaId int(10) NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (pessoaId) REFERENCES Pessoa(id)
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

CREATE TABLE IF NOT EXISTS Professor (
	id int(11) NOT NULL AUTO_INCREMENT,
	pessoaId int(10) NOT NULL,
	comunidadeId INT NOT NULL,
	dataInicio datetime NULL,
	observacoes varchar(100) NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (comunidadeId) REFERENCES Comunidade(id),
	FOREIGN KEY (pessoaId) REFERENCES Pessoa(id)
);

CREATE TABLE IF NOT EXISTS Aluno (
	id int(11) NOT NULL AUTO_INCREMENT,
	pessoaId int(10) NOT NULL,
	observacoes varchar(100) NOT NULL,
	escolaId INT NULL,
	etapaEscolaId INT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (pessoaId) REFERENCES Pessoa(id),
	FOREIGN KEY (escolaId) REFERENCES Escola(id),
	FOREIGN KEY (etapaEscolaId) REFERENCES EtapaEscola(id)
);

CREATE TABLE IF NOT EXISTS ResponsavelAluno (
	id int(11) NOT NULL AUTO_INCREMENT,
	pessoaResponsavelId int(10) NOT NULL,
	alunoId int(10) NOT NULL,
	observacoes varchar(100) NOT NULL,
	relacao INT(10) NOT NULL, 
	PRIMARY KEY (id),
	FOREIGN KEY (pessoaResponsavelId) REFERENCES Pessoa(id),
	FOREIGN KEY (alunoId) REFERENCES Aluno(id)
);

CREATE TABLE IF NOT EXISTS InscricaoCatequese (
	id int(11) NOT NULL AUTO_INCREMENT,
	alunoId int(10) NOT NULL,
	etapaCatequeseId int(10) NOT NULL,
	observacoes varchar(100) NOT NULL,
	situacaoInscricaoId INT NOT NULL,
	turnoId INT NOT NULL,
	paroquiaId INT NOT NULL,
	situacaoDizimoId INT NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (alunoId) REFERENCES Aluno(id),
	FOREIGN KEY (etapaCatequeseId) REFERENCES EtapaCatequese(id),
	FOREIGN KEY (paroquiaId) REFERENCES Paroquia(id),
	FOREIGN KEY (situacaoDizimoId) REFERENCES SituacaoDizimo(id),
	FOREIGN KEY (turnoId) REFERENCES Turno(id)
);

CREATE TABLE IF NOT EXISTS TurmaCatequese (
	id int(11) NOT NULL AUTO_INCREMENT,
	etapaCatequeseId int(10) NOT NULL,
	professorId int(10) NOT NULL,
	observacoes varchar(100) NOT NULL,
	turnoId INT NOT NULL,
	diaSemana INT NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
	horario varchar(30) NOT NULL,
	paroquiaId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (professorId) REFERENCES Professor(id),
	FOREIGN KEY (etapaCatequeseId) REFERENCES EtapaCatequese(id),
	FOREIGN KEY (paroquiaId) REFERENCES Paroquia(id),
	FOREIGN KEY (turnoId) REFERENCES Turno(id)
);

CREATE TABLE IF NOT EXISTS TurmaCatequeseAluno (
	id int(11) NOT NULL AUTO_INCREMENT,
	inscricaoCatequeseId int(10) NOT NULL,
	turmaCatequeseId int(10) NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
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
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (paroquiaId) REFERENCES Paroquia(id)
);

CREATE TABLE IF NOT EXISTS SituacaoEdicaoCurso (
	id INT NOT NULL AUTO_INCREMENT,
	descricao varchar(50) NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS CursoEdicao (
	id INT NOT NULL AUTO_INCREMENT,
	cursoId INT NOT NULL,
	dataInicio datetime,
	dataConclusao datetime,
	diaSemana INT NOT NULL,
	turnoId INT NOT NULL,
	horario varchar(30) NULL,
	professorId INT NOT NULL,
	situacaoEdicaoCursoId INT NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (cursoId) REFERENCES Curso(id),
	FOREIGN KEY (turnoId) REFERENCES Turno(id),
	FOREIGN KEY (professorId) REFERENCES Professor(id),
	FOREIGN KEY (situacaoEdicaoCursoId) REFERENCES SituacaoEdicaoCurso(id)
);

CREATE TABLE IF NOT EXISTS InscricaoCurso (
	id int(11) NOT NULL AUTO_INCREMENT,
	alunoId int(10) NOT NULL,
	cursoId int(10) NOT NULL,
	observacoes varchar(100) NOT NULL,
	situacao int(1) NOT NULL,
	paroquiaId INT NOT NULL,
	status int(1) NOT NULL,
	dataUltimaAlteracao datetime,
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (alunoId) REFERENCES Aluno(id),
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
	usuarioUltimaAlteracaoId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (professorId) REFERENCES Professor(id),
	FOREIGN KEY (cursoId) REFERENCES Curso(id)
);

CREATE TABLE IF NOT EXISTS TurmaCursoAluno (
	id int(11) NOT NULL AUTO_INCREMENT,
	inscricaoCursoId int(10) NOT NULL,
	turmaCursoId int(10) NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (inscricaoCursoId) REFERENCES InscricaoCurso(id),
	FOREIGN KEY (turmaCursoId) REFERENCES TurmaCurso(id)
);


	
