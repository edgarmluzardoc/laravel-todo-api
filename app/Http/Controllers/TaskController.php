<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
        // Validating fields needed
        $data = $this->request->all();
        $validator = Validator::make($data, [
            'title' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->formatResponse('Error', Response::HTTP_BAD_REQUEST, null, $validator->messages());
        }

        // Creating task
        $this->task->title = $data['title'];
        $this->task->date = $data['date'];
        $this->task->save();

        // Adding users if passed
        if (!empty($data['userIds'])) {
            $userIds = explode(',', $data['userIds']);

            // Validating that user ids exist
            $usersErrors = [];
            foreach ($userIds as $userId) {
                $user = User::find($userId);
                if (empty($user)) {
                    $usersErrors['user'][] = "User id [$userId] not found";
                }
            }

            if (!empty($usersErrors)) {
                return $this->formatResponse('Error', Response::HTTP_NOT_FOUND, null, $usersErrors);
            }
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
        // Check if task id exists
        $task = $this->task->find($id);
        if (empty($task)) {
            return $this->formatResponse('Error', Response::HTTP_NOT_FOUND, null, ['Task id not found']);
        }

        // Checking what data to update from the task
        $data = $this->request->all();
        if (!empty($data['title'])) {
            $task->title = $data['title'];
        }
        if (!empty($data['date'])) {
            $task->date = $data['date'];
        }
        $task->save();

        // Updating users if needed
        if (!empty($data['userIds'])) {
            $task->users()->detach();
            $userIds = explode(',', $data['userIds']);

            // Validating that user ids exist
            $usersErrors = [];
            foreach ($userIds as $userId) {
                $user = User::find($userId);
                if (empty($user)) {
                    $usersErrors['user'][] = "User id [$userId] not found";
                }
            }

            if (!empty($usersErrors)) {
                return $this->formatResponse('Error', Response::HTTP_NOT_FOUND, null, $usersErrors);
            }
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
        // Check if task id exists
        $task = $this->task->find($id);
        if (empty($task)) {
            return $this->formatResponse('Error', Response::HTTP_NOT_FOUND, null, ['Task id not found']);
        }

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
        // Check if task id exists
        $task = $this->task->find($id);
        if (empty($task)) {
            return $this->formatResponse('Error', Response::HTTP_NOT_FOUND, null, ['Task id not found']);
        }

        // Validating fields
        $data = $this->request->all();
        $validator = Validator::make($data, [
            'userId' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->formatResponse('Error', Response::HTTP_BAD_REQUEST, null, $validator->messages());
        }
        
        // Validating that user ids exist
        $userId = $data['userId'];
        $user = User::find($userId);
        if (empty($user)) {
            $usersErrors['user'][] = "User id [$userId] not found";
        }

        if (!empty($usersErrors)) {
            return $this->formatResponse('Error', Response::HTTP_NOT_FOUND, null, $usersErrors);
        }

        // Preparing data for update
        $attributes = [
            'completed' => true,
        ];
        $task->users()->updateExistingPivot($userId, $attributes);

        return $this->formatResponse('Successfully marked as completed', Response::HTTP_OK);
    }
}
