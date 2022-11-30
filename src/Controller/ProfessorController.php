<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\Professor;
use App\Notification\WebNotification;
use App\Repository\AlunoRepository;
use App\Repository\ProfessorRepository;
use Dompdf\Dompdf;
use Exception;

class ProfessorController extends AbstractController
{
    private ProfessorRepository $repository;
    public function __construct()
    {
        $this->repository = new ProfessorRepository();
    }
    public function listar(): void
    {
        $this->checarLogin();
        $professores = $this->repository->buscarTodos();
        $this->render('professor/listar', [
            'professores'=>$professores,
        ]);
    }
    public function cadastrar(): void
    {
        $this->checarLogin();
        if(true === empty($_POST)){
            $this->render('professor/cadastrar');
            return;
        }
        $professor = new Professor();
        $professor->nome = $_POST['nome'];
        $professor->cpf = $_POST['cpf'];
        $professor->endereco = $_POST['endereco'];
        $professor->formacao = $_POST['formacao'];
        try{
            $this->repository->inserir($professor);
        }catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'cpf')){
                WebNotification::add('CPF já existe', 'danger');
            }
        }
        WebNotification::add('Professor Cadastrado', 'success');
        $this->redirect('/professores/listar');
    }
    public function editar(): void
    {
        $this->checarLogin();
        $id = $_GET['id'];
        $professor = $this->repository->buscarUm($id);
        $this->render('professor/editar', [$professor]);
        if(false === empty($_POST)){
            $professor->nome = $_POST['nome'];
            $professor->cpf = $_POST['cpf'];
            $professor->endereco = $_POST['endereco'];
            $professor->formacao = $_POST['formacao'];
            try{
                $this->repository->atualizar($professor, $id);
            } catch(Exception $exception){
                if(true === str_contains($exception->getMessage(), 'cpf')){
                    WebNotification::add('CPF já existe', 'danger');
                }
            }
        WebNotification::add('Professor Editado', 'success');
        $this->redirect('/professores/listar');
        }
    }
    public function excluir(): void
    {
        $this->checarLogin();
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->render('professor/excluir');
        WebNotification::add('Professor Removido', 'success');
        $this->redirect("/professores/listar");
    }
    public function gerarPDF(): void
    {
        $dados = $this->repository->buscarTodos();
        $this->relatorio("professor", [
            'professores' => $dados
        ]);
    }
}
