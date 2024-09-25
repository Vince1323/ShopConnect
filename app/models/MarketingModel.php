<?php
require_once 'BaseModel.php';

class MarketingModel extends BaseModel
{
    // Propriétés représentant les colonnes de la table Marketings
    public $id;
    public $utilisateur_id;
    public $nom;
    public $prenom;
    public $email;
    public $telephone;
    public $date_de_naissance;


    private $table_name = "Marketing";

    // Constructeur avec $db comme connexion à la base de données
    public function __construct()
    {
        parent::__construct();
    }

    // Méthode pour lire tous les Marketings
    public function lire()
    {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Méthode pour lire un seul Marketing par ID
    public function lireUn($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); // Utiliser bind_param au lieu de bindParam
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Méthode pour créer un nouveau Marketing
    public function creer()
    {
        $query = "INSERT INTO " . $this->table_name . " SET  utilisateur_id=:utilisateur_id, nom=:nom, prenom=:prenom, specialite=:specialite, telephone=:telephone";

        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $this->email = htmlspecialchars(strip_tags($this->utilisateur_id));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->telephone = htmlspecialchars(strip_tags($this->telephone));

        // Lier les valeurs
        $stmt->bind_param("isss", $this->utilisateur_id, $this->nom, $this->prenom, $this->telephone);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

        // Méthode pour mettre à jour un secrétaire
        public function mettreAJour($id, $data) {
            $query = "UPDATE " . $this->table_name . "
                      SET
                        utilisateur_id = ?,
                        nom = ?,
                        prenom = ?,
                        telephone = ?
                      WHERE
                        id = ?";

        $stmt = $this->conn->prepare($query);

            if (!$stmt) {
                die("Erreur de préparation de la requête : " . $this->conn->error);
            }

            // Nettoyer les données
            $utilisateur_id = htmlspecialchars(strip_tags($data['utilisateur_id']));
            $nom = htmlspecialchars(strip_tags($data['nom']));
            $prenom = htmlspecialchars(strip_tags($data['prenom']));
            $telephone = htmlspecialchars(strip_tags($data['telephone']));
            $id = htmlspecialchars(strip_tags($id));

            // Lier les nouvelles valeurs
            if (!$stmt->bind_param('isssi', $utilisateur_id, $nom, $prenom, $telephone, $id)) {
                die("Erreur lors de la liaison des paramètres : " . $stmt->error);
            }

            if ($stmt->execute()) {
                return true;
            } else {
                die("Erreur lors de l'exécution de la requête : " . $stmt->error);
            }
        }

    // Méthode pour supprimer un médecin
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

    // Mettre à jour un patient
    public function editPatient($id, $data)
    {
        $query = "UPDATE Patient
                  SET
                    nom = ?,
                    prenom = ?,
                    date_de_naissance = ?,
                    email = ?,
                    telephone = ?,
                    adresse = ?,
                    historique_medical = ?
                  WHERE
                   id = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->conn->error);
        }


        $id = htmlspecialchars(strip_tags($id));
        $nom = htmlspecialchars(strip_tags($data['nom']));
        $prenom = htmlspecialchars(strip_tags($data['prenom']));
        $date_de_naissance = htmlspecialchars(strip_tags($data['date_de_naissance']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $telephone = htmlspecialchars(strip_tags($data['telephone']));
        $adresse = htmlspecialchars(strip_tags($data['adresse']));
        $historique_medical = htmlspecialchars(strip_tags($data['historique_medical']));

        if (!$stmt->bind_param('sssssssi', $nom, $prenom, $date_de_naissance, $email, $telephone, $adresse, $historique_medical, $id)) {
            die("Erreur lors de la liaison des paramètres : " . $stmt->error);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }

        return false;
    }
    
    // Méthode pour lister tous les rendez-vous
    public function listerAchat()
    {
        $query = "SELECT * FROM achat";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function lireArticles()
    {
        $query = "SELECT * FROM article";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function lireClients()
    {
        $query = "SELECT * FROM client";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function creerAchat($data)
    {
        $query = "INSERT INTO achat (article_id, client_id, date_heure, raison, statut, commentaires) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iissss", $data['article_id'], $data['client_id'], $data['date_heure'], $data['raison'], $data['statut'], $data['commentaires']);
        return $stmt->execute();
    }

    // Méthode pour rechercher un rendez-vous par ID
    public function rechercherAchatParID($id)
    {
        $query = "SELECT * FROM achat WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $stmt->bind_param('i', $id);

        $stmt->execute();
        return $stmt->get_result();
    }

    public function getConfirmedAchat()
    {
        $query = "SELECT * FROM achat WHERE statut = 'confirme'";
        $result = $this->conn->query($query);
        return $result;
    }

    public function getPendingAchat()
    {
        $query = "SELECT * FROM achat WHERE statut = 'en_attente'";
        $result = $this->conn->query($query);
        return $result;
    }

    public function getCancelledAchat()
    {
        $query = "SELECT * FROM achat WHERE statut = 'annule'";
        $result = $this->conn->query($query);
        return $result;
    }
    
    public function changerStatut($id, $statut)
    {
        $query = "UPDATE achat SET statut = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('si', $statut, $id);
        $stmt->execute();
    }
}