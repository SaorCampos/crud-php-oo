CREATE DATABASE db_escola;
USE db_escola;
CREATE TABLE tb_alunos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    matricula VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    status TINYINT NOT NULL,
    genero VARCHAR(20) NOT NULL,
    dataNascimento DATETIME NOT NULL,
    cpf CHAR(11) UNIQUE NOT NULL
);
INSERT INTO tb_alunos
(nome, matricula, email, status, genero, dataNascimento, cpf)
VALUES
('Maria', '1234123', 'maria@email.com', true, 'Feminino', '2001-09-12', '12345678901');
CREATE TABLE tb_professores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    horarioDisponivel VARCHAR(100) NOT NULL,
    endereço VARCHAR(100) NOT NULL,
    status TINYINT NOT NULL,
    formação VARCHAR(50),
    cpf CHAR(11) UNIQUE NOT NULL
);
INSERT INTO tb_professores
(nome, horarioDisponivel, endereço, status, formação, cpf)
VALUES
('Alessandro', 'todo dia pela manhã', 'rua barca velha, 69', true, 'raw raw raw', '21345678901'),
('Gleidson(Lorão)', 'todo dia', 'alameda dos anjos,  45', true, 'Rapaz...','31245678901'),
('Allan', 'sabado', 'rua Idelfonso Albano,  222, ap 1403', true, 'Chuchu, Cachorro e Saboroso', '41235678901');
CREATE TABLE tb_cursos (
id INT PRIMARY KEY auto_increment,
nome varchar(100) NOT NULL UNIQUE,
cargaHoraria INT(3) NOT NULL,
descricao varchar(100) NOT NULL,
status TINYINT NOT NULL,
ementa varchar(255) NOT NULL
);