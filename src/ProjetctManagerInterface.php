<?php
interface ProjectManagerInterface {
    public function getProjects(): array;
    public function getProjectById(int $id): ?Project;
    public function addProject(Project $project): bool;
    public function updateProject(Project $project): bool;
    public function removeProject(int $id): bool;
    public function getStatusTypes(): array;
}
