/**
 * @file Provides a component for the page footer.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {Component} from '@angular/core';
import {AsyncPipe, NgFor, NgIf} from '@angular/common';
import {TranslatePipe, TranslateDirective, TranslateService} from "@ngx-translate/core";
import {CookieService} from 'ngx-cookie-service';
import {TranslateModule} from "@ngx-translate/core";
import {Navigation, Router} from '@angular/router';
import {User} from '../../models/user';
import {UserService} from '../../services/user.service';
import {Lang} from '../../models/lang';
import {LocaleService} from '../../services/locale.service';
import {MessageComponent} from '../../components/message/message.component';
declare function openMessage(): any;
declare function closeMessage(): any;

@Component({
  selector: 'app-footer',
  standalone: true,
  imports: [AsyncPipe, NgFor, MessageComponent, TranslateModule],
  templateUrl: './footer.component.html'
})

/**
 * The component for the page footer.
 *
 * It includes the name as the logo and the navigation bar.
 */
export class FooterComponent {

  /**
   * The active user.
   */
  protected user: User | undefined;

  /**
   * The active user.
   */
  protected availableLangs: Lang[] = [];

  /**
   * The error message.
   */
  protected errorMessage!: string;

  /**
   * The copyright message.
   */
  protected copyright: string = "Copyright";

  /**
   * The constructor.
   *
   * @param userService Service that handles user information.
   * @param localeService Service that handles localizations.
   */
  public constructor(private userService: UserService, private localeService: LocaleService, private cookieService: CookieService, private router: Router){
    this.availableLangs = this.localeService.getAvailableLangs();
  }

  /**
   * Loads on component initialization.
   */
  private ngOnInit(){
    this.userService.getUser().subscribe({
      error: (error) => {this.errorMessage = error;},
      next: (user) => {
        this.user = user;
        this.copyright = "Copyright " + this.user.firstName + " " + this.user.lastName + " ";
        if (this.user.year)
          this.copyright += this.user.year + " - ";
        this.copyright += new Date().getFullYear();
      },
    });
  }

  /**
   * Switches the app language.
   *
   * It uses the locale service to do so. If the language is changed, the page will reload.
   *
   * @param lang The code of the language to set.
   */
  protected changeLanguage(lang: any) {this.localeService.changeLanguage(lang);}
}
