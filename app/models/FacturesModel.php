<?php
require_once 'BaseModel.php';

class FacturesModel extends BaseModel {
    public $id;
    public $rendezvous_id;
    public $montant;
    public $statut_paiement;
    public $date_facture;

    private $table_name = "Facture";

    public function __construct() {
        parent::__construct();
    }

    // Méthode pour lire toutes les factures
    public function lire() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Méthode pour lire une facture par ID
    public function lireUn($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Méthode pour créer une nouvelle facture
    public function creer($data) {
        $query = "INSERT INTO " . $this->table_name . " (rendezvous_id, montant, statut_paiement, date_facture) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $rendezvous_id = htmlspecialchars(strip_tags($data['rendezvous_id']));
        $montant = htmlspecialchars(strip_tags($data['montant']));
        $statut_paiement = htmlspecialchars(strip_tags($data['statut_paiement']));
        $date_facture = htmlspecialchars(strip_tags($data['date_facture']));

        // Lier les valeurs
        $stmt->bind_param("idss", $rendezvous_id, $montant, $statut_paiement, $date_facture);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Méthode pour mettre à jour une facture
    public function mettreAJour($id, $data) {
        if (isset($data['date_facture'])) {
            $query = "UPDATE " . $this->table_name . "
                      SET montant = ?,
                          statut_paiement = ?,
                          date_facture = ?
                      WHERE id = ?";

            $stmt = $this->conn->prepare($query);

            if (!$stmt) {
                die("Erreur de préparation de la requête : " . $this->conn->error);
            }

            // Nettoyer les données
            $montant = htmlspecialchars(strip_tags($data['montant']));
            $statut_paiement = htmlspecialchars(strip_tags($data['statut_paiement']));
            $date_facture = htmlspecialchars(strip_tags($data['date_facture']));
            $id = htmlspecialchars(strip_tags($id));

            // Lier les valeurs
            if (!$stmt->bind_param('dssi', $montant, $statut_paiement, $date_facture, $id)) {
                die("Erreur lors de la liaison des paramètres : " . $stmt->error);
            }
        } else {
            $query = "UPDATE " . $this->table_name . "
                      SET montant = ?,
                          statut_paiement = ?
                      WHERE id = ?";

            $stmt = $this->conn->prepare($query);

            if (!$stmt) {
                die("Erreur de préparation de la requête : " . $this->conn->error);
            }

            // Nettoyer les données
            $montant = htmlspecialchars(strip_tags($data['montant']));
            $statut_paiement = htmlspecialchars(strip_tags($data['statut_paiement']));
            $id = htmlspecialchars(strip_tags($id));

            // Lier les valeurs
            if (!$stmt->bind_param('dsi', $montant, $statut_paiement, $id)) {
                die("Erreur lors de la liaison des paramètres : " . $stmt->error);
            }
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }

    // Méthode pour supprimer une facture
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
}
?>
