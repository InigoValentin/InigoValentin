/**
 * @file Provides a component for the page footer.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {Component} from '@angular/core';
import {AsyncPipe, NgFor, NgIf} from '@angular/common';
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
  imports: [AsyncPipe, NgFor, MessageComponent],
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
  public constructor(private userService: UserService, private localeService: LocaleService){}

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
    this.localeService.getAvailableLangs().subscribe({
      next: (langs) => {this.availableLangs = langs;},
      error: (error) => {this.errorMessage = error;},
    });

  }
}
