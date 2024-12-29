@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('vous êtes connecté en tant que user') }}

                    <h3 class="mt-4">Liste des événements</h3>

                    @if ($events->isEmpty())
                        <p>Aucun événement trouvé.</p>
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
                                    <th>Actions</th>
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
                                            @if (in_array($event->id, $userReservations))

                                                <button class="btn btn-secondary" disabled>Déjà inscrit</button>
                                            @else
                                                <form action="{{ route('user.reserve', $event->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Réserver</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <h3 class="mt-4">Mes réservations</h3>
                    <a href="{{ route('user.reservations') }}" class="btn btn-info">Voir mes réservations </a>

                    <h3 class="mt-4">liste d'attente </h3>
                    <a href="{{ route('user.waiting_list') }}" class="btn btn-info mt-4">Voir ma liste d'attente </a>

                </div>
            </div>
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
