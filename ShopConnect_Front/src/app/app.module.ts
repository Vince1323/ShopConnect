import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { provideHttpClient, withInterceptorsFromDi } from '@angular/common/http';
import {
    HashLocationStrategy,
    LocationStrategy,
    PathLocationStrategy,
} from '@angular/common';
import { FormsModule } from '@angular/forms';  // Pour supporter les formulaires

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';
import { AppLayoutModule } from './layout/app.layout.module';

import { ButtonModule } from 'primeng/button'; // Import du module Button de PrimeNG
import { TableModule } from 'primeng/table'; // Import du module Table de PrimeNG
import { DialogModule } from 'primeng/dialog'; // Import du module Dialog de PrimeNG
import { ConfirmDialogModule } from 'primeng/confirmdialog'; // Import du module ConfirmDialog de PrimeNG
import { ConfirmationService } from 'primeng/api'; // Service de confirmation

@NgModule({ declarations: [
        AppComponent, // Seul AppComponent est déclaré ici
    ],
    bootstrap: [AppComponent], imports: [BrowserModule, // Pour faire fonctionner les appels HTTP
        FormsModule, // Pour supporter les formulaires
        AppRoutingModule,
        AppLayoutModule,
        ButtonModule, // Pour utiliser les boutons de PrimeNG
        TableModule, // Pour utiliser les tableaux de PrimeNG
        DialogModule, // Pour utiliser les dialogues de PrimeNG
        ConfirmDialogModule], providers: [
        { provide: LocationStrategy, useClass: PathLocationStrategy },
        ConfirmationService,
        provideHttpClient(withInterceptorsFromDi()),
    ] })
export class AppModule { }
