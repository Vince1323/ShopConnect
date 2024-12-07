import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { UtilisateurComponent } from './utilisateur.component'; 
import { AuthGuard } from '../auth/auth.guard';

@NgModule({
    imports: [
        RouterModule.forChild([{ path: '', component: UtilisateurComponent, canActivate: [AuthGuard] }]),
    ],
    exports: [RouterModule],
})
export class UtilisateursRoutingModule { } // Renommage du module
