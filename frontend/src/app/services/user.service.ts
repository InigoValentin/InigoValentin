/**
 * @file Provides a service to get user info.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {User} from '../models/user';
import {environment} from '../../environments/environment';

@Injectable({providedIn: 'root'})

/**
 * Retrieves and stores the user info.
 */
export class UserService {

  /**
   * The URL to get the user info from.
   */
  private apiUrl: string = environment.API_URL + 'user/';

  /**
   * A promise for the active user.
   */
  private user: Observable<User>;

  /**
   * Constructor.
   *
   * Starts the request to get the user info.
   *
   * @param http The HTTP client.
   */
  public constructor(private http: HttpClient){this.user = this.http.get<User>(this.apiUrl);}

  /**
   * Retrieves a user to the active user.
   *
   * @return A promise to the active user.
   */
  public getUser(): Observable<User>{return this.user;}
}
