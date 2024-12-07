import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommandeComponent } from './commande.component';
import { AuthGuard } from '../auth/auth.guard';

@NgModule({
    imports: [
        RouterModule.forChild([{ path: '', component: CommandeComponent, canActivate: [AuthGuard] }]),
    ],
    exports: [RouterModule],
})
export class CommandeRoutingModule { }
