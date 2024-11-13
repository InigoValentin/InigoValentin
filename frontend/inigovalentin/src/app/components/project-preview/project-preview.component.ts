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

export class ProjectPreviewComponent {
  title = 'project';
  errorMessage!: string;
  @Input() project!: Project;
  constructor() {}
}
