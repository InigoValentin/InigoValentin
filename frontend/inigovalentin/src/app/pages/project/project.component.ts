import { Component, Input, inject } from '@angular/core';
import { ProjectsService } from '../../services/projects.service';
import { AsyncPipe, CurrencyPipe, DatePipe, NgFor, NgIf } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
import { map } from 'rxjs/operators';
import { Observable } from 'rxjs';
import { Project } from '../../models/project';
declare function showImage(element: any): any;
declare function nextImage(): any;
declare function prevImage(): any;
declare function closeImage(): any;
declare var curImage: number;
declare var totalImages: number;

@Component({
  selector: 'app-project',
  standalone: true,
  imports: [AsyncPipe, DatePipe, CurrencyPipe, NgIf, NgFor],
  templateUrl: './project.component.html'
})
export class ProjectComponent {

  /*@Input() projectId: string = '';
  private projectsService = inject(ProjectsService);
  public projectObs$! : Observable<Project>;
  private activatedRouter = inject(ActivatedRoute);*/

  title = 'project';
  projectObs$!: Observable<Project>;
  errorMessage!: string;
  private activatedRouter = inject(ActivatedRoute);

  constructor(private projects_service: ProjectsService) {}

  /*ngOnInit(){
    this.activatedRouter.params.pipe(map((p)=> p['projectId'])).subscribe((id)=>{
      //this.projectObs$ = this.projectsService.fetchProjectById(id);

    })
  }*/
  ngOnInit() {
    this.activatedRouter.params.pipe(map((p)=> p['projectId'])).subscribe((id)=>{
        this.projectObs$! = this.projects_service.getProject(id);
    });
  }

  /**
   * Current image ID for the image viewer.
   */
  //let curImage = 0;

  /**
   * Shows an image in the image viewer.
   *
   * Loads the image and text from the image preview.
   *
   * @param element The clicked img element.
   */
   /* showImage(element: any): any{
    var curImage: number = Number(element.id.substring(4));
    document.getElementById('image_viewer_cover')!.style.display = 'block';
    document.getElementById('image_viewer_cover')!.style.opacity = '1';
    //loadImage(element);
    document.getElementById('image_viewer')!.style.display = 'block';
  }*/

  /**
   * Closes the image viewew.
   */
  /*function closeImage(){
    document.getElementById('image_viewer_cover').style.display = 'none';
    document.getElementById('image_viewer_cover').style.opacity = '0';
    document.getElementById('image_viewer').style.display = 'none';
  }*/

  /**
   * Shows the next image in the image viewer.
   */
  /*function nextImage(){
    curImage = curImage + 1;
    if (curImage > maxImages) curImage = 0;
    loadImage(document.getElementById('img_' + curImage));
  }*/

  /**
   * Shows the previous image in the image viewer.
   */
  /*function prevImage(){
    curImage = curImage - 1;
    if (curImage < 0) curImage = maxImages;
    loadImage(document.getElementById('img_' + curImage));
  }*/

  /**
   * Shows an image in the image viewer.
   *
   * Dont call manually, use {@see showImage} instead.
   *
   * @param element The clicked img element.
   */
  /*function loadImage(element){
    document.getElementById('image_viewer_title').innerHTML = element.title;
    document.getElementById('image_viewer_image').src = element.src;
    document.getElementById('image_viewer_image').srcset = element.srcset;
    document.getElementById('image_viewer_image').alt = element.alt;
    document.getElementById('image_viewer_image').title = element.title;
  }*/
}
