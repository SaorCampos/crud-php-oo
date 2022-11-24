<?php
declare(strict_types=1);
namespace App\Controller;

use App\Repository\ProfessorRepository;

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
    public function cadastar(): void
    {
        $this->render('professor/cadastrar');
    }
    public function excluir(): void
    {
        $this->render('professor/excluir');
    }
    public function editar(): void
    {
        $this->render('professor/editar');
    }
}