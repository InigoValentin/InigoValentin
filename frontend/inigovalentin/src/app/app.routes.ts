import { Routes } from '@angular/router';
import { HomeComponent } from './pages/home/home.component';
import { ProjectsComponent } from './pages/projects/projects.component';
import { ProjectComponent } from './pages/project/project.component';

export const routes: Routes = [
  {
    path: 'projects',
    component: ProjectsComponent,
  },
  {
    path: 'projects/:projectId',
    component: ProjectComponent,
  },
  {
    path: '',
    component: HomeComponent,
    pathMatch: 'full',
  },
];

