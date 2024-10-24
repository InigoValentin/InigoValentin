import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProjecPreviewComponent } from './projec-preview.component';

describe('ProjecPreviewComponent', () => {
  let component: ProjecPreviewComponent;
  let fixture: ComponentFixture<ProjecPreviewComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ProjecPreviewComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProjecPreviewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
