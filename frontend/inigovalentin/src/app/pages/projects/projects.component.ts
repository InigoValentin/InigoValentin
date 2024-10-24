import { Component, DestroyRef, inject, Input } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { CommonModule, AsyncPipe, NgFor } from '@angular/common';
import { Project } from '../../models/project';
import { ProjectsService } from '../../services/projects.service';
import { ProjectComponent } from '../../components/project/project.component';
import { ProjectPreviewComponent } from '../../components/project-preview/project-preview.component';

declare function showImage(element: any): any

@Component({
  selector: 'app-projects',
  standalone: true,
  imports: [ProjectComponent, NgFor, ProjectPreviewComponent],
  templateUrl: './projects.component.html',
  styleUrl: './projects.component.css'
})

export class ProjectsComponent {
  title = 'projects';
  projects: Project[] = [];
  errorMessage!: string;

  constructor(private projects_service: ProjectsService) {}

  ngOnInit() {
    this.projects_service.getAllProjects().subscribe({
      next: (projects) => {
        this.projects = projects;
        console.log(this.projects);
      },
      error: (error) => {this.errorMessage = error;},
    });
    let node = document.createElement('script');
    node.src = './js/project.j';
    node.type = 'text/javascript';
    node.async = true;
    node.charset = 'utf-8';
    document.getElementsByTagName('head')[0].appendChild(node);
    console.log("LOAD!");
  }
}
