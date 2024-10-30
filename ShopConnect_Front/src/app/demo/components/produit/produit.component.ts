import { Component, OnInit } from '@angular/core';
import { ProduitService } from '../../service/produit.service';
import { Produit } from '../../model/Produit';

@Component({
  selector: 'app-produit',
  templateUrl: './produit.component.html',
  styleUrls: ['./produit.component.scss']
})
export class ProduitComponent implements OnInit {
  produits: Produit[] = [];
  new: Produit = {} as Produit;
  selectedProduit: Produit | null = null;
  showCreateDialog = false;
  showEditDialog = false;
  viewDetailsVisible = false;

  constructor(private produitService: ProduitService) { }

  ngOnInit(): void {
    this.loadProduits();
  }

  loadProduits(): void {
    this.produitService.getAllProduits().subscribe({
      next: (data) => {
        this.produits = data;
      },
      error: (err) => {
        console.error('Erreur lors du chargement des produits', err);
      }
    });
  }

  newProduit(): void {
    this.new = {} as Produit;
    this.showCreateDialog = true;
  }

  editProduit(produit: Produit): void {
    this.new = { ...produit };
    this.showEditDialog = true;
  }

  saveProduit(): void {
    if (this.new.id) {
      this.produitService.updateProduit(this.new.id, this.new).subscribe({
        next: () => {
          this.loadProduits();
          this.showEditDialog = false;
        },
        error: (err) => {
          console.error('Erreur lors de la mise à jour du produit', err);
        }
      });
    } else {
      this.produitService.insertProduit(this.new).subscribe({
        next: () => {
          this.loadProduits();
          this.showCreateDialog = false;
        },
        error: (err) => {
          console.error('Erreur lors de la création du produit', err);
        }
      });
    }
  }

  viewDetailsProduit(produit: Produit): void {
    this.selectedProduit = produit;
    this.viewDetailsVisible = true;
  }

  confirmDeleteProduit(produit: Produit): void {
    if (confirm(`Êtes-vous sûr de vouloir supprimer le produit ${produit.nom} ?`)) {
      this.produitService.deleteProduit(produit.id).subscribe({
        next: () => {
          this.loadProduits();
        },
        error: (err) => {
          console.error('Erreur lors de la suppression du produit', err);
        }
      });
    }
  }
}
