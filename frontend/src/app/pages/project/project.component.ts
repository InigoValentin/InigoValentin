/**
 * @file Provides a component for the project view page.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {Component, inject } from '@angular/core';
import {AsyncPipe, NgFor, NgIf} from '@angular/common';
import {ActivatedRoute} from '@angular/router';
import {map} from 'rxjs/operators';
import {Observable} from 'rxjs';
import {UserService} from '../../services/user.service';
import {MetaService} from '../../services/meta.service';
import {Project} from '../../models/project';
import {ProjectsService} from '../../services/projects.service';

declare var curImage: number;
declare var totalImages: number;
declare function showImage(element: any): any;
declare function nextImage(): any;
declare function prevImage(): any;
declare function closeImage(): any;

@Component({
  selector: 'app-project',
  standalone: true,
  imports: [AsyncPipe, NgIf, NgFor],
  templateUrl: './project.component.html'
})

/**
 * The component for the project view page.
 */
export class ProjectComponent {

  /**
   * The project to show.
   */
  protected project: Project | undefined;

  /**
   * The router.
   */
  private activatedRouter = inject(ActivatedRoute);
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
  private ngOnInit() {
    var title: string = "<PROJECT> - <NAME>";
    var description: string = "<PROJECT> - <NAME>";
    this.userService.getUser().subscribe({
      error: (error) => {this.errorMessage = error;},
      next: (user) => {
        title = title.replace("<NAME>", user.firstName + " " + user.lastName);
        description = description.replace("<NAME>", user.firstName + " " + user.lastName);
        this.metaService.setTitle(title);
        this.metaService.setMetaTag("description", description);
      },
    });
    this.activatedRouter.params.pipe(map((p)=> p['projectId'])).subscribe((id) => {
      this.projectsService.getProject(id).subscribe({
        error: (error) => {this.errorMessage = error;},
        next: (project) => {
          this.project = project;
          title = title.replace("<PROJECT>", project.title);
          description = description.replace("<PROJECT>", project.header);
          this.metaService.setTitle(title);
          this.metaService.setMetaTag("description", description);
        }
      });
    });
  }
}

