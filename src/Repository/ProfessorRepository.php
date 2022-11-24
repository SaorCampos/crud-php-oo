<?php
declare(strict_types=1);
namespace App\Repository;
class ProfessorRepository implements RepositoryInterface
{
    public function buscarTodos(): iterable
    {
        return [];
    }
    public function buscarUm(string $id): ?object
    {
        return new \stdClass();
    }
    public function atualizar(object $dados, string $id): object
    {
        return $dados;
    }
    public function excluir(string $id): void
    {
        
    }
    public function inserir(object $dados): object
    {
        return $dados;
    }
}