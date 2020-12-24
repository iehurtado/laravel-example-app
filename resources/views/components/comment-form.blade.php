<form action="{{ $action }}" method="POST">
    @method($method)
    @csrf
    <div class="form-row">
        <textarea id="content" name="content" 
            class="form-control @error('content') is-invalid @enderror" 
            placeholder="Escribe un comentario...">{{ old('content', optional($comment)->content ?? NULL) }}</textarea>
        @error('content')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-row">
        <button type="submit" class="btn btn-success">Enviar</button>
    </div>
</form>