<?php
declare(strict_types=1);
namespace App\Controller;

use APP\Model\Categoria;
use APP\Repository\CategoriaRepository;
use Exception;

class CursoController extends AbstractController
{
    public function listar(): void
    {
        $rep = new CategoriaRepository();
        $categorias = $rep->buscarTodos();
        $this->render('categoria/listar', ['categorias'=>$categorias]);
    }
}