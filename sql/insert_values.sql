-- Nivel de acesso
INSERT INTO `NivelAcesso` (`id`, `descricao`, `status`) VALUES (NULL, 'Administrador', '1');

-- Pessoa
INSERT INTO `Pessoa` (`id`, `nome`, `sexo`, `dataNascimento`, `telefone1`, `telefone2`, `cpf`, `rg`, `email`, `logradouro`, `numero`, `complemento`, `bairro`, `municipioId`, `dataCadastramento`, `status`) VALUES (NULL, 'Fernando Ghinzelli', 'M', '2017-08-14 00:00:00', NULL, NULL, NULL, NULL, 'fghinzelli@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1');

-- Usuario
INSERT INTO `Usuario` (`id`, `usuario`, `senha`, `pessoaId`, `nivelAcessoId`, `status`) VALUES (NULL, 'fghinzelli', '827ccb0eea8a706c4c34a16891f84e7b', '1', '1', '1');
