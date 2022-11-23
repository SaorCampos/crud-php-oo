<?php
declare(strict_types=1);
namespace App\Controller;
class ProfessorController extends AbstractController
{
    public function listar(): void
    {
        $this->render('professor/listar');
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