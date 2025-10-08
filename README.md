First level

I designed the models using Eloquent ORM
Relations:
    - one to many 
        - user has many tasks
        - project has many tasks
    - many to many
        - users and projects

Second level

used laravel built in validation.
laravel returns 422 for validation error for other errors we can use middlewares.

Third level 

authentication with sanctum.
using validation.
using eager loading. 
using policy for restricting authorization.
using pagination and cache for query optimizatoin.


Forth level

1 single env for every developer.
no more works in my machice.
faster production insdie staging and production env.

problems and solutions
    - composer installatoin => using cache layer.
    - storage premission => running a command and giving the premission.
    - connection between services => using network.


for runnig the docker do:
    - docker exec -it laravel_app php artisan key:generate
    - docker exec -it laravel_app php artisan migrate


