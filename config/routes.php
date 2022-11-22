<?php
include '../src/Controller/AlunoController.php';
include '../src/Controller/CursoController.php';
include '../src/Controller/ProfessorController.php';
function criarRota(string $controllerNome, string $methodNome): array
{
    return[
        'controller'=> $controllerNome,
        'method'=> $methodNome,
    ];
}
$rotas = [
    // '/'=> 'Pagina inicial',
    '/alunos/listar'=> criarRota(AlunoController::class, 'listar'),
    '/alunos/novo'=> criarRota(AlunoController::class, 'cadastrar'),
    '/alunos/editar'=> criarRota(AlunoController::class, 'editar'),
    '/alunos/excluir'=> criarRota(AlunoController::class, 'excluir'),

    '/cursos/listar'=> criarRota(CursoController::class, 'listar'),
    '/cursos/novo'=> criarRota(CursoController::class, 'cadastrar'),
    '/cursos/editar'=> criarRota(CursoController::class, 'editar'),
    '/cursos/excluir'=> criarRota(CursoController::class, 'excluir'),

    '/professores/listar'=> criarRota(ProfessorController::class, 'listar'),
    '/professores/novo'=> criarRota(ProfessorController::class, 'cadastrar'),
    '/professores/editar'=> criarRota(ProfessorController::class, 'editar'),
    '/professores/excluir'=> criarRota(ProfessorController::class, 'excluir'),
];
return $rotas;