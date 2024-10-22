import { Component, OnInit } from '@angular/core';
import { BoutiqueService } from '../../service/boutique.service';
import { Boutique } from '../../model/Boutique';
import { ConfirmationService } from 'primeng/api';

@Component({
  selector: 'app-boutique',
  templateUrl: './boutique.component.html',
  styleUrls: ['./boutique.component.scss'],
  providers: [ConfirmationService]
})
export class BoutiqueComponent implements OnInit {

  boutiques: Boutique[] = [];
  show: boolean = false;
  viewDetailsVisible: boolean = false;
  selectedBoutique?: Boutique;
  new: Boutique = {} as Boutique;

  constructor(
    public boutiqueService: BoutiqueService,
    private confirmationService: ConfirmationService
  ) { }

  ngOnInit(): void {
    this.refreshBoutiques();
  }

  viewDetailsBoutique(boutique: Boutique): void {
    this.selectedBoutique = boutique;
    this.viewDetailsVisible = true;
  }

  editBoutique(boutique: Boutique): void {
    this.new = { ...boutique };
    this.show = true;
  }

  confirmDeleteBoutique(boutique: Boutique): void {
    this.confirmationService.confirm({
      message: 'Voulez-vous supprimer cette boutique ?',
      accept: () => {
        this.boutiqueService.deleteBoutique(boutique.id).subscribe({
          next: () => {
            this.refreshBoutiques();
          },
          error: (error) => {
            console.error('Erreur lors de la suppression de la boutique:', error);
          }
        });
      }
    });
  }

  newBoutique(): void {
    this.new = {} as Boutique;
    this.show = true;
  }

  sauver(): void {
    if (this.new.id) {
      this.boutiqueService.updateBoutique(this.new.id, this.new).subscribe({
        next: () => {
          this.refreshBoutiques();
        },
        error: (error) => {
          console.error('Erreur lors de la mise à jour de la boutique:', error);
        }
      });
    } else {
      this.boutiqueService.insertBoutique(this.new).subscribe({
        next: () => {
          this.refreshBoutiques();
        },
        error: (error) => {
          console.error('Erreur lors de l\'ajout de la boutique:', error);
        }
      });
    }
    this.show = false;
  }

  private refreshBoutiques(): void {
    this.boutiqueService.getAllBoutiques().subscribe({
      next: (boutiques) => {
        this.boutiques = boutiques;
      },
      error: (error) => {
        console.error('Erreur lors de la récupération des boutiques:', error);
      }
    });
  }
}
