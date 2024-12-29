<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EventCategory;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\WaitingList;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $reservations = Reservation::with('user', 'event')->get();
        $categories = EventCategory::all();
         $events = Event::with('category')->get();
         $waitingList = WaitingList::with('user', 'event')->get(); 

            return view('auth.home',compact('categories', 'events','reservations','waitingList'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        EventCategory::create(['name' => $request->name]);

        return redirect()->route('auth.home')->with('status', 'Catégorie ajoutée avec succès.');
    }


   public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:event_categories,id',
        ]);

        Event::create($request->all());

        return redirect()->route('auth.home')->with('status', 'Événement ajouté avec succès.');
    }

    public function editEvent($id)
{
    $event = Event::findOrFail($id);
    $categories = EventCategory::all();
    return view('auth.edit-event', compact('event', 'categories'));
}

public function updateEvent(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'category_id' => 'required|exists:event_categories,id',
    ]);

    $event = Event::findOrFail($id);
    $event->update($request->all());

    return redirect()->route('auth.home')->with('status', 'Événement modifié avec succès.');
}

public function destroyEvent($id)
{
    $event = Event::findOrFail($id);
    $event->delete();

    return redirect()->route('auth.home')->with('status', 'Événement supprimé avec succès.');
}







}
