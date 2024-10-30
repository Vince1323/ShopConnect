import { Component, OnInit } from '@angular/core';
import { BoutiqueService } from '../../service/boutique.service';
import { Boutique } from '../../model/Boutique';

@Component({
  selector: 'app-boutique',
  templateUrl: './boutique.component.html',
  styleUrls: ['./boutique.component.scss']
})
export class BoutiqueComponent implements OnInit {
  boutiques: Boutique[] = [];
  new: Boutique = {} as Boutique;
  selectedBoutique: Boutique | null = null;
  showCreateDialog = false;
  showEditDialog = false;
  viewDetailsVisible = false;

  constructor(private boutiqueService: BoutiqueService) { }

  ngOnInit(): void {
    this.loadBoutiques();
  }

  loadBoutiques(): void {
    this.boutiqueService.getAllBoutiques().subscribe({
      next: (data) => {
        this.boutiques = data;
      },
      error: (err) => {
        console.error('Erreur lors du chargement des boutiques', err);
      }
    });
  }

  newBoutique(): void {
    this.new = {} as Boutique;
    this.showCreateDialog = true;
  }

  editBoutique(boutique: Boutique): void {
    this.new = { ...boutique };
    this.showEditDialog = true;
  }

  saveBoutique(): void {
    if (this.new.id) {
      this.boutiqueService.updateBoutique(this.new.id, this.new).subscribe({
        next: () => {
          this.loadBoutiques();
          this.showEditDialog = false;
        },
        error: (err) => {
          console.error('Erreur lors de la mise à jour de la boutique', err);
        }
      });
    } else {
      this.boutiqueService.insertBoutique(this.new).subscribe({
        next: () => {
          this.loadBoutiques();
          this.showCreateDialog = false;
        },
        error: (err) => {
          console.error('Erreur lors de la création de la boutique', err);
        }
      });
    }
  }

  viewDetailsBoutique(boutique: Boutique): void {
    this.selectedBoutique = boutique;
    this.viewDetailsVisible = true;
  }

  confirmDeleteBoutique(boutique: Boutique): void {
    if (confirm(`Êtes-vous sûr de vouloir supprimer la boutique ${boutique.nom} ?`)) {
      this.boutiqueService.deleteBoutique(boutique.id).subscribe({
        next: () => {
          this.loadBoutiques();
        },
        error: (err) => {
          console.error('Erreur lors de la suppression de la boutique', err);
        }
      });
    }
  }
}
