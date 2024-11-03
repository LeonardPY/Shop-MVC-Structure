<?php

class HomeController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
            header("Location: login");
            exit;
        }
    }
    function process(array $params): void
    {
        $this->head['title'] = 'Home';
        $this->view = 'home';
    }
}