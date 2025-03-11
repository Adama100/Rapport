<?php

    namespace App\Domain\Application\Builder;

    class Form {

        private $data;
        private $errors;

        public function __construct($data, array $errors)
        {
            $this->data = $data;
            $this->errors = $errors;
        }

        /**
         * Construit une champ input
         * @param string $type
         * @param string $key
         * @param string $label
         * @param string $class
         * @param array $attributes
         * @return string
        */
        public function input(string $type, string $key, string $label, array $attributes = [], string $class = 'form-control'): string
        {
            $value = $this->getValue($key);

            $attributes = array_merge(['class' => $class . $this->getInputClass($key), 'name' => $key, 'id' => "field{$key}", 'value' => $value], $attributes);
            $attributesHTML = $this->renderAttributes($attributes);
            return <<<HTML
                <div class="form-group mb-3">
                    <label class="form-label" for="field{$key}">{$label}</label>
                    <input type="{$type}" {$attributesHTML}>
                    {$this->getErrorFeedback($key)}
                </div>
HTML;
        }

        /**
         * Construit un champ file
         * @param string $key
         * @param string $label
         * @param string $class
         * @param array $attributes
         * @return string
        */
        public function file(string $key, string $label, array $attributes = [], string $class = 'form-control'): string
        {
            $attributes = array_merge(['class' => $class . $this->getInputClass($key), 'name' => $key, 'id' => "field{$key}"], $attributes);
            $attributesHTML = $this->renderAttributes($attributes);
            return <<<HTML
                <div class="form-group mb-3">
                    <label class="form-label" for="field{$key}">{$label}</label>
                    <input type="file" {$attributesHTML}>
                    {$this->getErrorFeedback($key)}
                </div>
HTML;
        }

        /**
         * Construit un champ textarea
         * @param string $key
         * @param string $label
         * @param string $class
         * @param array $attributes
         * @return string
        */
        public function textarea(string $key, string $label, array $attributes = [], string $class = 'form-control'): string
        {
            $value = $this->getValue($key);
            $attributes = array_merge(['class' => $class . $this->getInputClass($key), 'name' => $key, 'id' => "field{$key}", 'rows' => 8], $attributes);
            $attributesHTML = $this->renderAttributes($attributes);
            return <<<HTML
            <div class="form-group mb-2">
                <label class="form-label" for="field{$key}">{$label}</label>
                <textarea {$attributesHTML}>{$value}</textarea>
                {$this->getErrorFeedback($key)}
            </div>
HTML;
        }

        /**
         * Construit un champ select
         * Pour les utiliser multiple, on mais l'attribut et le nom doit être un tableau
         * @param string $key
         * @param string $label
         * @param array $options
         * @param string $class
         * @param array $attributes
         * @return string
        */
        public function select(string $key, string $label, array $options = [], array $attributes = [], string $class = 'form-select'): string
        {
            $optionsHTML = [];
            $value = $this->getValue($key);
            foreach($options as $k => $v) {
                $selected = $k == $value ? " selected" : "";
                $optionsHTML[] = "<option value=\"$k\"$selected>$v</option>";
            }
            $optionsHTML = implode('', $optionsHTML);
            $attributes = array_merge(['class' => $class . $this->getInputClass($key), 'name' => "{$key}", 'id' => "field{$key}"], $attributes);
            $attributesHTML = $this->renderAttributes($attributes);

            return <<<HTML
                <div class="form-group mb-2">
                    <label class="form-label" for="field{$key}">{$label}</label>
                    <select {$attributesHTML}>
                        {$optionsHTML}
                    </select>
                    {$this->getErrorFeedback($key)}
                </div>
HTML;
        }

        /**
         * Construit un champ checkbox
         * @param string $key
         * @param string $value
         * @param array $attributes
         * @return string
        */
        public function checkbox(string $key, string $value, array $attributes = [], string $class = 'form-ckeck-input'): string
        {
            $attribute = '';
            $data = $this->getValue($key);
            if(isset($data) && in_array($value, $data)) {
                $attribute .= 'checked';
            }
            $attributes = array_merge(['class' => $class . $this->getInputClass($key), 'name' => "{$key}[]", 'id' => "field{$key}"], $attributes);
            $attributesHTML = $this->renderAttributes($attributes);

            return <<<HTML
                <div class="form-check">
                    <input type="checkbox" {$attributesHTML} {$attribute}>
                    <label class="form-check-label" for="field{$key}">
                        $value
                    </label>
                </div>
HTML;
        }

        /**
         * Construit un champ radio
         * @param string $key
         * @param string $value
         * @param string $class
         * @param array $attributes
         * @return string
        */
        public function radio(string $key, string $value, array $attributes = [], string $class = 'form-check-input'): string
        {
            $attribute = '';
            $data = $this->data;
            if(isset($data[$key]) && $value === $data[$key]) {
                $attribute .= 'checked';
            }
            $attributes = array_merge(['class' => $class . $this->getInputClass($key), 'name' => "{$key}", 'id' => "field{$key}"], $attributes);
            $attributesHTML = $this->renderAttributes($attributes);

            return <<<HTML
                <div class="form-check">
                    <input type="radio" {$attributesHTML} value="$value" $attribute>
                    <label class="form-check-label" for="field{$key}">
                        $value
                    </label>
                </div>
HTML;
        }

        /**
         * Construit un champ inuput:hidden
         * @param string $key
         * @param string $value
         * @return string
        */
        public function hidden(string $key, string $value): string
        {
            return <<<HTML
                <input type="hidden" name="{$key}" value="{$value}">
HTML;
        }

        /**
         * Génère une chaîne d'attributs HTML à partir d'un tableau associatif
         * @param array $attributes
         * @return string
        */
        private function renderAttributes(array $attributes): string
        {
            $html = [];
            foreach ($attributes as $key => $value) {
                $html[] = $key . '="' . htmlspecialchars((string)$value, ENT_QUOTES) . '"';
            }
            return $html ? ' ' . implode(' ', $html) : '';
        }

        /**
         * Hydrate le tableau de données , si c'est un tablau il le retourne
         * Sinon si c'est un objet, il hydarte en rajoutant les getters
         * @param string $key
         * @return mixed
        */
        private function getValue(string $key)
        {
            if(is_array($this->data)) {
                return $this->data[$key] ?? null;
            }
            $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $value = $this->data->$method();
            if($value instanceof \DateTime) {
                return $value->format('Y-m-d H:i:s');
            }
            return $value;
        }

        /**
         * Vérifie l'erreur et le rajoute la class définie
         * @param string $key
         * @return string
        */
        private function getInputClass(string $key): string
        {
            $inputClass = '';
            if(isset($this->errors[$key])) {
                $inputClass .= ' invalid';
            }
            return $inputClass;
        }

        /**
         * Rajoute les massages d'erreurs si il y'en a
         * @param string $key
         * @return string
        */
        private function getErrorFeedback(string $key): string
        {
            if(isset($this->errors[$key])) {
                if(is_array($this->errors[$key])) {
                    $error = implode('<br>', $this->errors[$key]);
                } else {
                    $error = $this->errors[$key];
                }
                return '<div class="invalid-text">' . $error . '</div>';
            }
            return '';
        }

    }