CREATE OR REPLACE VIEW ViewUsuario AS (
    SELECT 
        u.id,
        u.usuario,
        u.senha,
        p.nome
    FROM 
        usuario u 
        INNER JOIN pessoa p ON p.id = u.pessoaId
);
