import {Routes} from '@angular/router';
import {HomeComponent} from './pages/home/home.component';
import {ProfileComponent} from './pages/profile/profile.component';
import {ProjectsComponent} from './pages/projects/projects.component';
import {ProjectComponent} from './pages/project/project.component';

export const routes: Routes = [
  {
    path: 'profile',
    component: ProfileComponent,
    data: {title: 'About me', description:'About me description'}
  },
  {
    path: 'projects',
    component: ProjectsComponent,
    data: {title: 'Projects', description:'Projects description'}
  },
  {
    path: 'projects/:projectId',
    component: ProjectComponent,
    data: {title: '#', description:'#'}
  },
  {
    path: '',
    component: HomeComponent,
    pathMatch: 'full',
    data: {title: '#', description:'Home description'}
  },
];

