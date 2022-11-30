<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\Categoria;
use App\Notification\WebNotification;
use Exception;
use App\Repository\CategoriaRepository;
use App\Security\UsuarioSecurity;
use Dompdf\Dompdf;

class CategoriaController extends AbstractController
{
    private CategoriaRepository $repository;
    public function __construct()
    {
        $this->repository = new CategoriaRepository();
    }
    public function listar(): void
    {
        $this->checarLogin();
        $categorias = $this->repository->buscarTodos();
        $this->render('categoria/listar', ['categorias'=>$categorias]);
    }
    public function cadastrar(): void
    {
        $this->checarLogin();
        if(true === empty($_POST)){
            $this->render('categoria/cadastrar');
            return;
        }
        $categoria = new Categoria();
        $categoria->nome = $_POST['nome'];
        try{
            $this->repository->inserir($categoria);
        } catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'nome')){
                WebNotification::add('Categoria já existe', 'danger');
            }
            die(var_dump($exception));
        }
        WebNotification::add('Categoria Criada', 'success');
        $this->redirect('/categorias/listar');
    }
    public function editar(): void
    {
        $this->checarLogin();
        $id = $_GET['id'];
        $categoria = $this->repository->buscarUm($id);
        $this->render('categoria/editar', [$categoria]);
        if(false === empty($_POST)){
            $categoria->nome = $_POST['nome'];
            try{
                $this->repository->atualizar($categoria, $id);
            }catch(Exception $exception){
                if(true === str_contains($exception->getMessage(), 'nome')){
                    WebNotification::add('Categoria já existe', 'danger');
                }
                die(var_dump($exception));
            }
            WebNotification::add('Categoria Criada', 'success');
            $this->redirect('/categorias/listar');
        }
    }
    public function excluir(): void
    {
        $this->checarLogin();
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->render('categoria/excluir');
        WebNotification::add('Categoria excluida', 'success');
        $this->redirect('/categorias/listar');
    }
    public function gerarPDF(): void
    {
        $dados = $this->repository->buscarTodos();
        $this->relatorio("categoria", [
            'categorias' => $dados
        ]);
    }
}