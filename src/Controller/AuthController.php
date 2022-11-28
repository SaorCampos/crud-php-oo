<?php
declare(strict_types=1);
namespace App\Controller;

use App\Repository\UsarioRepository;

class AuthController extends AbstractController
{
    private UsarioRepository $usuarioRepository;
    public function __construct()
    {
        $this->usuarioRepository = new UsarioRepository();
    }
    public function login(): void
    {
        $this->render('auth/login', navbar: false);
    }
    public function logout(): void
    {

    }
}