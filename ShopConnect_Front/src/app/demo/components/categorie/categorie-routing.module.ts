import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CategorieComponent } from './categorie.component';
import { AuthGuard } from '../auth/auth.guard';

@NgModule({
    imports: [
        RouterModule.forChild([{ path: '', component: CategorieComponent, canActivate: [AuthGuard] }]),
    ],
    exports: [RouterModule],
})
export class CategorieRoutingModule { }
