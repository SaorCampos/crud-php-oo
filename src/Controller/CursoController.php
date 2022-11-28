<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\Curso;
use App\Repository\CursoRepository;
use App\Repository\CategoriaRepository;
use Exception;

class CursoController extends AbstractController
{
    public function listar(): void
    {
        $rep = new CursoRepository();
        $cursos = $rep->buscarTodos();
        $this->render('curso/listar',['cursos'=>$cursos,]);
    }
    public function cadastrar(): void
    {
        $categoriaRep = new CategoriaRepository();
        $categoria = $categoriaRep->buscarTodos();
        if(true === empty($_POST)){
            $this->render('curso/cadastrar', ['categorias' => $categoria]);
            return;
        }
        $curso = new Curso();
        $curso->nome = $_POST['nome'];
        $curso->cargaHoraria = $_POST['cargaHoraria'];
        $curso->descricao = $_POST['descricao'];
        $curso->setarIdCategoria((int) $_POST['categoria']);
        $rep = new CursoRepository();
        try{
            $rep->inserir($curso);
        } catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'nome')){
                die('Curso já existe');
            }
        }
        $this->redirect('/cursos/listar');
    }
    public function editar(): void
    {
        $id = $_GET['id'];
        $rep = new CursoRepository();
        $curso = $rep->buscarUm($id);
        $this->render('curso/editar', [$curso]);
        if(false === empty($_POST)){
            $curso->nome = $_POST['nome'];
            $curso->cargaHoraria = $_POST['cargaHoraria'];
            $curso->descricao = $_POST['descricao'];
            $curso->categoria = $_POST['categoria'];
            try{
                $rep->atualizar($curso, $id);
            }catch (Exception $exception){
                if(true === str_contains($exception->getMessage(), 'nome')){
                    die('Curso já existe');
                }
            }
            $this->redirect('/cursos/listar');
        }
    }
    public function excluir(): void
    {
        $id = $_GET['id'];
        $rep = new CursoRepository();
        $rep->excluir($id);
        $this->render('curso/excluir');
        $this->redirect('/cursos/listar');
    }
}