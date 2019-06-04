# TODO API with Laravel

## Pre-Requisites

1. Docker needs to be installed.
2. Postman is needed for api endpoints testing.

## How to setup

1. Clone this repo: `git@github.com:edgarmluzardoc/laravel-todo-api.git`
2. Run Docker compose on this repo root directory:
    ```
    docker-compose up -d
    ```

3. Go to: http://localhost:8080/

4. You are all set! You should see the default Lavarel welcome page.

## Testing endpoints

1. Run the following on Postman:

    | Description | Method | URL | Params Required | Params Optional |
    |-|-|-|-|-|
    | Return a list of tasks | GET | `http://localhost:8080/api/tasks` | N/A | N/A |
    | Add a task | POST | `http://localhost:8080/api/task?title={title}&date={date}&userIds={userIds}` | `title`, `date` | `userIds` |
    | Edit a task | PUT, PATCH | `http://localhost:8080/api/task/{taskId}?title={title}&date={date}&userIds={userIds}` | `taskId` | `title`, `date`, `userIds` |
    | Delete a task | DELETE | `http://localhost:8080/api/task/{taskId}` | `taskId` | N/A |
    | Mark a task as complete | PUT | `http://localhost:8080/api/task/{taskId}/completed?userId={userId}` | `taskId`, `userId` | N/A |
