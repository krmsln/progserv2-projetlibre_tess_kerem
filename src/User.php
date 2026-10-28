<?php

class User {
    private ?int $id;
    private string $name;
    private string $email_address;
    private string $password;
    private int $id_role_type;

    public function __construct(?int $id, string $name, string $email_address, string $password, int $id_role_type) {
        $this->id = $id;
        $this->setName($name);
        $this->setEmailAddress($email_address);
        $this->setPassword($password);
        $this->id_role_type = $id_role_type;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmailAddress(): string {
        return $this->email_address;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getIdRoleType(): int {
        return $this->id_role_type;
    }


    public function setName(string $name): void {
        $this->name = trim($name);
    }

    public function setEmailAddress(string $email_address): void {
        if (filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            $this->email_address = trim($email_address);
        } else {
            throw new Exception("L'adresse e-mail n'est pas valide.");
        }
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }
}
