import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ButtonModule } from 'primeng/button';
import { TableModule } from 'primeng/table';
import { DialogModule } from 'primeng/dialog';  
import { FloatLabelModule } from 'primeng/floatlabel';
import { UtilisateurComponent } from './utilisateur.component';
import { UtilisateursRoutingModule } from './utilisateur-routing.module';
import { InputTextModule } from 'primeng/inputtext';

@NgModule({
  declarations: [UtilisateurComponent],
  imports: [
    CommonModule,
    FormsModule,
    ButtonModule,
    TableModule,
    DialogModule,  
    FloatLabelModule,
    UtilisateursRoutingModule,
    InputTextModule
  ],
})
export class UtilisateurModule { }
