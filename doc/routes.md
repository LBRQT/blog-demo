# Routes

| URL | Méthode HTTP | Contrôleur | Méthode |
|-|-|-|-|
|/| GET | MainController | show |
|/login| GET | LoginController | login |
|/signin| GET POST | LoginController | signIn |
|/logout| GET | LoginController | logout |
|/post/{id}| GET | PostController | showDetail |
|/post/add| POST | PostController | add |
|/post/{id}/edit| GET PATCH | PostController | edit |
|/post/{id}/delete| GET DELETE | PostController | delete |
|/comment/add| POST | CommentController | add |
|/comment/{id}/edit| GET PATCH | CommentController | edit |
|/comment/{id}/delete| GET DELETE | CommentController | delete |
