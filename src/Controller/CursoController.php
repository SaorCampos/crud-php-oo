<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\Curso;
use App\Repository\CursoRepository;
use App\Repository\CategoriaRepository;
use App\Security\UsuarioSecurity;
use Dompdf\Dompdf;
use Exception;

class CursoController extends AbstractController
{
    private CursoRepository $repository;
    public function __construct()
    {
        $this->repository = new CursoRepository();
    }
    public function listar(): void
    {
        $this->checarLogin();
        $cursos = $this->repository->buscarTodos();
        $this->render('curso/listar',['cursos'=>$cursos,]);
    }
    public function cadastrar(): void
    {
        $this->checarLogin();
        $categoriaRep = new CategoriaRepository();
        $categoria = $categoriaRep->buscarTodos();
        if(true === empty($_POST)){
            $this->render('curso/cadastrar', ['categorias' => $categoria]);
            return;
        }
        $curso = new Curso();
        $curso->nome = $_POST['nome'];
        $curso->descricao = $_POST['descricao'];
        $curso->cargaHoraria = intval($_POST['cargaHoraria']);
        $curso->categoria_id = intval($_POST['categoria']);
        try{
            $this->repository->inserir($curso);
        } catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'nome')){
                die('Curso já existe');
            }
        }
        $this->redirect('/cursos/listar');
    }
    public function editar(): void
    {
        $this->checarLogin();
        $id = $_GET['id'];
        $rep = new CategoriaRepository();
        $categorias = $rep->buscarTodos();
        $curso = $this->repository->buscarUm($id);
        $this->render("/curso/editar", [
            'categorias' => $categorias,
            'curso' => $curso
        ]);
        if (false === empty($_POST)) {
            $curso = new Curso();
            $curso->nome = $_POST['nome'];
            $curso->descricao = $_POST['descricao'];
            $curso->cargaHoraria = intval($_POST['cargaHoraria']);
            $curso->categoria_id = intval($_POST['categoria']);
            $this->repository->atualizar($curso, $id);
            $this->redirect('/cursos/listar');
        }
    }
    public function excluir(): void
    {
        $this->checarLogin();
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->render('curso/excluir');
        $this->redirect('/cursos/listar');
    }
}