<?php

class Task {
    private ?int $id;
    private string $title;
    private ?string $description;
    private string $creation_date;
    private string $due_date;
    private ?int $id_user;
    private int $id_project;
    private int $id_status_type;
    private int $id_priority_level;

    public function __construct(
        ?int $id,
        string $title,
        ?string $description,
        string $creation_date,
        string $due_date,
        ?int $id_user,
        int $id_project,
        int $id_status_type,
        int $id_priority_level
    ) {
        $this->id = $id;
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setCreationDate($creation_date);
        $this->setDueDate($due_date);
        $this->id_user = $id_user;
        $this->id_project = $id_project;
        $this->id_status_type = $id_status_type;
        $this->id_priority_level = $id_priority_level;
    }


    public function getId(): ?int {
        return $this->id;
    }
    public function getTitle(): string {
        return $this->title;
    }
    public function getDescription(): ?string {
        return $this->description;
    }
    public function getCreationDate(): string {
        return $this->creation_date;
    }
    public function getDueDate(): string {
        return $this->due_date;
    }
    public function getIdUser(): ?int {
        return $this->id_user;
    }
    public function getIdProject(): int {
        return $this->id_project;
    }
    public function getIdStatusType(): int {
        return $this->id_status_type;
    }
    public function getIdPriorityLevel(): int {
        return $this->id_priority_level;
    }


    public function setTitle(string $title): void {
        $cleanedTitle = trim($title);
        if (empty($cleanedTitle)) {
            throw new Exception("Le titre de la tâche ne peut pas être vide.");
        }
        $this->title = $cleanedTitle;
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

    public function setDueDate(string $due_date): void {
        $d = DateTime::createFromFormat('Y-m-d', $due_date);
        if ($d && $d->format('Y-m-d') === $due_date) {
            $this->due_date = $due_date;
        } else {
            throw new Exception("Le format de la date d'échéance doit être AAAA-MM-JJ.");
        }
    }

    public function setIdUser(?int $id_user): void {
        $this->id_user = $id_user;
    }

    public function setIdStatusType(int $id_status_type): void {
        $this->id_status_type = $id_status_type;
    }

    public function setIdPriorityLevel(int $id_priority_level): void {
        $this->id_priority_level = $id_priority_level;
    }
}
