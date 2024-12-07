import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { PanierComponent } from './panier.component';
import { AuthGuard } from '../auth/auth.guard';

@NgModule({
    imports: [
        RouterModule.forChild([{ path: '', component: PanierComponent, canActivate: [AuthGuard] }]),
    ],
    exports: [RouterModule],
})
export class PanierRoutingModule { }
