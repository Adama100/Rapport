<?php

    namespace App\Domain\Auth\Security;

use App\Domain\App;
use App\Domain\Application\Session\Flash;

    class UserChecker {

        /**
         * Vérifie si l'utilisateur n'est pas connecté
         * @param string $path
         * @param string $message
         * @return void
        */
        public static function UserNotConnected(string $path, string $message = 'Vous devez vous connecter pour avoir accès à cet espace') 
        {
            $user = App::getAuth()->user();
            if($user === null) {
                Flash::flash('danger', $message);
                header('Location: ' . $path);
                exit;
            }
        }

        /**
         * Empêche l'utilisateur connecté d'acceder a une section
         * @param string $path
         * @param string $message
         * @return void
        */
        public static function UserConnected(string $path, string $message = 'Vous êtes déjà connecté') 
        {
            $user = App::getAuth()->user();
            if($user) {
                ## Flash::flash('warning', $message);
                header('Location: ' . $path);
                exit;
            }
        }

        /**
         * Vérifie que l'utilisateur a le rôle requis (super admin ou admin)
         * @param array $roles
         * @param string $path
         * @param bool $flash
         * @return void
        */
        public static function checkRoles(array $roles, string $path, bool $flash = true) 
        {
            try {
                App::getAuth()->requireRole(...$roles);
            } catch (\Exception $e) {
                if ($flash) {
                    Flash::flash('danger', $e->getMessage());
                }
                header('Location: ' . $path); exit;
            }
        }

    }