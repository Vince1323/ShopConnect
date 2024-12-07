import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { BoutiqueComponent } from './boutique.component';
import { AuthGuard } from '../auth/auth.guard';

@NgModule({
    imports: [
        RouterModule.forChild([{ path: '', component: BoutiqueComponent, canActivate: [AuthGuard] }]),
    ],
    exports: [RouterModule],
})
export class BoutiqueRoutingModule { }
