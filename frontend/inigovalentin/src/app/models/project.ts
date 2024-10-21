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
  license?: any[];
}
