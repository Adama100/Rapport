<?php

    namespace App\Helper;

    class FilterHelper {

        const SORT_KEY = 'sort';
        const DIR_KEY = 'dir';

        /**
         * Permet de créer un lien pour filtrer par l'ordre
         * @param string $sortKey
         * @param string $label
         * @param array $data
         * @return string
        */
        public static function sort(string $sortKey, string $label, array $data): string
        {
            $sort = $data[self::SORT_KEY] ?? null;
            $direction = $data[self::DIR_KEY] ?? null;
            $icon = "";
            if ($sort === $sortKey) {
                $icon = $direction === 'asc' ? "^" : 'v';
            }
            $url = URLHelper::withParams($data, [
                'sort' => $sortKey,
                'dir' => $direction === 'asc' && $sort === $sortKey ? 'desc' : 'asc'
            ]);
            return <<<HTML
            <a href="?$url">$label $icon</a>
HTML;
        }

    }