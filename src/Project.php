<?php

class Project {
    private ?int $id;
    private string $name;
    private ?string $description;
    private string $creation_date;
    private int $id_status_type;

    public function __construct(?int $id, string $name, ?string $description, string $creation_date, int $id_status_type) {
        $this->id = $id;
        $this->setName($name);
        $this->setDescription($description);
        $this->setCreationDate($creation_date);
        $this->id_status_type = $id_status_type;
    }


    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getCreationDate(): string {
        return $this->creation_date;
    }

    public function getIdStatusType(): int {
        return $this->id_status_type;
    }


    public function setName(string $name): void {
        $cleanedName = trim($name);
        if (empty($cleanedName)) {
            throw new Exception("Le nom du projet ne peut pas être vide.");
        }
        $this->name = $cleanedName;
    }

    public function setDescription(?string $description): void {
        $this->description = $description !== null ? trim($description) : null;
    }

    public function setCreationDate(string $creation_date): void {
        if (strtotime($creation_date) === false) {
            throw new Exception("Le format de la date de création est invalide.");
        }
        $this->creation_date = $creation_date;
    }

    public function setIdStatusType(int $id_status_type): void {
        $this->id_status_type = $id_status_type;
    }
}
