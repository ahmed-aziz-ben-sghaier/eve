@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tableau de bord</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Ajouter une catégorie</div>
        <div class="card-body">
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de la catégorie</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Créer un événement</div>
        <div class="card-body">
            <form action="{{ route('event.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="category_id" class="form-label">Catégorie</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="datetime-local" name="date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Lieu</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Créer</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Liste des événements</div>
        <div class="card-body">
            @if ($events->isEmpty())
                <p>Aucun événement trouvé.</p>
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
                        @foreach ($events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->description }}</td>
                                <td>{{ $event->date }}</td>
                                <td>{{ $event->location }}</td>
                                <td>{{ $event->category->name }}</td>

                                <td>
                                    <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                                    <form action="{{ route('event.destroy', $event->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="container">

        <h2 class="mb-4">Liste des Réservations</h2>

        <div class="card">
            <div class="card-header">Réservations</div>
            <div class="card-body">
                @if ($reservations->isEmpty())
                    <p>Aucune réservation trouvée.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom de l'utilisateur</th>
                                <th>Email de l'utilisateur</th>
                                <th>Événement</th>
                                <th>Date de réservation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->id }}</td>
                                    <td>{{ $reservation->user->name }}</td>
                                    <td>{{ $reservation->user->email }}</td>
                                    <td>{{ $reservation->event->title }}</td>
                                    <td>{{ $reservation->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="mb-4">Liste d'attente</h2>

        <div class="card">
            <div class="card-header">Liste d'attente</div>
            <div class="card-body">
                @if ($waitingList->isEmpty())
                    <p>Aucune inscription sur la liste d'attente.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom de l'utilisateur</th>
                                <th>Email de l'utilisateur</th>
                                <th>Événement</th>
                                <th>Date d'inscription</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($waitingList as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>{{ $entry->user->name }}</td>
                                    <td>{{ $entry->user->email }}</td>
                                    <td>{{ $entry->event->title }}</td>
                                    <td>{{ $entry->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

<footer class="footer bg-dark text-white mt-5 py-5 text-center">
    <div class="container">
        <p>&copy; {{ date('Y') }} MonApplication. Tous droits réservés.</p>
        <p class="mt-4" style="font-size: 0.9rem;">Contactez-nous à ahmedazizbensghaier@gmail.com
        </p>
    </div>
</footer>
@endsection
