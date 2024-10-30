import { Component, OnInit } from '@angular/core';
import { AvisService } from '../../service/avis.service';
import { Avis } from '../../model/Avis';
import { ConfirmationService } from 'primeng/api';

@Component({
  selector: 'app-avis',
  templateUrl: './avis.component.html',
  styleUrls: ['./avis.component.scss'],
  providers: [ConfirmationService]
})
export class AvisComponent implements OnInit {

  avis: Avis[] = [];
  show: boolean = false;
  viewDetailsVisible: boolean = false;
  selectedAvis?: Avis;
  new: Avis = {} as Avis;

  constructor(
    public avisService: AvisService,
    private confirmationService: ConfirmationService
  ) { }

  ngOnInit(): void {
    this.refreshAvis();
  }

  newAvis(): void {
    this.new = {} as Avis;
    this.show = true;
  }

  sauver(): void {
    if (this.new.id) {
      this.avisService.updateAvis(this.new.id, this.new).subscribe({
        next: () => {
          this.refreshAvis();
        },
        error: (error) => {
          console.error('Erreur lors de la mise à jour de l\'avis:', error);
        }
      });
    } else {
      this.avisService.insertAvis(this.new).subscribe({
        next: () => {
          this.refreshAvis();
        },
        error: (error) => {
          console.error('Erreur lors de l\'ajout de l\'avis:', error);
        }
      });
    }
    this.show = false;
  }

  private refreshAvis(): void {
    this.avisService.getAllAvis().subscribe({
      next: (avis) => {
        this.avis = avis;
      },
      error: (error) => {
        console.error('Erreur lors de la récupération des avis:', error);
      }
    });
  }
}
