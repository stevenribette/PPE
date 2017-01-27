import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MainCenterComponent } from './main-center/main-center.component';
import { MainSidenavComponent } from './main-sidenav/main-sidenav.component';
import { MaterialModule } from '@angular/material';
import { mainRouting } from './main.routing';

@NgModule({
  imports: [
    CommonModule,
    MaterialModule,
    mainRouting
  ],
  declarations: [MainCenterComponent, MainSidenavComponent]
})
export class MainModule { }
