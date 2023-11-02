<ul class="todo-list">
@foreach($todos as $bullet)  
    @if($bullet->parent_id == $task->id)    
    

        <li class="todo-item-sub">
            <form class="todo-item__form" action="{{route('todos.update', $bullet)}}" method="post">
                @method('PUT')
                @csrf
                <input type="checkbox" name="done" {{ $bullet->done ? 'checked' : null }}>
            </form>
            <div class="todo-item__content">
                <h3>{{ ucfirst($bullet->title) }}</h3>
                <p>{{ $bullet->content }}</p>
            </div>
            <div>
                <!-- @include('layout.todo', ['todos' => $todos, 'task' => $task]) -->
            </div>
        </li>

    @endif

@endforeach

</ul>