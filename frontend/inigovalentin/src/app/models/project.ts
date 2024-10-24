import { License } from './license';

export interface Project {
  id: number;
  permalink: string;
  user: number;
  idx: number;
  type: string;
  title: string;
  logo: string;
  header: number;
  text: string;
  comment: string;
  license?: License;
  tags?: any[];
  "project-urls": any[];
  "project-images": any[];
}
