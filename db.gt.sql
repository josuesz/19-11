CREATE DATABASE gerenciamento_tarefas;

USE gerenciamento_tarefas;

-- Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de tarefas
CREATE TABLE tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    descricao TEXT NOT NULL,
    status ENUM('pendente', 'concluída') DEFAULT 'pendente',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
SELECT * FROM usuarios WHERE email = 'josuemamacedo@gmail.com';

select*from usuarios ;
drop table usuarios;

alter table usuarios ad
insert into usuarios (nome,email, senha)
VALUES("Mamador"," josuemamacedo1@gmail.com", "Galo");

ALTER TABLE usuarios ADD COLUMN tipo ENUM('admin', 'usuario') DEFAULT 'usuario';
