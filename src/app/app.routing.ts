import { Routes, RouterModule, PreloadAllModules } from '@angular/router';
import { ModuleWithProviders } from '@angular/core';
import { LoginComponent } from './login/login.component';
import { AdminModule } from './admin/admin.module';
import { AccountModule } from './account/account.module';
import { MainModule } from './main/main.module';

const appRoutes: Routes = [
  {
    path: '', pathMatch: 'full',
    redirectTo: '/main'
  },
  { path: 'login',   component: LoginComponent },
  { path: 'admin',   loadChildren: 'app/admin/admin.module#AdminModule'        },
  { path: 'account', loadChildren: 'app/account/account.module#AccountModule'  },
  { path: 'main',    loadChildren: 'app/main/main.module#MainModule'           },
];

export const routing = RouterModule.forRoot(appRoutes,
  { preloadingStrategy: PreloadAllModules });
