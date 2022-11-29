<?php
declare(strict_types=1);
namespace App\Repository;

use App\Connection\DatabaseConnection;
use App\Model\Categoria;
use App\Model\Curso;
use PDO;
use stdClass;

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
        $conexao = DatabaseConnection::abrirConexao();
        $sql = "SELECT 
                    tb_cursos.id as curso_id,
                    tb_cursos.nome as curso_nome,
                    tb_cursos.descricao as curso_descricao,
                    tb_cursos.cargaHoraria as curso_carga_horaria,
                    tb_cursos.status as curso_status,
                    tb_categoria.id as categoria,
                    tb_categoria.nome as categoria_nome 
                    FROM ".self::TABLE." INNER JOIN tb_categoria ON tb_cursos.categoria = tb_categoria.id WHERE tb_cursos.id = '{$id}'";
        $query = $conexao->query($sql);
        $query->execute();
        $result = $query->fetch();
        $curso = new Curso();
        $curso->id = $result["curso_id"];
        $curso->nome = $result["curso_nome"];
        $curso->descricao = $result["curso_descricao"];
        $curso->cargaHoraria = $result["curso_carga_horaria"];
        $curso->categoria = intval($result["categoria"]);
        var_dump($curso);
        return $curso;
    }
    public function inserir(object $dados): object
    {
        $sql = "INSERT INTO ".self::TABLE ."(nome, cargaHoraria, descricao, status, categoria) "."VALUES ('{$dados->nome}', '{$dados->cargaHoraria}', '{$dados->descricao}', '1', '{$dados->pegarIdCategoria()}' );";
        $this->pdo->query($sql);
        return $dados;
    }
    public function atualizar(object $novosDados, string $id): object
    {
        $sql = "UPDATE " . self::TABLE . 
        " SET 
        nome = '{$novosDados->nome}',
        descricao = '{$novosDados->descricao}',
        status = 1,
        cargaHoraria = '{$novosDados->cargaHoraria}',
        categoria = '{$novosDados->categoria}' WHERE id = '{$id}'";

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