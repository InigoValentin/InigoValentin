import {Component, Input} from '@angular/core';
import {RouterOutlet} from '@angular/router';
import {TranslatePipe, TranslateDirective, TranslateService} from "@ngx-translate/core";
import {CookieService} from 'ngx-cookie-service';
import {NavbarComponent} from './components/navbar/navbar.component';
import {FooterComponent} from './components/footer/footer.component';
import {User} from './models/user';
import {MetaService} from './services/meta.service'
import {UserService} from './services/user.service'
import translationsEN from "../assets/i18n/en.json";
import translationsES from "../assets/i18n/es.json";
import translationsEU from "../assets/i18n/eu.json";

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, NavbarComponent, FooterComponent, TranslatePipe, TranslateDirective],
  templateUrl: './app.component.html'
})
export class AppComponent {
  testvar: string = "TEST";
  user: User;
  texts: {[key: string]: string} = {};
  errorMessage!: string;
  constructor(private metaService: MetaService, private userService: UserService, private translateService: TranslateService, private cookieService: CookieService){
    this.user = new User();


    // Register translation languages
    translateService.addLangs(['en', 'es', 'eu']);
    translateService.setTranslation('en', translationsEN);
    translateService.setTranslation('es', translationsES);
    translateService.setTranslation('eu', translationsEU);
    // Set default language
    translateService.setDefaultLang(this.cookieService.get('lang') || 'es');
    translateService.use(this.cookieService.get('lang') || 'es');
  }

  ngOnInit(){
    this.userService.getUser().subscribe({
      error: (error) => {this.errorMessage = error;},
      next: (user) => {
        this.user = user;
        //this.metaService.setTitle(this.user.firstName);
        this.metaService.setMetaTag("author", this.user.firstName + " " + this.user.lastName);
      },
    });
  }

  //Switch language
  changeLanguage(lang: string) {
    this.translateService.use(lang);
  }
}
