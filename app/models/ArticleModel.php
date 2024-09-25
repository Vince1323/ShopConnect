<?php
require_once 'BaseModel.php';

class ArticleModel extends BaseModel{
    // Propriétés représentant les colonnes de la table Articles
    public $id;
    public $utilisateur_id;
    public $nom;
    public $prenom;
    public $specialite;
    public $telephone;

    private $table_name = "Article";

    // Constructeur avec $db comme connexion à la base de données
    public function __construct() {
      parent::__construct();
    }

    // Méthode pour lire tous les articles
    public function lire() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Méthode pour lire un seul article par ID
      public function lireUn($id) {
          $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
          $stmt = $this->conn->prepare($query);
          $stmt->bind_param("i", $id); // Utiliser bind_param au lieu de bindParam
          $stmt->execute();
          $result = $stmt->get_result();
          return $result->fetch_assoc();
      }

    // Ajouter d'autres méthodes ici pourmettre à jour, et supprimer des articles

    // Méthode pour créer un nouveau article
    public function creer() {
        $query = "INSERT INTO " . $this->table_name . " SET  utilisateur_id=:utilisateur_id, nom=:nom, prenom=:prenom, specialite=:specialite, telephone=:telephone";

        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $this->email = htmlspecialchars(strip_tags($this-> utilisateur_id));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->specialite = htmlspecialchars(strip_tags($this->specialite));
        $this->telephone = htmlspecialchars(strip_tags($this->telephone));

        // Lier les valeurs
        $stmt->bind_param("issss", $this->utilisateur_id, $this->nom, $this->prenom, $this->specialite, $this->telephone);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

        // Méthode pour mettre à jour un article
        public function mettreAJour($id, $data) {
            $query = "UPDATE " . $this->table_name . "
                      SET
                        utilisateur_id = ?,
                        nom = ?,
                        prenom = ?,
                        specialite = ?,
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
            $specialite = htmlspecialchars(strip_tags($data['specialite']));
            $telephone = htmlspecialchars(strip_tags($data['telephone']));
            $id = htmlspecialchars(strip_tags($id));

            // Lier les nouvelles valeurs
            if (!$stmt->bind_param('issssi', $utilisateur_id, $nom, $prenom, $specialite, $telephone, $id)) {
                die("Erreur lors de la liaison des paramètres : " . $stmt->error);
            }

            if ($stmt->execute()) {
                return true;
            } else {
                die("Erreur lors de l'exécution de la requête : " . $stmt->error);
            }
        }

    // Méthode pour supprimer un article
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
