CREATE DATABASE IF NOT EXISTS genus;

USE genus;

CREATE TABLE IF NOT EXISTS Estado (
    Id       INT          NOT NULL AUTO_INCREMENT,
    CodigoUf INT          NOT NULL,
    Nome     VARCHAR (50) NOT NULL,
    Uf       CHAR 	 (2)  NOT NULL,
    Regiao   INT	      NOT NULL,
    PRIMARY KEY (Id)
);

CREATE TABLE IF NOT EXISTS Municipio (
  Id 	 INT 		  NOT NULL AUTO_INCREMENT,
  Codigo INT		  NOT NULL,
  Nome 	 VARCHAR(255) NOT NULL,
  Uf	 CHAR(2)	  NOT NULL,
  PRIMARY KEY (Id)
);

CREATE TABLE IF NOT EXISTS Comunidade (
	Id int(11) NOT NULL AUTO_INCREMENT,
	Nome varchar(50) NOT NULL,
	Status int(1) NOT NULL,
	PRIMARY KEY (Id)
);

CREATE TABLE IF NOT EXISTS Escola (
	Id int(11) NOT NULL AUTO_INCREMENT,
	Nome varchar(50) NOT NULL,
	Status int(1) NOT NULL,
	PRIMARY KEY (Id)
);

CREATE TABLE IF NOT EXISTS EtapaCatequese (
	Id int(11) NOT NULL AUTO_INCREMENT,
	Descricao varchar(50) NOT NULL,
	Status int(1) NOT NULL,
	PRIMARY KEY (Id)
);

CREATE TABLE IF NOT EXISTS Pessoa (
	Id int(11) NOT NULL AUTO_INCREMENT,
	Nome varchar(70) NOT NULL,
	DataNascimento datetime NOT NULL,
	Telefone1 varchar(12) NULL,
	Telefone2 varchar(12) NULL,
	cpf varchar(11) NULL,
	rg varchar(15) NULL,
	Email varchar(50) NOT NULL,
	Logradouro varchar(50) NULL,
	Numero varchar(10) NULL,
	Complemento varchar(50) NULL,
	Bairro varchar(20) NULL,
 	MunicipioId int(10) NULL,
	DataCadastramento datetime,
	Status int(1) NOT NULL,
	PRIMARY KEY (Id),
	FOREIGN KEY (MunicipioId) REFERENCES Municipio(Id)
);

CREATE TABLE IF NOT EXISTS NivelAcesso (
	Id int(11) NOT NULL AUTO_INCREMENT,
	Descricao varchar(50) NOT NULL,
	Status int(1) NOT NULL,
	PRIMARY KEY (Id)
);

CREATE TABLE IF NOT EXISTS Usuario (
	Id int(11) NOT NULL AUTO_INCREMENT,
	Usuario varchar(50) NOT NULL,
	Senha varchar(50) NOT NULL,
	PessoaId int(10) NOT NULL,
	NivelAcessoId int(10) NOT NULL,
	Status int(1) NOT NULL,
	PRIMARY KEY (Id),
	FOREIGN KEY (PessoaId) REFERENCES Pessoa(Id),
	FOREIGN KEY (NivelAcessoId) REFERENCES NivelAcesso(Id)
);

CREATE TABLE IF NOT EXISTS Professor (
	Id int(11) NOT NULL AUTO_INCREMENT,
	PessoaId int(10) NOT NULL,
	Observacoes varchar(100) NOT NULL,
	Status int(1) NOT NULL,
	DataInicio datetime NULL,
	PRIMARY KEY (Id),
	FOREIGN KEY (PessoaId) REFERENCES Pessoa(Id)
);

CREATE TABLE IF NOT EXISTS Aluno (
	Id int(11) NOT NULL AUTO_INCREMENT,
	PessoaId int(10) NOT NULL,
	Observacoes varchar(100) NOT NULL,
	Status int(1) NOT NULL,
	DataCadastramento datetime,
	PRIMARY KEY (Id),
	FOREIGN KEY (PessoaId) REFERENCES Pessoa(Id)
);

