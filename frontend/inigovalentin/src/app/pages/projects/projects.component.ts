import { Component, DestroyRef, inject, Input } from '@angular/core';
import { ProjectsService } from '../../services/projects.service';
import { AsyncPipe } from '@angular/common';
import { Project } from '../../models/project';
import { ProjectComponent } from '../../components/project/project.component';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { NgFor } from '@angular/common';

@Component({
  selector: 'app-projects',
  standalone: true,
  imports: [ProjectComponent, NgFor],
  templateUrl: './projects.component.html',
  styleUrl: './projects.component.css'
})
/*export class ProjectsComponent {
  private projectsService  =  inject(ProjectsService);
  private pageNumber  =  1;
  private destroyRef  =  inject(DestroyRef)
  public projectsObs$  =  this.projectsService.fetchAll(this.pageNumber);
  public projectsResults: Project[] = [];
  @Input() project!: Project;
}*/


/*export class ProjectsComponent {
  private projectsService = inject(ProjectsService);
  private pageNumber = 1;
  private destroyRef  =  inject(DestroyRef)
  public projectsObs$ = this.projectsService.fetchAll(this.pageNumber);
  public projectsResults: Project[] = [];


  ngOnInit(){
    this.projectsObs$.pipe(takeUntilDestroyed(this.destroyRef)).subscribe((data) => {
      this.projectsResults = data.results;
    });
  }

  onScroll(): void {
    this.pageNumber++;
    console.log("scrolled!!");

    this.projectsObs$ = this.projectsService.fetchAll(this.pageNumber);
    this.projectsObs$.pipe(takeUntilDestroyed(this.destroyRef)).subscribe((data) => {
      this.projectsResults = this.projectsResults.concat(data.results);
    });

  }

}*/

/*export class ProjectsComponent {
  data$ = this.http.get('http://localhost/API/projects/').pipe(
    map(data => ({ state: "loaded", data })),
    catchError(error => of({ state: "error", error })),
    startWith({state: "loading"})
  );
}*/

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
      error: (error) => {
        this.errorMessage = error;
      },
    });
  }
}
