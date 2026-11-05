<?php
interface TaskManagerInterface {
    public function getTasks(): array;
    public function getTaskById(int $id): ?Task;
    public function getTasksByProjectId(int $projectId): array;
    public function getTasksByUserId(int $userId): array;
    public function addTask(Task $task): bool;
    public function updateTask(Task $task): bool;
    public function updateTaskStatusForUser(int $taskId, int $userId, int $statusId): bool;
    public function removeTask(int $id): bool;
    public function getStatusTypes(): array;
    public function getPriorityLevels(): array;
}
