<?php
class BaseController {
    protected $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Vérifie si l'utilisateur est connecté
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Vérifie si l'utilisateur est un administrateur
    protected function isAdmin() {
        return $this->isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    // Redirige l'utilisateur vers un emplacement spécifique
    protected function redirect($location) {
        header('Location: ' . $location);
        exit();
    }

    // Chargement des vues
    protected function loadView($viewName, $data = []) {
        extract($data);  // Transforme les clés de l'array $data en variables
        require_once "app/views/{$viewName}.php";
    }
    // Gère les erreurs
    protected function handleError($errorMessage) {
        // Enregistre l'erreur ou redirige vers une page d'erreur
        $this->redirect('index.php?action=error&message=' . urlencode($errorMessage));
    }

}