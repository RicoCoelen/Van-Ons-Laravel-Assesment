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
            @foreach($todos as $item)  
                @if($bullet->id == $item->parent_id) 
                @php $task->id = $bullet->id @endphp
                    @include('layout.todo', ['todos' => $todos, 'task' => $task])
                @endif
            @endforeach
            </div>
        </li>

    @endif

@endforeach

</ul>