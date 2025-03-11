<?php

    namespace App\Domain\Application\Session;

    class PHPCookies implements SessionInterface {

        /**
         * Sauvegarde une donnée dans les cookies
         * @param string $key
         * @param mixed $value
         * @param int $expiration
         * @return void
        */
        public function set(string $key, $value, int $expiration = 3600): void
        {
            setcookie($key, $value, time() + $expiration, '/');
        }

        /**
         * Récupère une donnée des cookies
         * @param string $key
         * @return mixed
        */
        public function get(string $key): mixed
        {
            return $_COOKIE[$key] ?? null;
        }

        /**
         * Vérifie si une donnée existe dans les cookies
         * @param string $key
         * @return bool
        */
        public function has(string $key): bool
        {
            return isset($_COOKIE[$key]);
        }

        /**
         * Supprime une donnée des cookies
         * @param string $key
         * @return void
        */
        public function remove(string $key): void
        {
            setcookie($key, '', time() - 3600, '/');
        }

        /**
         * Détruit les cookies
         * @return void
        */
        public function destroy(): void
        {
            foreach ($_COOKIE as $key => $value) {
                setcookie($key, '', time() - 3600, '/');
            }
        }

    }