<?php
declare(strict_types=1);
namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;

abstract class AbstractController
{
    public function render(string $view, ?array $dados = [], bool $navbar = true): void
    {
        extract($dados);
        include_once '../views/template/header.phtml';
        $navbar === true && include_once '../views/template/menu.phtml';
        include_once "../views/{$view}.phtml";
        include_once '../views/template/footer.phtml';
    }
    public function redirect(string $local): void
    {
        header('location: '.$local);
    }
    // public function relatorio( string $onde, array $dados = [] ):void
    // {
    //     extract($dados);
    //     ob_start();
    //     include_once ("../../Views/{$onde}/relatorio.phtml");
    //     $pdf = ob_get_clean();
    //     $opcao = new Options();
    //     $opcao->set('isRemoteEnabled', true);
    //     $dompdf = new Dompdf($opcao);
    //     $dompdf->loadHtml($pdf); // carrega o conteudo do PDF
    //     $dompdf->setPaper('A4', 'portrait'); //tamanho da pagina
    //     $dompdf->render(); //aqui renderiza
    //     $dompdf->stream('relatorio.pdf', ['Attachment'=> 0,]); //  é aqui que gera o pdf        
    // }
}