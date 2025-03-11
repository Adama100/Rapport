<?php

    namespace App\Domain\Rapport;

use DateTime;

    class Rapport {

        private $id;
        private $title;
        private $user_id;
        private $status;
        private $created_at;
        private $updated_at;

        public function getId(): ?int
        {
            return $this->id;
        } 

        public function setId(int $id): self
        {
            $this->id = $id;
            return $this;
        }

        public function getTitle(): ?string
        {
            return $this->title;
        }

        public function setTitle(string $title): self
        {
            $this->title = $title;
            return $this;
        }

        public function getUserId(): ?int
        {
            return $this->user_id;
        }

        public function setUserId(int $user_id): self
        {
            $this->user_id = $user_id;
            return $this;
        }

        public function getStatus(): ?string
        {
            return $this->status;
        }

        public function setStatus(string $status): self
        {
            $this->status = $status;
            return $this;
        }

        public function getCreatedAt(): DateTime
        {
            return new DateTime($this->created_at);
        }

        public function setCreatedAt($dateTime): self
        {
            $this->created_at = $dateTime;
            return $this;
        }

        public function getUpdatedAt(): DateTime
        {
            return new DateTime($this->updated_at);
        }

        public function setUpdatedAt($updated_at): self
        {
            $this->updated_at = $updated_at;
            return $this;
        }

    }