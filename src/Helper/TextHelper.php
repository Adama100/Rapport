<?php

    namespace App\Helper;

    class TextHelper {

        /**
         * Permet de couper un texte à une limit donnée
         * @param string $content
         * @param int $limit
         * @return string
        */
        public static function excerpt(string $content, int $limit = 60, string $suffix = ' ..'): string 
        {
            if(mb_strlen($content) <= $limit) {
                return $content;
            }
            $lastspace = mb_strpos($content, ' ', $limit);
            return mb_substr($content, 0, $lastspace) . $suffix;
        }

        /**
         * Ajoute un zéro initial au nombre qui est inférieur à 10
         * @param int $number
         * @return int|string
        */
        public static function zeroInit(int $number) 
        {
            if($number < 10) {
                return 0 . $number;
            } else {
                return $number;
            }
            ## return $number < 10 ? 0 . $number : (int)$number;
        }

        /**
         * Supprime les espaces supplémentaires dans une chaîne
         * @param string $string
         * @return string
        */
        public static function removeExtraSpaces(string $string): string
        {
            return preg_replace('/\s+/', ' ', trim($string));
        }

        /**
         * Convertit une chaîne en snake_case
         * @param string $string
         * @return string
        */
        public static function toSnakeCase(string $string): string
        {
            $string = preg_replace('/([a-z])([A-Z])/', '$1_$2', $string);
            return strtolower(str_replace(' ', '_', $string));
        }

        /**
         * Convertit une chaîne en camelCase
         * @param string $string
         * @return string
        */
        public static function toCamelCase(string $string): string
        {
            $string = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
            return lcfirst($string);
        }

        /**
         * Met en majuscule la première lettre de chaque mot dans une chaîne de caractère
         * @param string $string
         * @return string
        */
        public static function capitalizeWords(string $string): string
        {
            return ucwords(strtolower($string));
        }

        /**
         * Vérifie si la chaîne contient une sous-chaîne
         * @param string $haystack
         * @param string $needle
         * @return bool
        */
        public static function contains(string $haystack, string $needle): bool
        {
            return mb_strpos($haystack, $needle) !== false;
        }

        /**
         * Vérifie si la chaîne commence par un certain préfixe
         * @param string $haystack
         * @param string $needle
         * @return bool
        */
        public static function startsWith(string $haystack, string $needle): bool
        {
            return mb_substr($haystack, 0, mb_strlen($needle)) === $needle;
        }

        /**
         * Vérifie si la chaîne se termine par un certain suffixe
         * @param string $haystack
         * @param string $needle
         * @return bool
        */
        public static function endsWith(string $haystack, string $needle): bool
        {
            return mb_substr($haystack, -mb_strlen($needle)) === $needle;
        }

        /**
         * Crée un slug à partir d'une chaîne de texte
         * @param string $string
         * @return string
        */
        public static function slugify(string $string): string
        {
            $string = strtolower(trim($string));
            $string = preg_replace('/[^a-z0-9]+/', '-', $string);
            return rtrim($string, '-');
        }

    }