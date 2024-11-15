/**
 * @file Provides a service to handle the page title and meta tags.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import {Injectable} from '@angular/core';
import {Title, Meta} from '@angular/platform-browser';
import {Router, NavigationEnd, ActivatedRoute} from '@angular/router';
import {filter, map, mergeMap} from 'rxjs/operators';

@Injectable({providedIn: 'root'})

/**
 * Manages the page title and meta tags.
 */
export class MetaService {

  /**
   * Constructor.
   *
   * @param titleService The service for handling page title.
   * @param meta Meta tag information.
   * @param router The app router.
   * @param activatedRoute The active route.
   */
  constructor(
    private titleService: Title, private meta: Meta,
    private router: Router, private activatedRoute: ActivatedRoute
  ){}

  /**
   * Sets a meta tag.
   *
   * @param name Tag name.
   * @param value Value for the tag.
   */
  setMetaTag(name: string, value: string){this.meta.updateTag({name: name, content: value});}

  /**
   * Sets the page title.
   *
   * @param title The title for the page. If not specified, the title defined in routes will be used.
   */
  setTitle(title?: string) {
    if (!title){
      this.router.events.pipe(
        filter((event) => event instanceof NavigationEnd),
        map(() => this.activatedRoute),
        map((route) => {
          while (route.firstChild) { route = route.firstChild;}
          return route;
        }),
        filter((route) => route.outlet === 'primary'),
        mergeMap((route) => route.data)
      ).subscribe((event) => {this.titleService.setTitle(event['title']);});
    }
    else this.titleService.setTitle(title);
  }
}
