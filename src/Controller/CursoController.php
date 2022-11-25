<?php
declare(strict_types=1);
namespace App\Controller;

use App\Repository\CursoRepository;

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
        $this->render('curso/cadastrar');
    }
    public function excluir(): void
    {
        $id = $_GET['id'];
        $rep = new CursoRepository();
        $rep->excluir($id);
        $this->render('curso/excluir');
        $this->redirect('/professores/listar');
    }
    public function editar(): void
    {
        $this->render('curso/editar');
    }
}