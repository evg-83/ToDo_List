<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\StoreRequest;
use App\Http\Requests\Todo\UpdateRequest;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->route('fetchall');
    }

    /** handle fetch all todos ajax request */
    public function fetchAll(Request $request)
    {
        $tags  = Tag::all();

        $query = Todo::query();

        if (isset($request->title) && $request->title != null) {
            $query->where('task', 'like', '%' . $request->title . '%');
        }

        $tagIds = $request->tag_ids;

        if (isset($tagIds) && $tagIds != null) {
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags.id', $tagIds);
            });
        }

        $todos = $query->get();

        return view('fetchall', compact('todos', 'tags'));
    }

    public function storeTags(Request $request)
    {
        $tagsData = ['title' => $request->title];

        Tag::firstOrCreate($tagsData);

        return response()->json([
            'status' => 200,
        ]);
    }

    /** handle insert a new todo ajax request */
    public function store(Request $request, StoreRequest $storeRequest)
    {
        $file = $request->file('image');

        if ($file) {
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/images', $fileName);
        }

        $data = $storeRequest->validated();

        if (isset($data['tag_ids'])) {
            $tagIds = $data['tag_ids'];
            unset($data['tag_ids']);
        }

        $userId = auth()->user()->id;

        $todoData = [
            'task'    => $request->task,
            'user_id' => $userId,
        ];

        $todo = Todo::firstOrCreate($todoData);

        if (isset($tagIds)) {
            $todo->tags()->attach($tagIds);
        }

        $imageData = [
            'todo_id' => $todo->id,
            'image' => $fileName,
        ];

        if ($file) {
            Image::firstOrCreate($imageData);
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    /** handle edit an todo ajax request */
    public function edit(Request $request)
    {
        $id = $request->id;
        $todo = Todo::find($id);

        return response()->json($todo);
    }

    /** handle update an todo ajax request */
    public function update(Request $request, UpdateRequest $updateRequest)
    {
        $fileName = '';
        $todo     = Todo::find($request->todos_id);

        $data = $updateRequest->validated();

        if (isset($data['tag_ids'])) {
            $tagIds = $data['tag_ids'];
            unset($data['tag_ids']);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/images', $fileName);

            if ($todo->images?->image) {
                Storage::delete('public/images' . $todo->images->image);
            }
        } else {
            $fileName = $request->todo_image;
        }

        $todoData = [
            'task'    => $request->task,
        ];

        $todo->update($todoData);

        if (isset($tagIds)) {
            $todo->tags()->sync($tagIds);
        }

        $imageData = [
            'todo_id' => $todo->id,
            'image' => $fileName,
        ];

        if ($request->hasFile('image')) {
            if ($todo->images?->image) {
                $todo->images()->update($imageData);
            } else {
                $todo->images()->create($imageData);
            }
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    /** handle delete an todo ajax request */
    public function delete(Request $request)
    {
        $id = $request->id;
        $todo = Todo::find($id);

        if ($todo->images?->image) {
            if (Storage::delete('public/images/' . $todo->images->image)) {
                // $todo->images()->delete();
                Todo::where('id', $id)->delete();
            }
        } else {
            Todo::where('id', $id)->delete();
        }
    }



    /** handle show Image */
    public function showImage(Todo $todo)
    {
        return view('showImage', compact('todo'));
    }

    /** handle edit an image ajax request */
    public function editImage(Request $request)
    {
        $id = $request->id;
        $todo = Todo::find($id);

        return response()->json($todo);
    }

    /** handle update an image ajax request */
    public function updateImage(Request $request)
    {
        $fileName = '';
        $id       = $request->todo_id;
        $todo     = Todo::find($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/images', $fileName);

            if ($todo->images?->image) {
                Storage::delete('public/images' . $todo->images->image);
            }
        } else {
            $fileName = $request->todo_image;
        }

        $imageData = [
            'todo_id' => $todo->id,
            'image' => $fileName,
        ];

        if ($todo->images?->image) {
            $todo->images()->update($imageData);
        } else {
            $todo->images()->create($imageData);
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    /** handle delete image ajax request */
    public function deleteImage(Request $request)
    {
        $id = $request->id;

        $todo = Todo::find($id);

        if (Storage::delete('public/images/' . $todo->images->image)) {
            // $todo->images()->delete();
            Image::where('todo_id', $id)->delete();
        }
    }
}
