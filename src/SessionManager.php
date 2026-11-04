<?php
class SessionManager {
    public const ROLE_MANAGER = 1;
    public const ROLE_COLLABORATOR = 2;

    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    //aide ia pour la gestion d'id (regeneration de l'id de session pour la protection : id fixe)
    public static function login(User $user): void {
        self::start();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_name'] = $user->getName();
        $_SESSION['user_role'] = $user->getIdRoleType();
    }

    public static function isLoggedIn(): bool {
        self::start();
        return isset($_SESSION['user_id']);
    }


    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header('Location: auth.php?mode=login');
            exit;
        }
    }


    public static function isManager(): bool {
        self::start();
        return isset($_SESSION['user_role']) && (int)$_SESSION['user_role'] === self::ROLE_MANAGER;
    }

    public static function requireManager(): void {
        self::requireLogin();
        if (!self::isManager()) {
            header('Location: dashboard.php?error=forbidden');
            exit;
        }
    }


    public static function getUserId(): ?int {
        self::start();
        return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    }

    public static function getUserName(): ?string {
        self::start();
        return $_SESSION['user_name'] ?? null;
    }

    public static function getUserRole(): ?int {
        self::start();
        return isset($_SESSION['user_role']) ? (int)$_SESSION['user_role'] : null;
    }

    // aide ia pour la déconnexion de sessions (supression des cookies et session serveur)
    public static function logout(): void {
        self::start();
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }
}
