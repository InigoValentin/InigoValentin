import {ApplicationConfig, provideZoneChangeDetection} from '@angular/core';
import {provideTranslateService} from "@ngx-translate/core";
import {provideHttpClient} from '@angular/common/http';
import {provideRouter} from '@angular/router';

import {routes} from './app.routes';

export const appConfig: ApplicationConfig = {
  providers: [
    provideZoneChangeDetection({ eventCoalescing: true }), provideRouter(routes), provideHttpClient(),
    provideTranslateService({defaultLanguage: 'en'})
  ]

};
