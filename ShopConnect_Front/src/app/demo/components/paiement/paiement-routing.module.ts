import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PaiementComponent } from './paiement.component';
import { AuthGuard } from '../auth/auth.guard';

const routes: Routes = [
  {
    path: '',
    component: PaiementComponent,
    canActivate: [AuthGuard]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PaiementRoutingModule { }
