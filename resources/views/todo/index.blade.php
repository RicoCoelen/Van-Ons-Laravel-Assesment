<?php /* @var \App\Models\Todo[] $todos */ ?>

@extends('layout.app')

@section('content')
    <div class="container">
        <ul class="todo-list">
        @foreach($todos as $todo)
            @if($todo->parent_id < 1)
            <li class="todo-item">
                <form class="todo-item__form" action="{{route('todos.update', $todo)}}" method="post">
                    @method('PUT')
                    @csrf
                    <input type="checkbox" name="done" {{ $todo->done ? 'checked' : null }}>
                </form>
                <div class="todo-item__content">
                    <h3>{{ ucfirst($todo->title) }}</h3>
                    <p>{{ $todo->content }}</p>
                </div>
                <div>
                    @include('layout.todo', ['tasks' => $todos, 'task' => $todo, 'todos' => $todos])
                </div>
            </li>
            @endif
        @endforeach

        </ul>

        <h2>Create To-do</h2>

        <form action="{{route('todos.store')}}" method="post" class="create-todo">
            @csrf
            <div class="create-todo__input-group">
                <label for="parent">Parent Todo</label>  <!-- generate possible parent todo's -->
                <select name="parent" id="parent">
                    <option value="0">No Parent (Hoofd Taak)</option>
                    @foreach($todos as $todo)
                        <option value="{{ ucfirst($todo->id) }}">{{ ucfirst($todo->title) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="create-todo__input-group">
                <label for="title">Title</label>
                <input id="title" type="text" name="title">
            </div>
            <div class="create-todo__input-group">
                <label for="content">Description</label>
                <textarea id="content" name="content"cols="30" rows="10"></textarea>
            </div>
            <button class="button" type="submit">Save</button>
        </form>
    </div>
@endsection
