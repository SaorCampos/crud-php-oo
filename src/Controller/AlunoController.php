<?php
declare(strict_types=1);
class AlunoController extends Render
{
    public function listar(): void
    {
        $this->renderizar('listar');
    }
    public function cadastrar(): void
    {
        $this->renderizar('cadastrar');
    }
    public function excluir(): void
    {
        echo "Pagina de excluir";
    }
    public function editar(): void
    {
        $this->renderizar('editar');
    }
    public function renderizar(string $arquivo, ?array $dados = null)
    {
        include "../Views/aluno/{$arquivo}.phtml";
        $dados;
    }
}