CREATE OR REPLACE VIEW ViewUsuario AS (
    SELECT 
        u.Id,
        u.Usuario,
        u.Senha,
        p.Nome
    FROM 
        Usuario u 
        INNER JOIN Pessoa p ON p.Id = u.PessoaId
);