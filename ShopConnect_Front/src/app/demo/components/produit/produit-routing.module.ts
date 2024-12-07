import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ProduitComponent } from './produit.component';
import { AuthGuard } from '../auth/auth.guard'; 

const routes: Routes = [
  { path: '', component: ProduitComponent, canActivate: [AuthGuard] }, // Route pour afficher les produits
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ProduitRoutingModule {}
