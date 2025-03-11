<?php

    namespace App\Domain\Auth\Repository;

use App\Domain\Application\Abstract\AbstractTable;
use App\Domain\Auth\Entity\User;

    final class UserRepository extends AbstractTable {

        protected $table = "users";
        protected $class = User::class;

        public function create(User $user): void {
            $query = $this->pdo->prepare("INSERT INTO {$this->table}(username, email, password) VALUES (:username, :email, :password)");
            $query->execute([
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            ]);
            $user->setID($this->pdo->lastInsertId());
        }

        public function update(User $user): void
        {
            $query = $this->pdo->prepare("UPDATE {$this->table} SET  WHERE id = :id");
            $query->execute([
                'id' => $user->getId()
            ]);
        }

    }