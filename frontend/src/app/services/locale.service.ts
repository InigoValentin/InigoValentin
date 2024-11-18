/**
 * @file Provides a service to handle languages and localizations.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {environment} from '../../environments/environment';
import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {TranslateService} from "@ngx-translate/core";
import {CookieService} from 'ngx-cookie-service';
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
   * The error message.
   */
  private errorMessage!: string;

  /**
   * A promise for the active user.
   */
  private availableLangs: Lang[] = [];

  /**
   * Constructor.
   *
   * Starts the request to get language info.
   *
   * @param http The HTTP client.
   */
  public constructor(
    private http: HttpClient, private translateService: TranslateService,
    private cookieService: CookieService
  ){
    // Initialize default available languages.
    for (const l of environment.LANG.ACCEPTED){
      const lng: Lang = {code: l, name: ""};
      this.availableLangs.push(lng);
    }
    this.http.get<Lang[]>(this.apiUrl).subscribe({
      error: (error) => {this.errorMessage = error;},
      next: async (langs) => {
        this.availableLangs = [];
        for (const lang of langs){
          if (environment.LANG.ACCEPTED.indexOf(lang.code!) !== -1){
            this.availableLangs.push(lang);
            this.translateService.addLangs([lang.code!]);
            this.translateService.setTranslation(
              lang.code!, await import("../../assets/i18n/" + lang.code + ".json")
            );
          }
        }
      }
    });
  }

  /**
   * Sets a language for the application.
   *
   * If the language is set, the page will be reloaded.
   *
   * @param code Code of the language to set.
   * @return True if the language is accepted and it was set (the page will be reloaded), of false
   * if an invalid language was specified.
   */
  private setLanguage(code: string): boolean{
    // Check valid language
    var found: boolean = false;
    for (const lang of this.availableLangs)
      if (lang.code === code){
        found = true;
        break;
      }
    if (!found) return false;
    this.cookieService.set('lang', code);
    this.translateService.setDefaultLang(code);
    this.translateService.use(code);
    location.reload();
    return true;
  }

  /**
   * Obtains the most appropiate language for the application.
   *
   * The criteria is, in this order:
   * - The language defined in the cookie lang, if it exists and its valid.
   * - The first supported language that the browser preffers.
   * - The default language retrieved from the backend.
   * - The default language defined in environment.
   *
   * @return The most appropiate language code.
   */
  public getLanguage(): string{
    // Check if cookie language is a valid language
    var validCookie: boolean = false;
    if (this.cookieService.check('lang')){
      for (const lang of this.availableLangs){
        if (lang.code === this.cookieService.get('lang')){
          validCookie = true;
          break;
        }
      }
    }
    const lang = "" +
      (validCookie ? this.cookieService.get('lang') : false
      || this.availableLangs.length > 0 ? this.availableLangs[0].code : false
      || environment.LANG.DEFAULT);
    return lang;
  }

  /**
   * Changes the language.
   *
   * @param code The code of the language to set.
   * @return True if the language was changed, false otherwise.
   */
  public changeLanguage(code: string): boolean{return this.setLanguage(code)}

  /**
   * Retrieves a user to the active user.
   *
   * @return A promise to the active user.
   */
  public getAvailableLangs(): Lang[]{return this.availableLangs;}
}
