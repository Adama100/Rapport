<?php

    namespace App\Helper;

    class URLHelper {

        /**
         * Supprime le paramètre 'p' dans l'url si on n'est à la page 1
         * @param string $param
         * @return void
        */
        public static function revomeParam(string $param): void
        {
            if(isset($_GET[$param]) && $_GET[$param] === '1') {
                $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
                $get = $_GET;
                unset($get[$param]);
                $query = http_build_query($get);
                if(!empty($query)) {
                    $uri = $uri . '?' . $query;
                }
                http_response_code(301);
                header('Location: ' . $uri);
            }
        }

        /**
         * Supprime plusieurs paramètres de l'URL
         * @param array $params
         * @return string
        */
        public static function removeParams(array $params): string
        {
            $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
            foreach ($params as $param) {
                unset($_GET[$param]);
            }
            $query = http_build_query($_GET);
            return $uri . (!empty($query) ? '?' . $query : '');
        }

        /**
         * Récupère un paramètre dans l'url et si elle n'existe pas, on peut lui assigné une valeur
         * @param string $name
         * @param mixed $default
         * @throws \Exception
         * @return int|null
        */
        public static function getInt(string $name, ?int $default = null): ?int
        {
            if(!isset($_GET[$name])) return $default;
            if($_GET[$name] === '0') return 0;

            if(!filter_var($_GET[$name], FILTER_VALIDATE_INT)) {
                throw new \Exception("Le paramètre dans l'url '$name' n'est pas un entier");
            }
            return (int)$_GET[$name];
        }

        /**
         * Vérifie si le paramètre est un entier posistif
         * @param string $name
         * @param mixed $default
         * @throws \Exception
         * @return int|null
        */
        public static function getPositiveInt(string $name, ?int $default = null): ?int
        {
            $param = self::getInt($name, $default);
            if($param !== null && $param <= 0) {
                throw new \Exception("Le paramètre dans l'url '$name' n'est pas un entier positif");
            }
            return $param;
        }

        /**
         * http_build_query() Construit une chaîne de requête URL encodée à partir d'un tableau associatif ou indexé
         * array_merge() Fusionne les deux tableaux
         * @param array $data
         * @param string $param
         * @param mixed $value
         * @return string
        */
        public static function withParam(array $data, string $param, $value): ?string 
        {
            if(is_array($value)) {
                $value = implode(",", $value);
            }
            return http_build_query(array_merge($data, [$param => $value]));
        }

        /**
         * Prend un tableau paramètre et le rajoute à un tableau de parmètre
         * @param array $data
         * @param array $params
         * @return string
        */
        public static function withParams(array $data, array $params): string 
        {
            foreach($params as $k => $v) {
                if(is_array($v)) {
                    $params[$k] = implode(',', $v);
                }
            }
            return http_build_query(array_merge($data, $params));
        }

        /**
         * Vérifie si un paramètre existe et contient une valeur spécifique
         * @param string $param
         * @param mixed $value
         * @return bool
        */
        public static function isActive(string $param, ?string $value = null): bool
        {
            if (!isset($_GET[$param])) {
                return false;
            }
            return $value === null || $_GET[$param] === $value;
        }

    }