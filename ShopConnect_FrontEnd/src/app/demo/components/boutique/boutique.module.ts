import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ButtonModule } from 'primeng/button';
import { BoutiqueComponent } from './boutique.component';
import { BoutiqueRoutingModule } from './boutique-routing.module';
import { TableModule } from 'primeng/table';
import { DialogModule } from 'primeng/dialog';
import { InputTextModule } from 'primeng/inputtext';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { ConfirmationService } from 'primeng/api';

@NgModule({
    declarations: [BoutiqueComponent],
    imports: [
        CommonModule,
        FormsModule,
        ButtonModule,
        BoutiqueRoutingModule,
        TableModule,
        DialogModule,
        InputTextModule,
        ConfirmDialogModule,
    ],
    providers: [ConfirmationService],
    exports: [BoutiqueComponent]
})
export class BoutiqueModule { }
