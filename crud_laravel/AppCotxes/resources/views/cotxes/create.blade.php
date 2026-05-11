@extends('layouts.app')

@section('title', 'Nou Cotxe')

@section('content')
    <h1 class="text-display-lg mb-6">Nou Cotxe</h1>

    @if ($errors->any())
        <div class="mb-6 space-y-1">
            @foreach ($errors->all() as $error)
                <p class="text-destructive text-body-sm">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('cotxes.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="marca" class="block text-body-sm-strong text-ink mb-1">Marca</label>
            <input type="text" name="marca" id="marca" value="{{ old('marca') }}"
                   class="input-pill" placeholder="Ex: Toyota">
        </div>

        <div>
            <label for="model" class="block text-body-sm-strong text-ink mb-1">Model</label>
            <input type="text" name="model" id="model" value="{{ old('model') }}"
                   class="input-pill" placeholder="Ex: Corolla">
        </div>

        <div>
            <label for="cilindrada" class="block text-body-sm-strong text-ink mb-1">Cilindrada</label>
            <input type="number" name="cilindrada" id="cilindrada" value="{{ old('cilindrada') }}"
                   class="input-pill" placeholder="Ex: 1600">
        </div>

        <div>
            <label for="potencia" class="block text-body-sm-strong text-ink mb-1">Potència (CV)</label>
            <input type="number" name="potencia" id="potencia" value="{{ old('potencia') }}"
                   class="input-pill" placeholder="Ex: 120">
        </div>

        <div class="flex items-center gap-2 pt-2">
            <button type="submit" class="btn-primary">Guardar</button>
            <a href="{{ route('cotxes.index') }}" class="btn-secondary">Cancel·lar</a>
        </div>
    </form>
@endsection
