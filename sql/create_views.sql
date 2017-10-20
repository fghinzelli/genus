CREATE OR REPLACE VIEW ViewUsuario AS (
    SELECT 
        u.id,
        u.usuario,
        u.senha,
        p.nome
    FROM 
        Usuario u 
        INNER JOIN Pessoa p ON p.id = u.pessoaId
);
