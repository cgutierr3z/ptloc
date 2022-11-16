// IMPORTS NECESARIOS
import { ModuleWithProviders } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

// Importar componentes
import { LoginComponent } from './components/login/login.component';
import { RegisterComponent } from './components/register/register.component';
import { ErrorComponent } from './components/error/error.component';
import { HomeComponent } from './components/home/home.component';
import { UserEditComponent } from './components/user-edit/user-edit.component';
import { BookListComponent } from './components/book-list/book-list.component';
import { BookNewComponent } from './components/book-new/book-new.component';
import { BookDetailComponent } from './components/book-detail/book-detail.component';
import { CommentListBookComponent } from './components/comment-list-book/comment-list-book.component';

// Definir rutas
const appRoutes: Routes = [
    { path: '', component: HomeComponent},
    { path: 'inicio', component: HomeComponent},
    { path: 'login', component: LoginComponent},
    { path: 'logout/:sure', component: LoginComponent},
    { path: 'registro', component: RegisterComponent},
    { path: 'ajustes', component: UserEditComponent},
    { path: 'libros', component: BookListComponent},
    { path: 'libro/crear', component: BookNewComponent},
    { path: 'libro/:id', component: BookDetailComponent},
    { path: 'comentario/libro/:id', component: CommentListBookComponent},
    
    { path: '**', component: ErrorComponent},
];

// EXPORTAR CONFIGURACIÓN
export const appRoutingProviders: any[] = [];
export const routing: ModuleWithProviders<RouterModule> = RouterModule.forRoot(appRoutes);

