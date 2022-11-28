<?php
declare(strict_types=1);
namespace App\Repository;

use App\Connection\DatabaseConnection;
use App\Model\Categoria;
use App\Model\Curso;
use PDO;

class CursoRepository implements RepositoryInterface
{
    public const TABLE = 'tb_cursos';
    public PDO $pdo;
    public function __construct()
    {
        $this->pdo = DatabaseConnection::abrirConexao();
    }
    public function buscarTodos(): iterable
    {
        $sql = 'SELECT * FROM '.self::TABLE.' INNER JOIN tb_categoria on tb_cursos.categoria = tb_categoria.id';
        $query = $this->pdo->query($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public function buscarUm(string $id): object
    {
        $sql = "SELECT * FROM ".self::TABLE." INNER JOIN tb_categoria on tb_cursos.categoria = tb_categoria.id WHERE tb_cursos.id ='{$id}'";
        $query = $this->pdo->query($sql);
        $query->execute();
        return $query->fetchObject(Curso::class);
    }
    public function inserir(object $dados): object
    {
        $sql = "INSERT INTO ".self::TABLE ."(nome, cargaHoraria, descricao, status, categoria) "."VALUES ('{$dados->nome}', '{$dados->cargaHoraria}', '{$dados->descricao}', '1', '{$dados->pegarIdCategoria()}' );";
        $this->pdo->query($sql);
        return $dados;
    }
    public function atualizar(object $novosDados, string $id): object
    {
        $sql = "UPDATE ".self::TABLE." SET
            nome='{$novosDados->nome}',
            cargaHoraria='{$novosDados->cargaHoraria}',
            descricao='{$novosDados->descricao}',
            categoria='{$novosDados->pegarIdCategoria()}'
            WHERE id = '{$id}';";
        $this->pdo->query($sql);
        return $novosDados;
    }
    public function excluir(string $id): void
    {
        $sql = "DELETE FROM ".self::TABLE." WHERE id = '{$id}'";
        $query = $this->pdo->query($sql);
        $query->execute();
    }
    
}