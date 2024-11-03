<?php

class LoginController extends Controller
{
    private AuthService $authService;
    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function process(array $params): void
    {
        $this->head = [
            'title' => 'login',
            'description' => '',
        ];

        if (isset($_POST["email"]))
        {
            $user = $this->authService->login($_POST["email"], $_POST["password"]);
            if ($user) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                ];
                header('Location: home');
            }
        }

        $this->view = 'login';
    }
}