CREATE TABLE IF NOT EXISTS ResponsavelAluno (
	Id int(11) NOT NULL AUTO_INCREMENT,
	PessoaResponsavelId int(10) NOT NULL,
	AlunoId int(10) NOT NULL,
	Observacoes varchar(100) NOT NULL,
	Status int(1) NOT NULL,
	DataCadastramento datetime,
	PRIMARY KEY (Id),
	FOREIGN KEY (PessoaResponsavelId) REFERENCES Pessoa(Id),
	FOREIGN KEY (AlunoId) REFERENCES Aluno(Id)
);

CREATE TABLE IF NOT EXISTS InscricaoCatequese (
	Id int(11) NOT NULL AUTO_INCREMENT,
	AlunoId int(10) NOT NULL,
	EtapaCatequeseId int(10) NOT NULL,
	Observacoes varchar(100) NOT NULL,
	Situacao int(1) NOT NULL,
	Status int(1) NOT NULL,
	DataCadastramento datetime,
	PRIMARY KEY (Id),
	FOREIGN KEY (AlunoId) REFERENCES Aluno(Id),
	FOREIGN KEY (EtapaCatequeseId) REFERENCES EtapaCatequese(Id)
);

CREATE TABLE IF NOT EXISTS TurmaCatequese (
	Id int(11) NOT NULL AUTO_INCREMENT,
	EtapaCatequeseId int(10) NOT NULL,
	ProfessorId int(10) NOT NULL,
	Observacoes varchar(100) NOT NULL,
	Status int(1) NOT NULL,
	DataCadastramento datetime,
	PRIMARY KEY (Id),
	FOREIGN KEY (ProfessorId) REFERENCES Professor(Id),
	FOREIGN KEY (EtapaCatequeseId) REFERENCES EtapaCatequese(Id)
);

CREATE TABLE IF NOT EXISTS TurmaCatequeseAluno (
	Id int(11) NOT NULL AUTO_INCREMENT,
	InscricaoCatequeseId int(10) NOT NULL,
	TurmaCatequeseId int(10) NOT NULL,
	Status int(1) NOT NULL,
	PRIMARY KEY (Id),
	FOREIGN KEY (InscricaoCatequeseId) REFERENCES InscricaoCatequese(Id),
	FOREIGN KEY (TurmaCatequeseId) REFERENCES TurmaCatequese(Id)
);

CREATE TABLE IF NOT EXISTS Curso (
	Id int(11) NOT NULL AUTO_INCREMENT,
	Descricao varchar(50) NOT NULL,
	Status int(1) NOT NULL,
	PRIMARY KEY (Id)
);

CREATE TABLE IF NOT EXISTS InscricaoCurso (
	Id int(11) NOT NULL AUTO_INCREMENT,
	AlunoId int(10) NOT NULL,
	CursoId int(10) NOT NULL,
	Observacoes varchar(100) NOT NULL,
	Situacao int(1) NOT NULL,
	Status int(1) NOT NULL,
	DataCadastramento datetime,
	PRIMARY KEY (Id),
	FOREIGN KEY (AlunoId) REFERENCES Aluno(Id),
	FOREIGN KEY (CursoId) REFERENCES Curso(Id)
);

CREATE TABLE IF NOT EXISTS TurmaCurso (
	Id int(11) NOT NULL AUTO_INCREMENT,
	CursoId int(10) NOT NULL,
	ProfessorId int(10) NOT NULL,
	Observacoes varchar(100) NOT NULL,
	Status int(1) NOT NULL,
	DataCadastramento datetime,
	PRIMARY KEY (Id),
	FOREIGN KEY (ProfessorId) REFERENCES Professor(Id),
	FOREIGN KEY (CursoId) REFERENCES Curso(Id)
);

CREATE TABLE IF NOT EXISTS TurmaCursoAluno (
	Id int(11) NOT NULL AUTO_INCREMENT,
	InscricaoCursoId int(10) NOT NULL,
	TurmaCursoId int(10) NOT NULL,
	Status int(1) NOT NULL,
	PRIMARY KEY (Id),
	FOREIGN KEY (InscricaoCursoId) REFERENCES InscricaoCurso(Id),
	FOREIGN KEY (TurmaCursoId) REFERENCES TurmaCurso(Id)
);


	
