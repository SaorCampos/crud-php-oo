<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\Professor;
use App\Repository\ProfessorRepository;
use Exception;

class ProfessorController extends AbstractController
{
    public function listar(): void
    {
        $rep = new ProfessorRepository();
        $professores = $rep->buscarTodos();
        $this->render('professor/listar', [
            'professores'=>$professores,
        ]);
    }
    public function cadastrar(): void
    {
        if(true === empty($_POST)){
            $this->render('professor/cadastrar');
            return;
        }
        $professor = new Professor();
        $professor->nome = $_POST['nome'];
        $professor->cpf = $_POST['cpf'];
        $professor->endereco = $_POST['endereco'];
        $professor->formacao = $_POST['formacao'];
        $rep = new ProfessorRepository();
        try{
            $rep->inserir($professor);
        }catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'cpf')){
                die('CPF já existe');
            }
        }
        $this->redirect('/professores/listar');
    }
    public function editar(): void
    {
        $id = $_GET['id'];
        $rep = new ProfessorRepository();
        $professor = $rep->buscarUm($id);
        $this->render('professor/editar', [$professor]);
        if(false === empty($_POST)){
            $professor->nome = $_POST['nome'];
            $professor->cpf = $_POST['cpf'];
            $professor->endereco = $_POST['endereco'];
            $professor->formacao = $_POST['formacao'];
            try{
                $rep->atualizar($professor, $id);
            } catch(Exception $exception){
                if(true === str_contains($exception->getMessage(), 'cpf')){
                    die('CPF já existe');
                }
            }
        $this->redirect('/professores/listar');
        }
    }
    public function excluir(): void
    {
        $id = $_GET['id'];
        $rep = new ProfessorRepository();
        $rep->excluir($id);
        $this->render('professor/excluir');
        $this->redirect("/professores/listar");
    }
}