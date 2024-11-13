import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {User} from '../models/user';

@Injectable({providedIn: 'root'})
export class UserService {
  apiUrl = 'http://localhost:8080/api/user/';
  constructor(private http: HttpClient) {}
  getUser(): Observable<User> {return this.http.get<User>(this.apiUrl);}
}
