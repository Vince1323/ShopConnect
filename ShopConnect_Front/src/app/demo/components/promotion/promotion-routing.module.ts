import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { PromotionComponent } from './promotion.component';
import { AuthGuard } from '../auth/auth.guard';

@NgModule({
    imports: [
        RouterModule.forChild([{ path: '', component: PromotionComponent, canActivate: [AuthGuard] }]),
    ],
    exports: [RouterModule],
})
export class PromotionRoutingModule { }
