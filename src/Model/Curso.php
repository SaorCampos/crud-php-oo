<?php
declare(strict_types=1);
namespace App\Model;
class Curso
{
    public string $nome;
    public string $cargaHoraria;
    public string $descricao;
    public bool $status;
    public int $categoriaId;
    public int $categoria;

    public function pegarIdCategoria(): int
    {
        return $this->categoriaId;
    }
    public function setarIdCategoria(int $categoriaId): void
    {
        $this->categoriaId = $categoriaId;
    }
    public function pegarCategoria(): int
    {
        return $this->categoria;
    }

    public function setarCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
    }
}