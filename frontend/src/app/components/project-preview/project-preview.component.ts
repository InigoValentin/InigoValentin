/**
 * @file Provides a component a project preview, such as those in the home page and project list.
 * @author Inigo Valentin
 * @since 4.0.0
 */

import { Component, Injectable, inject, Input } from '@angular/core';
import { RouterLink, RouterOutlet } from '@angular/router';
import { CommonModule, SlicePipe, NgFor } from '@angular/common';
import { Project } from '../../models/project';

@Component({
  selector: 'app-project-preview',
  standalone: true,
  imports: [SlicePipe, NgFor, RouterLink, RouterOutlet],
  templateUrl: './project-preview.component.html'
})

/**
 * The component for the project preview.
 */
export class ProjectPreviewComponent {
  @Input() project!: Project;
  constructor(){}
}
