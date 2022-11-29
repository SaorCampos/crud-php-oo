<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\Curso;
use App\Repository\CursoRepository;
use App\Repository\CategoriaRepository;
use App\Security\UsuarioSecurity;
use Dompdf\Dompdf;
use Exception;

class CursoController extends AbstractController
{
    private CursoRepository $repository;
    public function __construct()
    {
        $this->repository = new CursoRepository();
    }
    public function listar(): void
    {
        $this->checarLogin();
        $cursos = $this->repository->buscarTodos();
        $this->render('curso/listar',['cursos'=>$cursos,]);
    }
    public function cadastrar(): void
    {
        $categoriaRep = new CategoriaRepository();
        $categoria = $categoriaRep->buscarTodos();
        if(true === empty($_POST)){
            $this->render('curso/cadastrar', ['categorias' => $categoria]);
            return;
        }
        $curso = new Curso();
        $curso->nome = $_POST['nome'];
        $curso->cargaHoraria = $_POST['cargaHoraria'];
        $curso->descricao = $_POST['descricao'];
        $curso->setarIdCategoria((int) $_POST['categoria']);
        try{
            $this->repository->inserir($curso);
        } catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'nome')){
                die('Curso já existe');
            }
        }
        $this->redirect('/cursos/listar');
    }
    public function editar(): void
    {
        $id = $_GET['id'];
        $curso = $this->repository->buscarUm($id);
        $this->categoriaRepository = new CategoriaRepository;
        $this->render('curso/editar', [
            $curso,
            'categorias' => $this->categoriaRepository->buscarTodos()
        ]); 
        if(!empty($_POST)){
            $curso->nome = $_POST['nome'];
            $curso->cargaHoraria = $_POST['cargaHoraria'];
            $curso->descricao = $_POST['descricao'];
            $curso->categoria_id = intval($_POST['categoria']);
            try{
                $this->repository->atualizar($curso, $id);
            } catch(Exception $exception){
                if(str_contains($exception->getMessage(), 'nome')){
                    die('O curso já existe');
                }
                die('Vish, aconteceu um erro');
            }
            $this->redirect('/cursos/listar');
        }
    }
    public function excluir(): void
    {
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->render('curso/excluir');
        $this->redirect('/cursos/listar');
    }
    private function renderizar(iterable $cursos)
    {
        $resultado = '';
        foreach ($cursos as $curso){
            $resultado .= "
            <tr>
                <td>{$curso['id']}</td>
                <td>{$curso[1]}</td>
                <td>{$curso[2]}</td>
                <td>{$curso[3]}</td>
                <td>{$curso[4]}</td>
                <td>{$curso[7]}</td>
            </tr>
            ";
        }
        return $resultado;
    }
    public function relatorio(): void
    {
        $hoje = date('d/m/Y');
        $cursos = $this->repository->buscarTodos();
        $design =  "
            <h1>Relatorio de Alunos</h1>
            <hr>
            <em>Gerado em {$hoje}</em>
            <br>
            <table border='1' width='100%' style='margin-top: 30px;'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Matricula</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Gênero</th>
                        <th>Status</th>
                        <th>Data Nascimento</th>
                    </tr>
                </thead>
                <tbody>
                ".$this->renderizar($cursos)."
                </tbody>
            </table>
        ";
        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($design);
        $dompdf->render();
        $dompdf->stream('relatorio-cursos.pdf', ['Attachment' => 0,]);
    }
}