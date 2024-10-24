import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Projects } from '../models/projects';
import { Project } from '../models/project';

@Injectable({
  providedIn: 'root'
})
export class ProjectsService {

  apiUrl = 'http://localhost:8080/api/projects/';

  constructor(private http: HttpClient) {}

  getAllProjects(): Observable<Project[]> {
    return this.http.get<Project[]>(this.apiUrl);
  }

  getProject(permalink: String): Observable<Project> {
    return this.http.get<Project>(this.apiUrl + permalink);
  }


}
