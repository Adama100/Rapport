<?php

    namespace App\Domain\Application\Builder;

use App\Helper\URLHelper;

    class PaginatedQuery {

        private $query;
        private $get;
        private $perPage;
        private $sortable = [];

        public function __construct(QueryBuilder $query, array $get, int $perPage = 15)
        {
            $this->query = $query;
            $this->get = $get;
            $this->perPage = $perPage;
        }

        /**
         * Prend en paramètre les champ du tablau à filtrer
         * @param string[] $sortable
         * @return \App\Domain\Application\Builder\PaginatedQuery
        */
        public function sortable(string ...$sortable): self
        {
            $this->sortable = $sortable;
            return $this;
        }

        /**
         * Exécute la requête et renvoie les éléments paginés avec les informations de pagination
         * @return array
        */
        public function queryFetchRender(): array
        {
            $currentPage = $this->getCurrentPage();
            $count =  $this->countQuery();

            if(!empty($this->get['sort']) && in_array($this->get['sort'], $this->sortable)) {
                $this->query->orderBy($this->get['sort'], $this->get['dir'] ?? 'asc');
            }
            $items = $this->query
                ->limit($this->perPage)
                ->page($currentPage)
                ->fetchAll();

            $pages = ceil($count / $this->perPage);
            if($currentPage > $pages) {
                $pages = null;
            }
            return [$items, $pages];
        }

        /**
         * Génère le lien vers la page précédente
         * @param int $pages
         * @return string|null
        */
        public function previousLink(?int $pages = null): ?string
        {
            if($pages !== null) {
                $currentPage = $this->getCurrentPage();
                if($pages > 1 && $currentPage > 1) {
                    $link = URLHelper::withParam($this->get, 'p', $currentPage - 1);
                    return <<<HTML
                        <a href="?{$link}" class="btn btn-primary">&laquo;</a>
    HTML;
                }
            }
            return null;
        }

        /**
         * Génère le lien vers la page suivante
         * @param int $pages
         * @return string|null
        */
        public function nextLink(?int $pages = null): ?string
        {
            if($pages !== null) {
                $currentPage = $this->getCurrentPage();
                if($pages > 1 && $currentPage < $pages) {
                    $link = URLHelper::withParam($this->get, 'p', $currentPage + 1);
                    return <<<HTML
                    <a href="?{$link}" class="btn btn-primary">&raquo;</a>
    HTML;
                }
            }
            return null;
        }

        /**
         * Génère les liens numériques de pagination
         * @param int $pages
         * @return void
        */
        public function renderPageLinks(?int $pages = null)
        {
            if($pages !== null) {
                $currentPage = $this->getCurrentPage();
                $range = 2;
    
                if ($pages <= 1) {
                    return;
                }
                if ($pages <= 7) {
                    for ($i = 1; $i <= $pages; $i++) {
                        echo $this->generatePageLink($i, $currentPage);
                    }
                } else {
                    ## Afficher la première page et des points de suspension si nécessaire
                    if ($currentPage > 1 + $range) {
                        echo $this->generatePageLink(1, $currentPage);
                    }
                    if ($currentPage > 2 + $range) {
                        echo '<div>...</div>';
                    }
                    ## Afficher les pages autour de la page actuelle
                    for ($i = max(1, $currentPage - $range); $i <= min($pages, $currentPage + $range); $i++) {
                        echo $this->generatePageLink($i, $currentPage);
                    }
                    ## Afficher la dernière page et des points de suspension si nécessaire
                    if ($currentPage < $pages - $range) {
                        if ($currentPage < $pages - $range - 1) {
                            echo '<div>...</div>';
                        }
                        echo $this->generatePageLink($pages, $currentPage);
                    }
                }
            }
            return null;
        }

        /**
         * Génère le lien pour une page spécifique.
         * @param int $page
         * @param int $currentPage
         * @return string
        */
        private function generatePageLink(int $page, int $currentPage): string
        {
            $link = URLHelper::withParam($this->get, 'p', $page);
            if ($page == $currentPage) {
                return "<a class='btn btn-light active'>{$page}</a>";
            } else {
                return "<a class='btn btn-primary' href=\"?{$link}\">{$page}</a>";
            }
        }

        /**
         * Donne la page courante
         * @return int
        */
        private function getCurrentPage(): int
        {
            return URLHelper::getPositiveInt('p', 1);
        }

        /**
         * Clone la requête du QueryBuilder
         * @return int
        */
        private function countQuery()
        {
            return (clone $this->query)->count();
        }

    }