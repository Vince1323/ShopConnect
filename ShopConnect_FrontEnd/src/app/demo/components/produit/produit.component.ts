import { Component, OnInit } from '@angular/core';
import { ProduitService } from '../../service/produit.service';
import { Produit } from '../../model/Produit';
import { ConfirmationService } from 'primeng/api';

@Component({
  selector: 'app-produit',
  templateUrl: './produit.component.html',
  styleUrls: ['./produit.component.scss'],
  providers: [ConfirmationService]
})
export class ProduitComponent implements OnInit {

  produits: Produit[] = [];
  show: boolean = false;
  viewDetailsVisible: boolean = false;
  selectedProduit?: Produit;
  new: Produit = {} as Produit;

  constructor(
    public produitService: ProduitService,
    private confirmationService: ConfirmationService
  ) { }

  ngOnInit(): void {
    this.refreshProduits();
  }

  viewDetailsProduit(produit: Produit): void {
    this.selectedProduit = produit;
    this.viewDetailsVisible = true;
  }

  editProduit(produit: Produit): void {
    this.new = { ...produit };
    this.show = true;
  }

  confirmDeleteProduit(produit: Produit): void {
    this.confirmationService.confirm({
      message: 'Voulez-vous supprimer ce produit ?',
      accept: () => {
        this.produitService.deleteProduit(produit.id).subscribe({
          next: () => {
            this.refreshProduits();
          },
          error: (error) => {
            console.error('Erreur lors de la suppression du produit:', error);
          }
        });
      }
    });
  }

  newProduit(): void {
    this.new = {} as Produit;
    this.show = true;
  }

  sauver(): void {
    if (this.new.id) {
      this.produitService.updateProduit(this.new.id, this.new).subscribe({
        next: () => {
          this.refreshProduits();
        },
        error: (error) => {
          console.error('Erreur lors de la mise à jour du produit:', error);
        }
      });
    } else {
      this.produitService.insertProduit(this.new).subscribe({
        next: () => {
          this.refreshProduits();
        },
        error: (error) => {
          console.error('Erreur lors de l\'ajout du produit:', error);
        }
      });
    }
    this.show = false;
  }

  private refreshProduits(): void {
    this.produitService.getAllProduits().subscribe({
      next: (produits) => {
        this.produits = produits;
      },
      error: (error) => {
        console.error('Erreur lors de la récupération des produits:', error);
      }
    });
  }
}
