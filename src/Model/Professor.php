<?php
declare(strict_types=1);
class Professor extends Pessoa
{
    public string $endereco;
    public ?string $formacao = null;
    public bool $status;
    public array $horariosDisponiveis = [];
}