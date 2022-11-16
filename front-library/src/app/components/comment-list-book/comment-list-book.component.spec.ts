import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CommentListBookComponent } from './comment-list-book.component';

describe('CommentListBookComponent', () => {
  let component: CommentListBookComponent;
  let fixture: ComponentFixture<CommentListBookComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CommentListBookComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CommentListBookComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
