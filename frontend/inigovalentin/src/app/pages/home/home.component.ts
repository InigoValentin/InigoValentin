import {Component, inject} from '@angular/core';
import {AsyncPipe, NgFor} from '@angular/common';
import {UserService} from '../../services/user.service';
import {Observable} from 'rxjs';
import {User} from '../../models/user';
import {Project} from '../../models/project';
import {ProjectsService} from '../../services/projects.service';
import {ProjectPreviewComponent} from '../../components/project-preview/project-preview.component';
import {MessageComponent} from '../../components/message/message.component';
declare function openMessage(): any;
declare function closeMessage(): any;

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [AsyncPipe, NgFor, ProjectPreviewComponent, MessageComponent],
  templateUrl: './home.component.html'
})

export class HomeComponent {
  title = 'home';
  user: User | undefined;
  texts: {[key: string]: string} = {};
  projects: Project[] = [];
  errorMessage!: string;
  constructor(private user_service: UserService, private projects_service: ProjectsService){}
  ngOnInit(){
    this.user_service.getUser().subscribe({
      next: (user) => {
        this.user = user;
        this.title = this.user.firstName + " " + this.user.lastName;
        this.user.texts?.forEach((t) => {this.texts[t.key] = t.text;});
      },
      error: (error) => {this.errorMessage = error;},
    });
    this.projects_service.getTopProjects(3).subscribe({
      next: (projects) => {this.projects = projects;},
      error: (error) => {this.errorMessage = error;},
    });

  }
}
