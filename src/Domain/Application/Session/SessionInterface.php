<?php

    namespace App\Domain\Application\Session;

    interface SessionInterface {

        /**
         * Sauvegarde une donnée dans la session.
         * @param string $key
         * @param mixed $value
        */
        public function set(string $key, $value): void;

        /**
         * Récupère une donnée de la session.
         * @param string $key
         * @return mixed
        */
        public function get(string $key);

        /**
         * Vérifie si une donnée existe dans la session.
         * @param string $key
         * @return bool
        */
        public function has(string $key): bool;

        /**
         * Supprime une donnée de la session.
         * @param string $key
        */
        public function remove(string $key): void;

    }