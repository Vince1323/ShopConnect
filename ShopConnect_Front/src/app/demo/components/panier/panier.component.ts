import { Component, OnInit } from '@angular/core';
import { PanierService } from '../../service/panier.service';
import { Panier } from '../../model/Panier';
import { ConfirmationService } from 'primeng/api';

@Component({
  selector: 'app-panier',
  templateUrl: './panier.component.html',
  styleUrls: ['./panier.component.scss'],
  providers: [ConfirmationService]
})
export class PanierComponent implements OnInit {

  paniers: Panier[] = [];
  show: boolean = false;
  viewDetailsVisible: boolean = false;
  selectedPanier?: Panier;
  new: Panier = {} as Panier;

  constructor(
    public panierService: PanierService,
    private confirmationService: ConfirmationService
  ) { }

  ngOnInit(): void {
    this.refreshPaniers();
  }

  viewDetailsPanier(panier: Panier): void {
    this.selectedPanier = panier;
    this.viewDetailsVisible = true;
  }

  editPanier(panier: Panier): void {
    this.new = { ...panier };
    this.show = true;
  }

  confirmDeletePanier(panier: Panier): void {
    this.confirmationService.confirm({
      message: 'Voulez-vous supprimer ce panier ?',
      accept: () => {
        this.panierService.deletePanier(panier.id).subscribe({
          next: () => {
            this.refreshPaniers();
          },
          error: (error) => {
            console.error('Erreur lors de la suppression du panier:', error);
          }
        });
      }
    });
  }

  newPanier(): void {
    this.new = {} as Panier;
    this.show = true;
  }

  sauver(): void {
    if (this.new.id) {
      this.panierService.updatePanier(this.new.id, this.new).subscribe({
        next: () => {
          this.refreshPaniers();
        },
        error: (error) => {
          console.error('Erreur lors de la mise à jour du panier:', error);
        }
      });
    } else {
      this.panierService.insertPanier(this.new).subscribe({
        next: () => {
          this.refreshPaniers();
        },
        error: (error) => {
          console.error('Erreur lors de l\'ajout du panier:', error);
        }
      });
    }
    this.show = false;
  }

  private refreshPaniers(): void {
    this.panierService.getAllPaniers().subscribe({
      next: (paniers) => {
        this.paniers = paniers;
      },
      error: (error) => {
        console.error('Erreur lors de la récupération des paniers:', error);
      }
    });
  }
}
