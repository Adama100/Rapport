<?php

    namespace App\Http;

use AltoRouter;

    class Router {

        /**
         * @var string
        */
        private $viewPath;

        /**
         * @var AltoRouter
        */
        private $router;

        public function __construct(string $viewPath)
        {
            $this->viewPath = $viewPath;
            $this->router = new AltoRouter();
        }

        /**
         * Requête $_GET
         * @param string $url
         * @param string $view
         * @param mixed $name
         * @return \App\Http\Router
        */
        public function get(string $url, string $view, ?string $name = null): self
        {
            $this->router->map('GET', $url, $view, $name);
            return $this;
        }

        /**
         * Requête $_POST
         * @param string $url
         * @param string $view
         * @param mixed $name
         * @return \App\Http\Router
        */
        public function post(string $url, string $view, ?string $name = null): self
        {
            $this->router->map('POST', $url, $view, $name);
            return $this;
        }

        /**
         * Requête $_GET ou $_POST
         * @param string $url
         * @param string $view
         * @param mixed $name
         * @return \App\Http\Router
        */
        public function match(string $url, string $view, ?string $name = null): self
        {
            $this->router->map('GET|POST', $url, $view, $name);
            return $this;
        }

        /**
         * Génère le chemin de la route
         * @param string $name
         * @param array $params
         * @return string
        */
        public function url(string $name, array $params = []): string 
        {
            return $this->router->generate($name, $params);
        }

        /**
         * Chemin de base
         * @param string $basePath
         * @return void
         */
        public function setbasePath(string $basePath)
        {
            $this->router->setBasePath($basePath);
        }

        /**
         * Rend la vue
         * @return \App\Http\Router
        */
        public function run(): self
        {
            $match = $this->router->match();
            $r = $this;

            if(is_array($match)) {
                if(is_callable($match['target'])) {
                    call_user_func_array($match['target'], $match['params']);
                } else{
                    $view = $match['target'];
                    $params = $match['params'];
                    $isAdmin = strpos($view, 'admin/') !== false;
                    $layout = $isAdmin ? 'admin/layout/default' : 'layout/default';
                    ob_start();
                    require $this->viewPath . DIRECTORY_SEPARATOR . "{$match['target']}.php";
                    $content = ob_get_clean();
                }
                require $this->viewPath . DIRECTORY_SEPARATOR . $layout . '.php';
            } else {
                require $this->viewPath . DIRECTORY_SEPARATOR . 'partials/error.php';
            }
            return $this;
        }

    }