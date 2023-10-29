<?php

namespace App;

use AltoRouter;
use App\Exception\Security\ForbiddenException;
use App\Exception\AlreadyLoggedException;

class Router
{

    private string $viewPath;
    private AltoRouter $router;

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    public function post(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('POST', $url, $view, $name);
        return $this;
    }

    public function match(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('POST|GET', $url, $view, $name);
        return $this;
    }

    public function url(string $name, array $params = [])
    {
        return $this->router->generate($name, $params);
    }

    public function run(): self
    {
        $match = $this->router->match();
        if ($match === false) {
            $view = 'e404';
            require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        } else {
            $view = $match['target'];
            $params = $match['params'];
            $layout = 'layouts/default';
            $router = $this;
            try {
                ob_start();
                require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
                $content = ob_get_clean();
                require $this->viewPath . DIRECTORY_SEPARATOR . $layout . '.php';
            } catch (ForbiddenException $e) {
                header('Location: ' . $this->url('login') . '?forbidden=1');
                exit();
            } catch (AlreadyLoggedException $e) {
                header('Location: ' . $this->url('properties') . '?alreadyLogged=1');
            }
        }
        return $this;
    }
}
