<?php
declare(strict_types=1);
use DateTime;
// aqui vai ficar a definição do caminho até essa classe
class Aluno
{
    public string $nome;
    public string $cpf;
    public DateTime $dataNascimento;
    public int $matricula;
    public bool $status;
    public string $genero; //enum
}