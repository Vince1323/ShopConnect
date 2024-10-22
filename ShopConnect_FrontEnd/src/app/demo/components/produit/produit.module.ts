import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ButtonModule } from 'primeng/button';
import { ProduitComponent } from './produit.component';
import { ProduitRoutingModule } from './produit-routing.module';
import { TableModule } from 'primeng/table';
import { DialogModule } from 'primeng/dialog';
import { InputTextModule } from 'primeng/inputtext';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { ConfirmationService } from 'primeng/api';

@NgModule({
    declarations: [ProduitComponent],
    imports: [
        CommonModule,
        FormsModule,
        ButtonModule,
        ProduitRoutingModule,
        TableModule,
        DialogModule,
        InputTextModule,
        ConfirmDialogModule,
    ],
    providers: [ConfirmationService],
    exports: [ProduitComponent]
})
export class ProduitModule { }
