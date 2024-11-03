<?php

class LogoutController extends Controller
{
    private AuthService $authService;
    public function __construct()
    {
        if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
            header("Location: login");
            exit;
        }
        $this->authService = new AuthService();
    }

    public function process(array $params): void
    {
        $this->head = [
            'title' => 'logout',
            'description' => '',
        ];

        $this->authService->logout();

        $this->view = 'login';
    }
}