@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Événements réservés</h3>

    @if ($reservations->isEmpty())
        <p>Aucun événement réservé.</p>
    @else
        <table class="table">
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
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->event->id }}</td>
                        <td>{{ $reservation->event->title }}</td>
                        <td>{{ $reservation->event->description }}</td>
                        <td>{{ $reservation->event->date }}</td>
                        <td>{{ $reservation->event->location }}</td>
                        <td>{{ $reservation->event->category->name }}</td>
                        <td>
                            <!-- Formulaire pour annuler la réservation -->
                            <form action="{{ route('user.cancelReservation', $reservation->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger">Annuler la réservation</button>
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
