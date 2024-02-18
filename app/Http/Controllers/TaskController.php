<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class TaskController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/tasks",
     *      operationId="getAllTasks",
     *      tags={"Tasks"},
     *      summary="Get list of all tasks",
     *      description="Returns a list of all tasks available in the database.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Task")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = Task::query()->get();
        return response()->json($tasks);
    }

    /**
     * @OA\Post(
     *      path="/api/tasks",
     *      operationId="storeTask",
     *      tags={"Tasks"},
     *      summary="Create a new task",
     *      description="Creates a new task and returns the id of the newly created task.",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"title", "content", "user_id", "status"},
     *              @OA\Property(
     *                  property="title",
     *                  type="string",
     *                  maxLength=255,
     *                  example="New Task Title"
     *              ),
     *              @OA\Property(
     *                  property="content",
     *                  type="string",
     *                  example="Task content details"
     *              ),
     *              @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  example=1
     *              ),
     *              @OA\Property(
     *                  property="status",
     *                  type="integer",
     *                  description="1 for Pending, 2 for In Progress, 3 for Completed",
     *                  example=1
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example=1
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Validation failed for one or more fields."
     *              ),
     *          ),
     *      ),
     * )
     *
     * @param TaskRequest $request
     * @return JsonResponse
     */
    public function store(TaskRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $task = new Task();
        $task->fill($validatedData);
        $task->status = $validatedData['status'];
        $task->user_id = $validatedData['user_id'];
        $task->save();

        return response()->json(['id' => $task->id], 201);
    }

    /**
     * @OA\Get(
     *      path="/api/tasks/{task}",
     *      operationId="getTaskById",
     *      tags={"Tasks"},
     *      summary="Get task details",
     *      description="Returns task data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="task",
     *          description="Task ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Task"
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Task not found"
     *      )
     * )
     *
     * @param int $task_id
     * @return JsonResponse
     */
    public function show(int $task_id): JsonResponse
    {
        $task = Task::query()->find($task_id);
        if (!$task) {
            return response()->json(null, 404);
        }
        return response()->json($task);
    }

    /**
     * @OA\Put(
     *      path="/api/tasks/{taskId}",
     *      operationId="updateTask",
     *      tags={"Tasks"},
     *      summary="Update an existing task",
     *      description="Updates and returns the task data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="taskId",
     *          description="Task ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaskRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Task not found"
     *      )
     * )
     *
     * @param TaskRequest $request
     * @param int $task_id
     * @return JsonResponse
     */
    public function update(TaskRequest $request, int $task_id): JsonResponse
    {
        /**
         * @var Task $task
         */
        $task = Task::query()->find($task_id);
        if (!$task) {
            return response()->json(null, 404);
        }
        $validatedData = $request->validated();
        $task->fill($validatedData);
        $task->status = $validatedData['status'];
        $task->user_id = $validatedData['user_id'];
        $task->save();
        return response()->json(['message' => 'Task updated successfully']);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{task}",
     *     operationId="deleteTask",
     *     tags={"Tasks"},
     *     summary="Delete a task",
     *     description="Deletes a task and returns no content.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     *
     * @param int $task_id
     * @return JsonResponse
     */
    public function destroy(int $task_id): JsonResponse
    {
        /**
         * @var Task $task
         */
        $task = Task::query()->find($task_id);
        if (!$task) {
            return response()->json(null, 404);
        }
        $task->delete();

        return response()->json(null, 204);
    }
}
