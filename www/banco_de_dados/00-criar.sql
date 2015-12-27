CREATE TABLE livro (
       titulo TEXT,
       autor TEXT,
       editora TEXT,
       edicao INTEGER,
       exemplares INTEGER,
       aquisicao INTEGER,
       observacoes TEXT
);

CREATE TABLE usuario (
       nome TEXT,
       endereco TEXT,
       telefone TEXT,
       observacoes TEXT
);

CREATE TABLE emprestimo (
       usuario INTEGER,
       livro INTEGER,
       dia INTEGER
);