-- Diocese
INSERT INTO `Diocese` (`id`, `nome`, `cnpj`, `email`, `telefone`, `logradouro`, `numero`, `complemento`, `bairro`, `municipioId`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) VALUES (NULL, 'Diocese de Caxias do Sul', '12345649687', 'diocese@diocese.com.br', NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '1');

-- Paroquia
INSERT INTO `Paroquia` (`id`, `nome`, `cnpj`, `email`, `telefone`, `logradouro`, `numero`, `complemento`, `bairro`, `municipioId`, `dioceseId`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) VALUES (NULL, 'Nossa Senhora Mãe de Deus', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL);

-- Comunidade
INSERT INTO `Comunidade` (`id`, `nome`, `padroeiro`, `paroquiaId`, `dataFuncacao`, `responsaveCatequese`, `logradouro`, `numero`, `complemento`, `bairro`, `municipioId`, `email`, `telefone`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) VALUES (NULL, 'Igreja Matriz Nossa Senhora Mãe de Deus', 'Nossa Senhora Mãe de Deus', '1', NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, '1', NULL, NULL);

-- Nivel de acesso
INSERT INTO `AcessoNivel` (`id`, `descricao`, `status`) VALUES (NULL, 'Administrador', '1');

-- Pessoa
INSERT INTO `Pessoa` (`id`, `nome`, `sexo`, `nomePai`, `nomeMae`, `dataNascimento`, `telefone1`, `telefone2`, `cpf`, `rg`, `email`, `logradouro`, `numero`, `complemento`, `bairro`, `municipioId`, `numeroDizimo`, `comunidadeId`, `observacoes`, `batizado`, `localBatismo`, `primeiraEucaristia`, `localPrimeiraEucaristia`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
VALUES 
(NULL, 'Fulano de Tal', 'M', 'Adão de Tal', 'Eva de Tal', '2017-08-14 00:00:00', NULL, NULL, NULL, NULL, 'fghinzelli@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
(NULL, 'Maria da Silva', 'F', 'Mario da Silva', 'Isabel da Silva', '2017-06-11 00:00:00', NULL, NULL, NULL, NULL, 'mariel@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
(NULL, 'Antônio de Jesus', 'M', 'João de Jesus', 'Marta de Jesus', '2017-08-14 00:00:00', NULL, NULL, NULL, NULL, 'fghinzelli@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
(NULL, 'Salete da Costa', 'F', 'Mario da Costa', 'Teresa da Costa', '2017-06-11 00:00:00', NULL, NULL, NULL, NULL, 'mariel@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
(NULL, 'Rafael Gonçalves', 'M', 'Jose Gonçalves', 'Lourdes Gonçalves', '2017-08-14 00:00:00', NULL, NULL, NULL, NULL, 'fghinzelli@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
(NULL, 'Simone da Cruz', 'F', 'Mario da Cruz', 'Salete da Cruz', '2017-06-11 00:00:00', NULL, NULL, NULL, NULL, 'mariel@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
(NULL, 'Gabriel da Costa', 'M', 'Douglas da Costa', 'Maria da Costa', '2017-08-14 00:00:00', NULL, NULL, NULL, NULL, 'fghinzelli@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL),
(NULL, 'Jéssica Antunes', 'F', 'Mario Antunes', 'Maria Antunes', '2017-06-11 00:00:00', NULL, NULL, NULL, NULL, 'mariel@gmail.com', NULL, NULL, NULL, NULL, NULL, '12345', 1,  NULL, 1, NULL, NULL, NULL, 1, NULL, NULL);


-- Usuario
INSERT INTO `Usuario` (`id`, `username`, `senha`, `pessoaId`, `token`, `tokenExpiracao`, `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) VALUES (NULL, 'fghinzelli', '$2y$10$K/V0l5OwEQH59sZiNLoG4eRWAhcGIgHgDiR2/tVNeWvJRNEGFmwDO', 1, '07d5ccaeb0da5486', '2017-10-31 03:23:13', 1, NULL, NULL);

-- AcessoParoquia 
INSERT INTO `AcessoParoquia` (`id`, `paroquiaId`, `usuarioId`, `nivelAcessoId`) VALUES (NULL, '1', '1', '1');