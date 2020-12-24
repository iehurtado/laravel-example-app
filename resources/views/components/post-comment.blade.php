<div class="card">
    <div class="card-header clearfix">
        <span class="card-title">{{ $comment->author->name ?? 'Anónimo'}} escribió:</span>
        <span class="float-right">
            <a href="{{ route('comments.edit', $comment) }}" class="btn btn-link">Editar</a>
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-link">Eliminar</button>
            </form>
        </span>
    </div>
    <div class="card-body">
        @if ($edit)
            <x-comment-form 
                :action="route('comments.update', $comment)"
                method="PUT"
                :comment="$comment">
            </x-comment-form>
        @else
            <p>{{ $comment->content }}</p>
        @endif
    </div>
    <div class="card-footer clearfix">
        <span class="float-right">
            {{ $comment->created_at->format('d/m/Y H:i:s') }}
        </span>
    </div>
</div>