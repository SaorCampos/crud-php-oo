<?php
declare(strict_types=1);
namespace App\Model;
class Categoria
{
    public int $id;
    public string $categoria;

    public function pegarId(): int
    {
        return $this->id;
    }
    public function setarId(int $id): void
    {
        $this->id = $id;
    }
    public function pegarNome(): string
    {
        return $this->name;
    }
    public function setarNome(string $name): void
    {
        $this->name = $name;
    }
}