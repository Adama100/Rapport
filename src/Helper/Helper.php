<?php

    namespace App\Helper;

use App\Domain\Application\Session\Flash;

    class Helper {

        /**
         * Redirige avec un message flash
         * @param string $message
         * @param string $path
         * @return never
        */
        public static function redirectFlash(string $type, string $message, string $path)
        {
            Flash::flash($type, $message);
            header('Location: ' . $path); exit;
        }

        /**
         * Redirige avec plusieurs messages flash
         * @param string $message
         * @param string $path
         * @return never
        */
        public static function redirectGflash(string $message, string $path)
        {
            Flash::gflash($message);
            header('Location: ' . $path); exit;
        }

        /**
         * Récupérer la date de début de la semaine actuelle
         * @return string
        */
        public static function yearDate(): string
        {
            $semaine = new \DateTime();
            $semaine->setISODate($semaine->format('Y'), $semaine->format('W'));
            return $semaine->format('Y-m-d');
        }

    }