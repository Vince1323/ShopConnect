import { Component, OnInit } from '@angular/core';
import { CategorieService } from '../../service/categorie.service';
import { Categorie } from '../../model/Categorie';
import { ConfirmationService } from 'primeng/api';

@Component({
  selector: 'app-categorie',
  templateUrl: './categorie.component.html',
  styleUrls: ['./categorie.component.scss'],
  providers: [ConfirmationService]
})
export class CategorieComponent implements OnInit {

  categories: Categorie[] = [];
  show: boolean = false;
  viewDetailsVisible: boolean = false;
  selectedCategorie?: Categorie;
  new: Categorie = {} as Categorie;

  constructor(
    public categorieService: CategorieService,
    private confirmationService: ConfirmationService
  ) { }

  ngOnInit(): void {
    this.refreshCategories();
  }

  viewDetailsCategorie(categorie: Categorie): void {
    this.selectedCategorie = categorie;
    this.viewDetailsVisible = true;
  }

  editCategorie(categorie: Categorie): void {
    this.new = { ...categorie };
    this.show = true;
  }

  confirmDeleteCategorie(categorie: Categorie): void {
    this.confirmationService.confirm({
      message: 'Voulez-vous supprimer cette catégorie ?',
      accept: () => {
        this.categorieService.deleteCategorie(categorie.id).subscribe({
          next: () => {
            this.refreshCategories();
          },
          error: (error) => {
            console.error('Erreur lors de la suppression de la catégorie:', error);
          }
        });
      }
    });
  }

  newCategorie(): void {
    this.new = {} as Categorie;
    this.show = true;
  }

  sauver(): void {
    if (this.new.id) {
      this.categorieService.updateCategorie(this.new.id, this.new).subscribe({
        next: () => {
          this.refreshCategories();
        },
        error: (error) => {
          console.error('Erreur lors de la mise à jour de la catégorie:', error);
        }
      });
    } else {
      this.categorieService.insertCategorie(this.new).subscribe({
        next: () => {
          this.refreshCategories();
        },
        error: (error) => {
          console.error('Erreur lors de l\'ajout de la catégorie:', error);
        }
      });
    }
    this.show = false;
  }

  private refreshCategories(): void {
    this.categorieService.getAllCategories().subscribe({
      next: (categories) => {
        this.categories = categories;
      },
      error: (error) => {
        console.error('Erreur lors de la récupération des catégories:', error);
      }
    });
  }
}
