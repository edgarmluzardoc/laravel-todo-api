<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Class variables
     */
    protected $request;
    protected $task;

    /**
     * Class construct
     *
     * @param Request $request
     * @param Task $task
     */
    public function __construct(Request $request, Task $task)
    {
        $this->request = $request;
        $this->task = $task;
    }

    /**
     * Gets all tasks with its users
     *
     * @return json
     */
    public function getAll()
    {
        $tasks = Task::with('users')->get();
        return $this->formatResponse('Success', Response::HTTP_OK, $tasks);
    }

    /**
     * Creates a tasks
     *
     * @return json
     */
    public function create()
    {
        // TODO validate fields

        // Creating task
        $data = $this->request->all();
        $this->task->title = $data['title'];
        $this->task->date = $data['date'];
        $this->task->save();

        // Adding users if passed
        if (!empty($data['userIds'])) {
            $userIds = explode(',', $data['userIds']);
            $this->task->users()->attach($userIds);
        }

        return $this->formatResponse('Successfully created', Response::HTTP_CREATED);
    }

    /**
     * Updates a tasks
     *
     * @param int $id - Task id to be updated
     * @return json
     */
    public function update($id)
    {
        // TODO validate fields

        $data = $this->request->all();

        $task = $this->task->find($id);

        $task->title = $data['title'];
        $task->date = $data['date'];
        $task->save();

        // Updating users
        $task->users()->detach();
        if (!empty($data['userIds'])) {
            $userIds = explode(',', $data['userIds']);

            $task->users()->attach($userIds);
        }

        return $this->formatResponse('Successfully updated', Response::HTTP_OK);
    }

    /**
     * Remove the specified task
     *
     * @param int $id - Task id to be deleted
     * @return json
     */
    public function delete($id)
    {
        $task = $this->task->find($id);
        $task->users()->detach();
        $task->delete();

        return $this->formatResponse('Successfully deleted', Response::HTTP_OK);
    }

    /**
     * Marks a task as completed
     *
     * @param int $id - Task id to be marked as completed
     * @return json
     */
    public function completed($id)
    {
        //TODO validate fields
        $data = $this->request->all();
        $userId = $data['userId'];
        $attributes = [
            'completed' => true,
        ];

        $task = $this->task->find($id);
        $task->users()->updateExistingPivot($userId, $attributes);

        return $this->formatResponse('Successfully marked as completed', Response::HTTP_OK);
    }
}
