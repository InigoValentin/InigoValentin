import { Injectable, inject } from '@angular/core';
import { Input } from '@angular/core';
import { Component } from '@angular/core';
import { Project } from '../../models/project';
import { DatePipe } from '@angular/common';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-project',
  standalone: true,
  imports: [DatePipe, RouterModule],
  templateUrl: './project.component.html',
  styleUrl: './project.component.css'
})
export class ProjectComponent {
  @Input() project!: Project;
}
