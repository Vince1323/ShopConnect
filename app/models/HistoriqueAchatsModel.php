<?php
require_once 'BaseModel.php';

class HistoriqueAchatsModel extends BaseModel {
    public $id;
    public $client_id;
    public $article_id;
    public $date_visite;
    public $diagnostic;
    public $traitement;
    public $commentaires;

    private $table_name = "HistoriqueAchats";

    // Constructeur avec $db comme connexion à la base de données
    public function __construct() {
        parent::__construct();
    }

    // Méthode pour lire toutes les entrées d'historique des achats
    public function lire() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Méthode pour lire une seule entrée d'historique des achats par ID
    public function lireUn($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Méthode pour créer une nouvelle entrée d'historique des achats
    public function creer() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET client_id = ?, article_id = ?, date_visite = ?, diagnostic = ?, traitement = ?, commentaires = ?";

        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $this->client_id = htmlspecialchars(strip_tags($this->client_id));
        $this->article_id = htmlspecialchars(strip_tags($this->article_id));
        $this->date_visite = htmlspecialchars(strip_tags($this->date_visite));
        $this->diagnostic = htmlspecialchars(strip_tags($this->diagnostic));
        $this->traitement = htmlspecialchars(strip_tags($this->traitement));
        $this->commentaires = htmlspecialchars(strip_tags($this->commentaires));

        // Lier les valeurs
        $stmt->bind_param("iissss", $this->client_id, $this->article_id, $this->date_visite, $this->diagnostic, $this->traitement, $this->commentaires);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Méthode pour mettre à jour une entrée d'historique des achats
    public function mettreAJour($id, $data) {
        $query = "UPDATE " . $this->table_name . "
                  SET client_id = ?,
                      article_id = ?,
                      date_visite = ?,
                      diagnostic = ?,
                      traitement = ?,
                      commentaires = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        // Nettoyer les données
        $client_id = htmlspecialchars(strip_tags($data['client_id']));
        $article_id = htmlspecialchars(strip_tags($data['article_id']));
        $date_visite = htmlspecialchars(strip_tags($data['date_visite']));
        $diagnostic = htmlspecialchars(strip_tags($data['diagnostic']));
        $traitement = htmlspecialchars(strip_tags($data['traitement']));
        $commentaires = htmlspecialchars(strip_tags($data['commentaires']));
        $id = htmlspecialchars(strip_tags($id));

        // Lier les valeurs
        if (!$stmt->bind_param('iissssi', $client_id, $article_id, $date_visite, $diagnostic, $traitement, $commentaires, $id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }

    // Méthode pour supprimer une entrée d'historique des achats
    public function supprimer($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        // Nettoyer l'id
        $id = htmlspecialchars(strip_tags($id));

        // Lier l'id
        if (!$stmt->bind_param('i', $id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }

    // Méthode pour rechercher des entrées par client
    public function rechercherParPatient($client_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE client_id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        // Nettoyer l'id du client
        $client_id = htmlspecialchars(strip_tags($client_id));

        // Lier les valeurs
        if (!$stmt->bind_param('i', $client_id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
