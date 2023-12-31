<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('todo.index', [
            'todos' => Todo::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Todo::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'parent_id' => $request->get('parent')
        ]);

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $result = $todo->update([ 'done' => ($request->get('done') === 'on') ]);
        
        // Check if all related records with the same parent ID are done
        if ($result) {
            $parentId = $todo->parent_id;
            if ($parentId) {
                $relatedTodos = Todo::where('parent_id', $parentId)->get();
                $allDone = true;
                foreach ($relatedTodos as $relatedTodo) {
                    if (!$relatedTodo->done) {
                        $allDone = false;
                        break;
                    }
                }
                if ($allDone) {
                    $parentTodo = Todo::find($parentId);
                    if ($parentTodo) {
                        $parentTodo->update(['done' => true]);
                        $response = Http::get('https://api.chucknorris.io/jokes/random');
                        session()->flash('alert-info', $response->value);
                    }
                }
            }
        }

        return response($result, $result ? 200 : 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
