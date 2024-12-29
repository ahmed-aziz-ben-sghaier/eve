@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mt-4">Liste d'attente</h3>

    @if ($waitingList->isEmpty())
        <p>Aucune inscription sur la liste d'attente.</p>
    @else
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Catégorie</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($waitingList as $entry)
                    <tr>
                        <td>{{ $entry->event->id }}</td>
                        <td>{{ $entry->event->title }}</td>
                        <td>{{ $entry->event->description }}</td>
                        <td>{{ $entry->event->date }}</td>
                        <td>{{ $entry->event->location }}</td>
                        <td>{{ $entry->event->category->name }}</td>
                        <td>
                            <form action="{{ route('user.cancelWaitingList', $entry->event->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Annuler</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div class="mt-4">
        <a href="{{ route('home') }}" class="btn btn-secondary">Retour au tableau de bord</a>
    </div>
</div>
@endsection
