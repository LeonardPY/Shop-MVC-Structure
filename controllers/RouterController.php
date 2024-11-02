<?php
class RouterController extends Controller
{
    protected Controller $controller;
    private function parseUrl(string $url): array
    {
        $parsedUrl = parse_url($url);
        $parsedUrl["path"] = ltrim($parsedUrl["path"], "/");
        $parsedUrl["path"] = trim($parsedUrl["path"]);
        return explode("/", $parsedUrl["path"]);
    }

    private function dashesToCamel(string $text): string
    {
        $text = str_replace('-', ' ', $text);
        $text = ucwords($text);
        return str_replace(' ', '', $text);
    }
    public function process(array $params): void
    {
        $parsedUrl = $this->parseUrl($params[0]);
        if (empty($parsedUrl[0]))
            $this->redirect('article/home');
        if($parsedUrl[0] == 'router') {
            $this->redirect('error');
        }
        $controllerClass = $this->dashesToCamel(array_shift($parsedUrl)) . 'Controller';

        if (file_exists('controllers/' . $controllerClass . '.php'))
            $this->controller = new $controllerClass;
        else
            $this->redirect('error');

        $this->controller->process($parsedUrl);
        $this->data['title'] = $this->controller->head['title'];
        $this->data['description'] = $this->controller->head['description'];
        $this->view = 'layout';
    }
}