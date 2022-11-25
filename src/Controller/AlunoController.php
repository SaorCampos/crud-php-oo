<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\Aluno;
use App\Repository\AlunoRepository;
use Dompdf\Dompdf;
use Exception;

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
        try{
            $rep->inserir($aluno);
        } catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'cpf')){
                die('CPF já existe');
            }
            if(true === str_contains($exception->getMessage(), 'email')){
                die('Email já existe');
            }
            die('Vish, aconteceu um erro');
        }
        $this->redirect('/alunos/listar');
    }
    public function editar(): void
    {
        $id = $_GET['id'];
        $rep = new AlunoRepository();
        $aluno = $rep->buscarUm($id);
        $this->render('aluno/editar', [$aluno]);
        if (false === empty($_POST)) {
            $aluno->nome = $_POST['nome'];
            $aluno->dataNascimento = $_POST['nascimento'];
            $aluno->cpf = $_POST['cpf'];
            $aluno->email = $_POST['email'];
            $aluno->genero = $_POST['genero'];
            try {
                $rep->atualizar($aluno, $id);
            } catch (Exception $exception) {
                if (true === str_contains($exception->getMessage(), 'cpf')) {
                    die('CPF já existe');
                }
                if (true === str_contains($exception->getMessage(), 'email')) {
                    die('Email ja existe');
                }
                die('Vish, aconteceu um erro');
            }
            $this->redirect('/alunos/listar');
        }
    }
    public function excluir(): void
    {
        $id = $_GET['id'];
        $rep = new AlunoRepository();
        $rep->excluir($id);
        $this->render('aluno/excluir');
        $this->redirect('/alunos/listar');
    }
    public function relatorio(): void
    {
        require('../vendor/autoload.php');
        $dompdf = new Dompdf(['enable_remote'=>true]);
        ob_start();
        require(__FILE__.'../Views/aluno/listar.phtml');
        $hoje = date('d/m/Y');
        $html = ob_get_clean();
        $design = "
        <h1>Relatorio de Alunos</h1>
        <hr>
        <em>Gerado em {$hoje}</em>
        <br>
        <em>{$html}</em>
        ";
        
        $dompdf->setPaper('A4', 'portrait');// tamanho da pagina
        $dompdf->loadHtml($design);//carrega o conteudo do pdf
        $dompdf->render();//aqui renderiza
        $dompdf->stream();//é aqui que a magica acontece
    }
}