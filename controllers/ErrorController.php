<?php

class ErrorController extends Controller
{
    public function process(array $params): void
    {
        header("HTTP/1.0 404 Not Found");
        $this->head['title'] = 'Error 404';
        $this->view = 'error';
    }
}