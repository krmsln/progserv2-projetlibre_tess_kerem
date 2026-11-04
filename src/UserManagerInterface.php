<?php
interface UserManagerInterface {
    public function getUsers(): array;
    public function getUserById(int $id): ?User;
    public function getUserByEmail(string $email): ?User;
    public function addUser(User $user): bool;
    public function updateUser(User $user): bool;
    public function updateProfileUser(User $user): bool;
    public function removeUser(int $id): bool;
    public function emailAlreadyUsed(string $email, int $userId): bool;
}
