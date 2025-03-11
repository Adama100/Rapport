<?php

    namespace App\Infrastructure\Environment;

    class EnvLoader {

        protected static $variables = [];

        /**
         * Charge les variables d'environnement depuis un fichier.
         * @param string $filePath
        */
        public static function load(string $filePath)
        {
            if (!file_exists($filePath)) {
                throw new \Exception("Le fichier .env est introuvable : $filePath");
            }
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                // Ignore les commentaires
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }

                [$name, $value] = array_map('trim', explode('=', $line, 2));
                $value = trim($value, '"'); // Retire les guillemets éventuels

                // Stocke la variable dans PHP
                self::$variables[$name] = $value;
                putenv("$name=$value");
            }
        }

        /**
         * Récupère la valeur d'une variable d'environnement.
         * @param string $name
         * @param mixed $default
         * @return mixed
         */
        public static function get(string $name, $default = null)
        {
            return self::$variables[$name] ?? getenv($name) ?? $default;
        }

    }