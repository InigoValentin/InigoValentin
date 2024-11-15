/**
 * @file Provides a component for the home page.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {Component} from '@angular/core';
import {AsyncPipe, NgFor} from '@angular/common';
import {User} from '../../models/user';
import {UserService} from '../../services/user.service';
import {MetaService} from '../../services/meta.service';
import {Project} from '../../models/project';
import {ProjectsService} from '../../services/projects.service';
import {ProjectPreviewComponent} from '../../components/project-preview/project-preview.component';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [AsyncPipe, NgFor, ProjectPreviewComponent],
  templateUrl: './home.component.html'
})

/**
 * The component for the home page.
 */
export class HomeComponent {

  /**
   * The active user.
   */
  protected user: User | undefined;

  /**
   * Texts with user information.
   */
  protected texts: {[key: string]: string} = {};

  /**
   * The list of projects to show in the home page.
   */
  protected projects: Project[] = [];

  /**
   * The error message.
   */
  protected errorMessage!: string;

  /**
   * The constructor.
   *
   * @param metaService Service that handles HTML meta tags.
   * @param userService Service that handles user information.
   * @param projectsService Service that handles projects.
   */
  constructor(private metaService: MetaService, private userService: UserService, private projectsService: ProjectsService){}

  /**
   * Loads on component initialization.
   */
  ngOnInit(){
    this.userService.getUser().subscribe({
      error: (error) => {this.errorMessage = error;},
      next: (user) => {
        this.user = user;
        this.user.texts?.forEach((t) => {this.texts[t.key] = t.text;});
        this.metaService.setTitle(this.user.firstName + " " + this.user.lastName);
        this.metaService.setMetaTag("description", this.texts["TAGLINE"]);
      },
    });
    this.projectsService.getTopProjects(3).subscribe({
      next: (projects) => {this.projects = projects;},
      error: (error) => {this.errorMessage = error;},
    });
  }
}
