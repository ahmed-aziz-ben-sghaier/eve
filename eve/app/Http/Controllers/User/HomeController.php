<?php

namespace App\Http\Controllers\User;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Models\WaitingList;


class HomeController extends Controller
{
    public function index()
    {
        $events = Event::all();

        $userReservations = Reservation::where('user_id', Auth::id())->pluck('event_id')->toArray();




        return view('user.home',compact('events','userReservations'));
    }


    public function reserve($eventId)
{
    $event = Event::findOrFail($eventId);

    $maxReservations = 1;
    $reservationsCount = Reservation::where('event_id', $eventId)->count();

    if ($reservationsCount >= $maxReservations) {
        WaitingList::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('user.home')->with('status', 'Événement complet. Vous avez été ajouté à la liste d\'attente.');
    }

    if (Reservation::where('user_id', Auth::id())->where('event_id', $eventId)->exists()) {
        return redirect()->route('user.home')->with('status', 'Vous êtes déjà inscrit à cet événement.');
    }

    Reservation::create([
        'event_id' => $event->id,
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('user.home')->with('status', 'Réservation réussie');
}



    public function reservations()
    {
        $reservations = Reservation::where('user_id', Auth::id())->with('event')->get();

        return view('user.reservations', compact('reservations'));
    }

    public function cancelReservation($reservationId)
    {
        $reservation = Reservation::where('user_id', Auth::id())
            ->where('id', $reservationId)
            ->firstOrFail();

        $reservation->delete();

        return redirect()->route('user.reservations')->with('status', 'Réservation annulée avec succès.');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.edit')->with('status', 'Profil mis à jour avec succès.');
    }



    public function waitingList()
{
    $waitingList = WaitingList::where('user_id', Auth::id())->with('event')->get();

    return view('user.waiting_list', compact('waitingList'));
}

public function cancelWaitingList($eventId)
{
    $waitingListEntry = WaitingList::where('user_id', Auth::id())
                                    ->where('event_id', $eventId)
                                    ->first();

    if (!$waitingListEntry) {
        return redirect()->route('user.waiting_list')->with('status', 'Vous n\'êtes pas inscrit à cet événement dans la liste d\'attente.');
    }

    $waitingListEntry->delete();

    return redirect()->route('user.waiting_list')->with('status', 'Inscription annulée avec succès.');
}





}
