CREATE DATABASE IF NOT EXISTS db_escola;
USE db_escola;
CREATE TABLE tb_alunos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    matricula VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    status TINYINT NOT NULL,
    genero VARCHAR(20),
    dataNascimento DATETIME NOT NULL,
    cpf CHAR(11) UNIQUE NOT NULL
);
CREATE TABLE tb_professores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(100) NOT NULL,
    status TINYINT NOT NULL,
    formacao VARCHAR(50),
    cpf CHAR(11) UNIQUE NOT NULL
);
CREATE TABLE tb_categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL
);
CREATE TABLE tb_cursos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    cargaHoraria VARCHAR(50) NOT NULL,
    descricao VARCHAR(100) UNIQUE NOT NULL,
    status TINYINT NOT NULL,
    categoria_id INT NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES tb_categorias(id)
);
CREATE TABLE tb_usuario (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(75) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil VARCHAR(50) NOT NULL
);
INSERT INTO tb_usuario 
(id, nome, email, senha, perfil) 
VALUES
('1', 'admin', 'admin@admin.com', '$argon2i$v=19$m=65536,t=4,p=1$aTUxOC5udGNOL21KM29tNA$jiqG0IfXRvBAI+xhK6pSrlnTXqvVF8WyBlD4hXn4dEY', 'admin');
SELECT * FROM tb_cursos INNER JOIN tb_categoria ON tb_cursos.categoria = tb_categoria.id;