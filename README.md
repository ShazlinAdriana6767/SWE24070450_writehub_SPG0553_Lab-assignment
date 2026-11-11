# WriteHub

Article submission portal for a college writing club, built with Laravel and the Livewire starter kit (Livewire 4, Flux UI, Fortify). Lab Assignment 2 for SPG 0553 Advanced Web Programming, German-Malaysian Institute.

## Features
- Register, login and logout (Fortify)
- Article list, create and edit pages built as Livewire single-file components
- One shared Form Request (`SaveArticleRequest`) for validation, custom messages, attribute names and authorization
- One general Action class (`SaveArticleAction`) for creating and updating articles
- Authorization with a Gate (`publish-article`, admin only) and a Policy (`ArticlePolicy`: author edits, author or admin deletes)

## Setup
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run build
php artisan serve
```


## Seeded accounts (password: `password`)
| Name | Email | Role |
|---|---|---|
| Alice Admin | admin@example.com | Administrator |
| Bob Writer | bob@example.com | Member |
| Carol Writer | carol@example.com | Member |
