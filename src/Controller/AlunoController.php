<?php
declare(strict_types=1);
namespace App\Controller;
use App\Model\Aluno;
use App\Notification\WebNotification;
use App\Repository\AlunoRepository;
use App\Security\UsuarioSecurity;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;

class AlunoController extends AbstractController
{
    private AlunoRepository $repository;
    public function __construct()
    {
        $this->repository = new AlunoRepository();
    }
    public function listar(): void
    {
        $this->checarLogin();
        $alunos = $this->repository->buscarTodos();
        $this->render('aluno/listar', [
            'alunos'=>$alunos,
        ]);
    }
    public function cadastrar(): void
    {
        $this->checarLogin();
        if(true === empty($_POST)){
            $this->render('aluno/cadastrar');
            return;
        }
        $aluno = new Aluno();
        $aluno->nome = $_POST['nome'];
        $aluno->dataNascimento = $_POST['nascimento'];
        $aluno->cpf = $_POST['cpf'];
        $aluno->email = $_POST['email'];
        $aluno->genero = $_POST['genero'];
        try{
            $this->repository->inserir($aluno);
        } catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'cpf')){
                WebNotification::add('CPF já existe', 'danger');
            }
            if(true === str_contains($exception->getMessage(), 'email')){
                WebNotification::add('Email já existe', 'danger');
            }
            WebNotification::add('Vish, aconteceu um erro','danger');
        }
        WebNotification::add('Aluno Cadstrado', 'success');
        $this->redirect('/alunos/listar');
    }
    public function editar(): void
    {
        $this->checarLogin();
        $id = $_GET['id'];
        $aluno = $this->repository->buscarUm($id);
        $this->render('aluno/editar', [$aluno]);
        if (false === empty($_POST)) {
            $aluno->nome = $_POST['nome'];
            $aluno->dataNascimento = $_POST['nascimento'];
            $aluno->cpf = $_POST['cpf'];
            $aluno->email = $_POST['email'];
            $aluno->genero = $_POST['genero'];
            try {
                $this->repository->atualizar($aluno, $id);
            } catch (Exception $exception) {
                if (true === str_contains($exception->getMessage(), 'cpf')) {
                    WebNotification::add('CPF já existe', 'danger');
                }
                if (true === str_contains($exception->getMessage(), 'email')) {
                    WebNotification::add('Email já existe', 'danger');
                }
                WebNotification::add('Vish, aconteceu um erro', 'danger');
            }
            WebNotification::add('Aluno Editado', 'success');
            $this->redirect('/alunos/listar');
        }
    }
    public function excluir(): void
    {
        $this->checarLogin();
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->render('aluno/excluir');
        WebNotification::add('Aluno Excluido', 'success');
        $this->redirect('/alunos/listar');
    }
    public function gerarPDF(): void
    {
        $dados = $this->repository->buscarTodos();
        $this->relatorio("aluno", [
            'alunos' => $dados
        ]);
    }
}