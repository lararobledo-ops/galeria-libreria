@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Editar Foto</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-4">
        <form action="{{ route('photos.update', $photo) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('photos._form', compact('photo'))
            <div class="mt-3">
                <button class="btn btn-primary">Actualizar</button>
                <a href="{{ route('photos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
