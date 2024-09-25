<?php
require_once 'BaseModel.php';

class NotesModel extends BaseModel {
    public $id;
    public $rendezvous_id;
    public $note;
    public $date_creation;

    private $table_name = "Note";

    public function __construct() {
        parent::__construct();
    }

    // Méthode pour lire toutes les notes
    public function lire() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Méthode pour lire une seule note par ID
    public function lireUn($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Méthode pour créer une nouvelle note
    public function creer($data) {
        $query = "INSERT INTO " . $this->table_name . " (rendezvous_id, note, date_creation) VALUES (?, ?, NOW())";

        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $rendezvous_id = htmlspecialchars(strip_tags($data['rendezvous_id']));
        $note = htmlspecialchars(strip_tags($data['note']));

        // Lier les valeurs
        $stmt->bind_param("is", $rendezvous_id, $note);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Méthode pour mettre à jour une note
    public function mettreAJour($id, $data) {
        $query = "UPDATE " . $this->table_name . "
                  SET note = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        // Nettoyer les données
        $note = htmlspecialchars(strip_tags($data['note']));
        $id = htmlspecialchars(strip_tags($id));

        // Lier les nouvelles valeurs
        if (!$stmt->bind_param('si', $note, $id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }

    // Méthode pour supprimer une note
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

    // Méthode pour rechercher des notes par ID de rendez-vous
    public function rechercherParRendezVous($rendezvous_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE rendezvous_id = ?";
        $stmt = $this->conn->prepare($query);

        $rendezvous_id = htmlspecialchars(strip_tags($rendezvous_id));
        $stmt->bind_param('i', $rendezvous_id);

        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
