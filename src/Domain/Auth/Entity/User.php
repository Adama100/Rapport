<?php

    namespace App\Domain\Auth\Entity;

    class User {

        private $id;
        private $username;
        private $email;
        private $password;
        private $role;
        const ROLE = [
            1 => 'guichet',
            2 => 'agence',
            3 => 'admin'
        ];

        public function getId(): ?int
        {
            return $this->id;
        } 

        public function setId(int $id): self
        {
            $this->id = $id;
            return $this;
        }

        public function getUsername(): ?string
        {
            return $this->username;
        } 

        public function setUsername(string $username): self
        {
            $this->username = $username;
            return $this;
        }

        public function getEmail(): ?string
        {
            return $this->email;
        }

        public function setEmail(string $email): self
        {
            $this->email = $email;
            return $this;
        }

        public function getPassword(): ?string
        {
            return $this->password;
        } 

        public function setPassword(string $password): self
        {
            $this->password = $password;
            return $this;
        }

        public function getRole(): ?string
        {
            return $this->role;
        }

    }