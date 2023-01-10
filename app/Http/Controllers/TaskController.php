<?php


namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\File;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Отобразить список ресурсов.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:task-list', ['only' => ['index']]);
        $this->middleware('permission:task-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task-edit', ['only' => ['done']]);
    }

    /**
     * Отобразить список ресурсов.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = DB::table('tasks')
            ->leftJoin('files', 'tasks.file_id', '=', 'files.id')
            ->orderBy('tasks.created_at', 'desc')
            ->select(['tasks.*', 'files.name as file_name'])
            ->paginate(25);

        return view('tasks.index', compact('tasks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Отобразить форму для создания нового ресурса.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create', []);
    }

    /**
     * Поместить только что созданный ресурс в хранилище.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        request()->validate([
            'id' => 'required|numeric|min:1|unique:tasks',
            'name' => 'required|string',
            'description' => 'required|string',
            'file' => 'required|mimes:doc,txt,xls',
            'started_at' => 'required|date|tasks_limit',
            'ended_at' => 'required|date|after:started_at'
        ]);

        $newTask = Task::create($request->all());

        if (!empty($request->file)) {

            $fileName = $newTask->id . '.' . $request->file->extension();

            $type = $request->file->getClientMimeType();
            $size = $request->file->getSize();

            $request->file->move(public_path('storage'), $fileName);

            $newFile = File::create([
                'user_id' => auth()->id(),
                'name' => $fileName,
                'type' => $type,
                'size' => $size
            ]);

            $newTask->file_id = $newFile->id;
            $newTask->update();

        }

        return redirect()->back()
            ->with('success', 'Task created successfully.');
    }

    /**
     * Обновить указанный ресурс в хранилище.
     *
     * @param \Illuminate\Http\Request $request
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function done(Request $request)
    {
        request()->validate([
            'done' => 'required|integer',
        ]);

        Task::where('id', '=', $request->post('done'))->update([
            'done_flag' => true
        ]);

        return redirect()->back()
            ->with('success', 'Task updated successfully');
    }


}
