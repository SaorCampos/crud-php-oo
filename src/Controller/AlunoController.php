<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\Aluno;
use App\Repository\AlunoRepository;

class AlunoController extends AbstractController
{
    public function listar(): void
    {
        $rep = new AlunoRepository();
        $alunos = $rep->buscarTodos();
        $this->render('aluno/listar', [
            'alunos'=>$alunos,
        ]);
    }
    public function cadastrar(): void
    {
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
        $rep = new AlunoRepository();
        $rep->inserir($aluno);
        $this->redirect('/alunos/listar');
    }
    public function excluir(): void
    {
        $id = $_GET['id'];
        $rep = new AlunoRepository();
        $rep->excluir($id);
        $this->render('aluno/excluir');
        $this->redirect('/alunos/listar');
    }
    public function editar(): void
    {
        $this->render('aluno/editar');
    }
}