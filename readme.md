## Laravel 8 CRUD (Create, Read, Update, Delete) API's

This is a simple CRUD project created in laravel 8.

All CRUD operations are done through rest api's.

If you want frontend for this project visit here [Angular 11 CRUD API's](https://github.com/abidaks/angular-11-crud).

## Installation

Do the necessary installation for vendor files.

Run `php artisan migrate` to do the necessary migtations.

## Development server

Run `php artisan serve --port=8080` for a dev server. Navigate to `http://localhost:8080/`.

## Project details

There are two entities in the project classes and students.

How many students each class can have is controlled by maximum_students in classes table.

## Classes URL's list

GET: http://localhost:8080/api/classes/list

GET: http://localhost:8080/api/classes/view/{id}

POST: http://localhost:8080/api/classes/add

POST: http://localhost:8080/api/classes/edit

## Students URL's list

GET: http://localhost:8080/api/students/list

GET: http://localhost:8080/api/students/view/{id}

POST: http://localhost:8080/api/students/add

POST: http://localhost:8080/api/students/edit

## License

[MIT license](https://opensource.org/licenses/MIT).
