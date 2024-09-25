<?php
require_once 'BaseModel.php';

class AchatModel extends BaseModel
{
    public $id;
    public $article_id;
    public $client_id;
    public $date_heure;
    public $raison;
    public $statut; // Exemple: 'en_attente', 'confirme', 'annule'
    public $commentaires;

    private $table_name = "Achat";

    public function __construct()
    {
        parent::__construct();
    }

    // Méthode pour lire tous les rendez-vous
    public function lire()
    {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Méthode pour lire un seul rendez-vous par ID
    public function lireUn($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Méthode pour créer un nouveau rendez-vous
    public function creer($data)
    {
        $query = "INSERT INTO " . $this->table_name . " (article_id, client_id, date_heure, raison, statut, commentaires) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $article_id = htmlspecialchars(strip_tags($data['article_id']));
        $client_id = htmlspecialchars(strip_tags($data['client_id']));
        $date_heure = htmlspecialchars(strip_tags($data['date_heure']));
        $raison = htmlspecialchars(strip_tags($data['raison']));
        $statut = htmlspecialchars(strip_tags($data['statut']));
        $commentaires = htmlspecialchars(strip_tags($data['commentaires']));

        // Lier les valeurs
        $stmt->bind_param("iissss", $article_id, $client_id, $date_heure, $raison, $statut, $commentaires);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Méthode pour mettre à jour un rendez-vous
    public function mettreAJour($id, $data)
    {
        $query = "UPDATE " . $this->table_name . "
                  SET
                    article_id = ?,
                    client_id = ?,
                    date_heure = ?,
                    raison = ?,
                    statut = ?,
                    commentaires = ?
                  WHERE
                    id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        // Nettoyer les données
        $article_id = htmlspecialchars(strip_tags($data['article_id']));
        $client_id = htmlspecialchars(strip_tags($data['client_id']));
        $date_heure = htmlspecialchars(strip_tags($data['date_heure']));
        $raison = htmlspecialchars(strip_tags($data['raison']));
        $statut = htmlspecialchars(strip_tags($data['statut']));
        $commentaires = htmlspecialchars(strip_tags($data['commentaires']));
        $id = htmlspecialchars(strip_tags($id));

        // Lier les nouvelles valeurs
        if (!$stmt->bind_param('iissssi', $article_id, $client_id, $date_heure, $raison, $statut, $commentaires, $id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }

    // Méthode pour supprimer un rendez-vous
    public function supprimer($id)
    {
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

    // Méthode pour rechercher un rendez-vous par ID
    public function rechercherParID($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $stmt->bind_param('i', $id);

        $stmt->execute();
        return $stmt->get_result();
    }

    public function getConfirmedAchatsByArticleId($article_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE article_id = ? AND statut = 'confirme'";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }

        $article_id = htmlspecialchars(strip_tags($article_id));
        $stmt->bind_param('i', $article_id);

        $stmt->execute();
        return $stmt->get_result();
    }


    public function lireConfirmesParArticle($article_id)
    {
        $query = "SELECT rdv.*, p.nom AS patient_nom, p.prenom AS patient_prenom
                  FROM " . $this->table_name . " rdv
                  JOIN Patient p ON rdv.client_id = p.id
                  WHERE rdv.article_id = ? AND rdv.statut = 'confirme'";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $article_id);
        $stmt->execute();

        return $stmt->get_result();
    }
}