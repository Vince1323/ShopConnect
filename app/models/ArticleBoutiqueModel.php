<?php
require_once 'BaseModel.php';

class ArticleBoutiqueModel extends BaseModel {
    public $article_id;
    public $boutique_id;

    private $table_name = "ArticleBoutique";

    public function __construct() {
        parent::__construct();
    }

    // Méthode pour lire toutes les associations médecin-service
    public function lire() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        if ($stmt->execute()) {
            return $stmt->get_result();
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }

    // Méthode pour lire une association médecin-service par ID du médecin et ID du service
    public function lireUn($article_id, $boutique_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE article_id = ? AND boutique_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        if (!$stmt->bind_param("ii", $article_id, $boutique_id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }

    // Méthode pour créer une nouvelle association médecin-service
    public function creer($data) {
        $query = "INSERT INTO " . $this->table_name . " (article_id, boutique_id) VALUES (?, ?)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        // Nettoyer les données
        $article_id = htmlspecialchars(strip_tags($data['article_id']));
        $boutique_id = htmlspecialchars(strip_tags($data['boutique_id']));

        // Lier les valeurs
        if (!$stmt->bind_param("ii", $article_id, $boutique_id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }

    // Méthode pour mettre à jour une association médecin-service
    public function mettreAJour($article_id, $boutique_id, $data) {
        $query = "UPDATE " . $this->table_name . "
                  SET
                    active = ?
                  WHERE
                    article_id = ? AND boutique_id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        // Nettoyer les données
        $active = htmlspecialchars(strip_tags($data['active']));
        $article_id = htmlspecialchars(strip_tags($article_id));
        $boutique_id = htmlspecialchars(strip_tags($boutique_id));

        // Lier les nouvelles valeurs
        if (!$stmt->bind_param('iii', $active, $article_id, $boutique_id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }

    // Méthode pour supprimer une association 
    public function supprimer() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

    // Nettoyer l'id
        $this->id = htmlspecialchars(strip_tags($this->id));

    // Lier l'id
        $stmt->bind_param("i", $this->id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
