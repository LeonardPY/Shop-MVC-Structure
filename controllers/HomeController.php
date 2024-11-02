<?php

class HomeController extends Controller
{
    function process(array $params): void
    {
        $this->head['title'] = 'Home';
        $this->view = 'home';
    }
}