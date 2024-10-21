import { Component, Input, inject } from '@angular/core';
import { ProjectsService } from '../../services/projects.service';
import { AsyncPipe, CurrencyPipe, DatePipe } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
import { map } from 'rxjs/operators';
import { Observable } from 'rxjs';
import { Project } from '../../models/project';

@Component({
  selector: 'app-show-project',
  standalone: true,
  imports: [AsyncPipe, DatePipe, CurrencyPipe],
  templateUrl: './show-project.component.html',
  styleUrl: './show-project.component.css'
})
export class ShowProjectComponent {

  @Input() projectId: string = '';
  private projectsService = inject(ProjectsService);
  public projectObs$! : Observable<Project>;
  private activatedRouter = inject(ActivatedRoute);

  ngOnInit(){
  console.log("TEST");
    this.activatedRouter.params.pipe(map((p)=> p['projectId'])).subscribe((id)=>{
      console.log(id);
      //this.projectObs$ = this.projectsService.fetchProjectById(id);

    })
  }
}
