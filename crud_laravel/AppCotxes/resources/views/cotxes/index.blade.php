@extends('layouts.app')

@section('title', 'Cotxes')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-display-lg">Cotxes</h1>
        <a href="{{ route('cotxes.create') }}" class="btn-primary">
            Nou cotxe
        </a>
    </div>

    @if ($cotxes->isEmpty())
        <p class="text-body text-center italic">No hi ha cotxes registrats.</p>
    @else
        <div class="card overflow-hidden">
            <table class="w-full text-body-sm">
                <thead>
                    <tr class="border-b border-hairline text-body-sm-strong text-ink">
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Marca</th>
                        <th class="px-4 py-2 text-left">Model</th>
                        <th class="px-4 py-2 text-left">Cilindrada</th>
                        <th class="px-4 py-2 text-left">Potència</th>
                        <th class="px-4 py-2 text-right">Accions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cotxes as $cotxe)
                        <tr class="border-b border-hairline last:border-b-0">
                            <td class="px-4 py-2 text-charcoal">{{ $cotxe->id }}</td>
                            <td class="px-4 py-2 text-ink">{{ $cotxe->marca }}</td>
                            <td class="px-4 py-2 text-ink">{{ $cotxe->model }}</td>
                            <td class="px-4 py-2 text-ink">{{ $cotxe->cilindrada }}</td>
                            <td class="px-4 py-2 text-ink">{{ $cotxe->potencia }}</td>
                            <td class="px-4 py-2 text-right">
                                <form action="{{ route('cotxes.destroy', $cotxe) }}" method="POST"
                                      onsubmit="return confirm('Eliminar {{ $cotxe->marca }} {{ $cotxe->model }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger text-sm px-4 py-1.5 h-8">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
