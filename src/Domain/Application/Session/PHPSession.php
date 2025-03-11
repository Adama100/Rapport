<?php

    namespace App\Domain\Application\Session;

    class PHPSession implements SessionInterface {

        public static $session; 

        private function __construct()
        {
            session_start();
        }

        /**
         * Démarre une session
         * @return \App\Domain\Application\Session\PHPSession
        */
        public static function start(): PHPSession
        {
            if(!self::$session) {
                self::$session = new PHPSession();
            }
            return self::$session;
        }

        /**
         * Sauvegarde une donnée dans la session
         * @param string $key
         * @param mixed $value
         * @return void
        */
        public function set(string $key, $value): void
        {
            $_SESSION[$key] = $value;
        }

        /**
         * Récupère une donnée de la session
         * @param string $key
         * @return mixed
        */
        public function get(string $key): mixed
        {
            return $_SESSION[$key] ?? null;
        }

        /**
         * Vérifie si une donnée existe dans la session
         * @param string $key
         * @return bool
        */
        public function has(string $key): bool
        {
            return isset($_SESSION[$key]);
        }

        /**
         * Supprime une donnée de la session
         * @param string $key
         * @return void
        */
        public function remove(string $key): void
        {
            unset($_SESSION[$key]);
        }

        /**
         * Détruit la session
         * @return void
        */
        public function destroy(): void
        {
            session_destroy();
        }

    }