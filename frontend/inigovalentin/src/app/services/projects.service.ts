/*import { Injectable, inject } from '@angular/core';
import { environment } from '../../environments/environment';
import { HttpClient } from '@angular/common/http';
import { Project } from '../models/project';
import { Projects } from '../models/projects';
import { map } from 'rxjs';
*/

import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Injectable } from '@angular/core';
import { Projects } from '../models/projects';
import { Project } from '../models/project';

@Injectable({
  providedIn: 'root'
})
export class ProjectsService {

  /*private apiUrl = 'http://localhost:8080/API/';
  private httpClient = inject(HttpClient);
  constructor() { console.log("PROJECTS SERVICE");}

  fetchProjectById(id: string) {
    console.log("FETCH BY ID: " + id);
    return this.httpClient.get<Project>(`${this.apiUrl}/projects/${id}`)
  }

  fetchAll(pageNumber: number) {
    console.log("FETCH ALL: " + pageNumber);
    return this.httpClient.get<Projects>(`${this.apiUrl}/projects/`)
  }*/

  apiUrl = 'http://localhost:8080/api/projects/';

  constructor(private http: HttpClient) {}

  getAllProjects(): Observable<Project[]> {
    console.log("GETALL");
    return this.http.get<Project[]>(this.apiUrl);
  }


}
