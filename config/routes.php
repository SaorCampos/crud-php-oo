<?php
use App\Controller\AlunoController;
use App\Controller\AuthController;
use App\Controller\CursoController;
use App\Controller\ProfessorController;
use App\Controller\SiteController;
use App\Controller\CategoriaController;
use App\Controller\UsuarioController;
function criarRota(string $controllerNome, string $methodNome): array
{
    return[
        'controller'=> $controllerNome,
        'method'=> $methodNome,
    ];
}
$rotas = [
    '/'=> criarRota(SiteController::class, 'inicio'),

    '/alunos/listar'=> criarRota(AlunoController::class, 'listar'),
    '/alunos/novo'=> criarRota(AlunoController::class, 'cadastrar'),
    '/alunos/editar'=> criarRota(AlunoController::class, 'editar'),
    '/alunos/excluir'=> criarRota(AlunoController::class, 'excluir'),
    '/alunos/relatorio'=> criarRota(AlunoController::class, 'gerarPDF'),

    '/usuarios/listar'=> criarRota(UsuarioController::class, 'listar'),
    '/usuarios/novo'=> criarRota(UsuarioController::class, 'cadastrar'),
    '/usuarios/editar'=> criarRota(UsuarioController::class, 'editar'),
    '/usuarios/excluir'=> criarRota(UsuarioController::class, 'excluir'),
    '/usuarios/relatorio'=> criarRota(UsuarioController::class, 'gerarPDF'),

    '/cursos/listar'=> criarRota(CursoController::class, 'listar'),
    '/cursos/novo'=> criarRota(CursoController::class, 'cadastrar'),
    '/cursos/editar'=> criarRota(CursoController::class, 'editar'),
    '/cursos/excluir'=> criarRota(CursoController::class, 'excluir'),
    '/cursos/relatorio'=> criarRota(CursoController::class, 'gerarPDF'),

    '/professores/listar'=> criarRota(ProfessorController::class, 'listar'),
    '/professores/novo'=> criarRota(ProfessorController::class, 'cadastrar'),
    '/professores/editar'=> criarRota(ProfessorController::class, 'editar'),
    '/professores/excluir'=> criarRota(ProfessorController::class, 'excluir'),
    '/professores/relatorio' => criarRota(ProfessorController::class, 'gerarPDF'),

    '/categorias/listar'=> criarRota(CategoriaController::class, 'listar'),
    '/categorias/novo'=> criarRota(CategoriaController::class, 'cadastrar'),
    '/categorias/editar'=> criarRota(CategoriaController::class, 'editar'),
    '/categorias/excluir'=> criarRota(CategoriaController::class, 'excluir'),
    '/categorias/relatorio'=> criarRota(CategoriaController::class, 'gerarPDF'),

    '/login'=> criarRota(AuthController::class, 'login'),
    '/desconectar'=>criarRota(AuthController::class, 'desconectar'),
];
return $rotas;