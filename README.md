First level

I designed the models using Eloquent ORM
Relations
    - one to many 
        - user has many tasks
        - project has many tasks

    - many to many
        - users and projects

Second level

used laravel built in validation for validating 
laravel returns 422 for validation error for other errors we can user middlewares

Third level 

authentication with sanctum
using validation
using eager loading 
using policy for restricting authorization
using pagination and cache for query optimizatoin





