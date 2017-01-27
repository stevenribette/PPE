import { Routes, RouterModule } from '@angular/router';
import { ModuleWithProviders } from '@angular/core';

import { MainCenterComponent } from './main-center/main-center.component';

export const mainRoutes: Routes = [
	{
		path: '', component: MainCenterComponent,
		children: [
			{ path: '' },
			{ path: ':viewid',
				children: [
					{ path: '' },
					{ path: 'stockage', 	    loadChildren: 'app/main/pages/stockage/stockage.module#StockageModule' },
					{ path: 'clients', 		    loadChildren: 'app/main/pages/clients/clients.module#ClientsModule' },
					{ path: 'personnels', 		loadChildren: 'app/main/pages/personnels/personnels.module#PersonnelsModule' },
                    { path: 'fournisseurs', 	loadChildren: 'app/main/pages/fournisseurs/fournisseurs.module#FournisseursModule' }
				]
			}
		]
	}
];

export const mainRouting = RouterModule.forChild(mainRoutes);