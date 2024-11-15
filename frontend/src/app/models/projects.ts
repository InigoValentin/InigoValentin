import { Project } from './project';

export interface Projects {
  page: number;
  results: Project[];
  total_pages: number;
  total_results: number;
}
