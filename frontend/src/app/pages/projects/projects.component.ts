/**
 * @file Provides a component for the project list page.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {Component} from '@angular/core';
import {NgFor} from '@angular/common';
import {UserService} from '../../services/user.service';
import {MetaService} from '../../services/meta.service';
import {Project} from '../../models/project';
import {ProjectsService} from '../../services/projects.service';
import {ProjectPreviewComponent} from '../../components/project-preview/project-preview.component';

@Component({
  selector: 'app-projects',
  standalone: true,
  imports: [NgFor, ProjectPreviewComponent],
  templateUrl: './projects.component.html'
})

/**
 * The component for the project list page.
 */
export class ProjectsComponent {

  /**
  * The list of projects to show in the list.
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
  public constructor(private metaService: MetaService, private userService: UserService, private projectsService: ProjectsService){}

  /**
   * Loads on component initialization.
   */
  private ngOnInit(){
    this.userService.getUser().subscribe({
      error: (error) => {this.errorMessage = error;},
      next: (user) => {
        this.metaService.setTitle("Projects - " + user.firstName + " " + user.lastName);
        this.metaService.setMetaTag("description", "List of projects by " + user.firstName + " " + user.lastName);
      },
    });
    this.projectsService.getAllProjects().subscribe({
      next: (projects) => {this.projects = projects;},
      error: (error) => {this.errorMessage = error;},
    });
  }
}
