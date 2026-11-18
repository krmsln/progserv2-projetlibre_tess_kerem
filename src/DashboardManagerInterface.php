<?php
interface DashboardManagerInterface {
    public function getTaskCounts(?int $userId = null): array;
    public function getProjectCount(): int;
    public function getUpcomingTasks(?int $userId = null): array;
    public function getDashboardProjects(?int $userId = null): array;
}
