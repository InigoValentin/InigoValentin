/**
 * @file Provides a service to handle languages and localizations.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {environment} from '../../environments/environment';
import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Lang} from '../models/lang';

@Injectable({providedIn: 'root'})

/**
 * Retrieves and stores the user info.
 */
export class LocaleService {

  /**
   * The URL to get the user info from.
   */
  private apiUrl: string = environment.API_URL + 'langs/';

  /**
   * A promise for the active user.
   */
  private availableLangs: Observable<Lang[]>;

  /**
   * Constructor.
   *
   * Starts the request to get language info.
   *
   * @param http The HTTP client.
   */
  public constructor(private http: HttpClient){this.availableLangs = this.http.get<Lang[]>(this.apiUrl);}

  /**
   * Retrieves a user to the active user.
   *
   * @return A promise to the active user.
   */
  public getAvailableLangs(): Observable<Lang[]>{return this.availableLangs;}
}
