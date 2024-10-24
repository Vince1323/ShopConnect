import { Component, OnInit } from '@angular/core';
import { UtilisateurService } from '../../service/utilisateur.service';
import { Utilisateur } from '../../model/Utilisateur';

@Component({
  selector: 'app-utilisateur',
  templateUrl: './utilisateur.component.html',
  styleUrls: ['./utilisateur.component.scss']
})

export class UtilisateurComponent implements OnInit {
  utilisateurs: Utilisateur[] = [];
  new: Utilisateur = {} as Utilisateur;
  selectedUtilisateur: Utilisateur | null = null;
  showCreateDialog = false; // Pour afficher ou masquer la modale de création
  showEditDialog = false;   // Pour afficher ou masquer la modale de modification
  viewDetailsVisible = false; // Pour afficher ou masquer la modale des détails

  constructor(private utilisateurService: UtilisateurService) { }

  ngOnInit(): void {
    this.loadUtilisateurs(); // Charger les utilisateurs au démarrage
  }

  loadUtilisateurs(): void {
    this.utilisateurService.getAllUtilisateurs().subscribe({
      next: (data) => {
        this.utilisateurs = data;
      },
      error: (err) => {
        console.error('Erreur lors du chargement des utilisateurs', err);
      }
    });
  }

  // Ouvre le dialogue de création d'un nouvel utilisateur
  newUtilisateur(): void {
    this.new = {} as Utilisateur; // Réinitialiser l'objet new
    this.showCreateDialog = true; // Afficher la modale de création
  }

  // Ouvre le dialogue de modification d'un utilisateur existant
  editUtilisateur(utilisateur: Utilisateur): void {
    this.new = { ...utilisateur }; // Cloner l'utilisateur sélectionné pour modification
    this.showEditDialog = true;    // Afficher la modale de modification
  }

  // Sauvegarde l'utilisateur (création ou mise à jour)
  saveUtilisateur(): void {
    if (this.new.id) {
      // Mise à jour de l'utilisateur
      this.utilisateurService.updateUtilisateur(this.new.id, this.new).subscribe({
        next: () => {
          this.loadUtilisateurs();
          this.showEditDialog = false; // Fermer la modale de modification
        },
        error: (err) => {
          console.error('Erreur lors de la mise à jour de l\'utilisateur', err);
        }
      });
    } else {
      // Création d'un nouvel utilisateur
      this.utilisateurService.insertUtilisateur(this.new).subscribe({
        next: () => {
          this.loadUtilisateurs();
          this.showCreateDialog = false; // Fermer la modale de création
        },
        error: (err) => {
          console.error('Erreur lors de la création de l\'utilisateur', err);
        }
      });
    }
  }

  // Fonction pour afficher les détails d'un utilisateur
  viewDetailsUtilisateur(utilisateur: Utilisateur): void {
    this.selectedUtilisateur = utilisateur;
    this.viewDetailsVisible = true;
  }

  // Confirme la suppression de l'utilisateur
  confirmDeleteUtilisateur(utilisateur: Utilisateur): void {
    if (confirm(`Êtes-vous sûr de vouloir supprimer l'utilisateur ${utilisateur.nom} ?`)) {
      this.utilisateurService.deleteUtilisateur(utilisateur.id).subscribe({
        next: () => {
          this.loadUtilisateurs();
        },
        error: (err) => {
          console.error('Erreur lors de la suppression de l\'utilisateur', err);
        }
      });
    }
  }
}


