# TODO API with Laravel

## Pre-Requisites

1. Docker needs to be installed.
2. Postman is needed for api endpoints testing.

## How to setup

1. Clone this repo: `git clone git@github.com:edgarmluzardoc/laravel-todo-api.git`
2. Go to the root directory of the repo you just cloned.
3. Update your vendor files. Run:
    ```
    composer update
    ```

4. Run Docker compose:
    ```
    docker-compose up -d
    ```

5. Run database migration:
    ```
    php artisan migrate
    ```

6. Run database seeder:
    ```
    php artisan db:seed
    ```
    NOTE: Because this project is dockerised, the previous command will set up the database so a sql dump is not needed. However, find a example sql file here: https://github.com/edgarmluzardoc/laravel-todo-api/blob/master/doc/mig_db_2019-06-04.sql

7. Go to: http://localhost:8080/

8. You are all set! You should see the default Lavarel welcome page.

## Testing endpoints

1. Run the following on Postman:

    | Description | Method | URL | Params Required | Params Optional |
    |-|-|-|-|-|
    | Return a list of tasks | GET | `http://localhost:8080/api/tasks` | N/A | N/A |
    | Add a task | POST | `http://localhost:8080/api/task?title={title}&date={date}&userIds={userIds}` | `title`, `date` | `userIds` |
    | Edit a task | PUT, PATCH | `http://localhost:8080/api/task/{taskId}?title={title}&date={date}&userIds={userIds}` | `taskId` | `title`, `date`, `userIds` |
    | Delete a task | DELETE | `http://localhost:8080/api/task/{taskId}` | `taskId` | N/A |
    | Mark a task as complete | PUT | `http://localhost:8080/api/task/{taskId}/completed?userId={userId}` | `taskId`, `userId` | N/A |

    NOTE: Find an example collection (you can import it into Postman) for all endpoints here: https://github.com/edgarmluzardoc/laravel-todo-api/blob/master/doc/Todo%20API.postman_collection.json

## Database credentials

- Database: `mig_db`
- Host: `127.0.0.1`
- Username: `root`
- Password: `secret`
- Port: `33063`

## Further optimisations

For POST endpoint, the params can be passed as a payload in body in json format.