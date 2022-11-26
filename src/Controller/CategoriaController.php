<?php
declare(strict_types=1);
namespace App\Controller;

use APP\Model\Categoria;
use Exception;
use App\Repository\CategoriaRepository;

class CategoriaController extends AbstractController
{
    public function listar(): void
    {
        $rep = new CategoriaRepository();
        $categorias = $rep->buscarTodos();
        $this->render('categoria/listar', ['categorias'=>$categorias]);
    }
    public function cadastrar(): void
    {
        if(true === empty($_POST)){
            $this->render('categoria/cadastrar');
            return;
        }
        $categoria = new Categoria();
        $categoria->nome = $_POST['nome'];
        $rep = new CategoriaRepository();
        try{
            $rep->inserir($categoria);
        } catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'nome')){
                die('Categoria já existe');
            }
            die(var_dump($exception));
        }
        $this->redirect('/categorias/listar');
    }
    public function editar(): void
    {
        $id = $_GET['$id'];
        $rep = new CategoriaRepository();
        $categoria = $rep->buscarUm($id);
        $this->render('categoria/editar', [$categoria]);
        if(false === empty($_POST)){
            $categoria->nome = $_POST['nome'];
            try{
                $rep->atualizar($categoria, $id);
            }catch(Exception $exception){
                if(true === str_contains($exception->getMessage(), 'nome')){
                    die('Categoria já existe');
                }
                die(var_dump($exception));
            }
        }
        $this->redirect('/categorias/listar');
    }
    public function excluir(): void
    {
        $id = $_GET['id'];
        $rep = new CategoriaRepository();
        $rep->excluir($id);
        $this->render('categoria/excluir');
        $this->redirect('categorias/listar');
    }
}