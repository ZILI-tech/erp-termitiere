<?php
namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
class EvenementielController extends Controller {
  public function index() {
    $events = Event::orderBy('event_date', 'asc')->get();
    $types = DB::table('type')->get();
    $today = Carbon::today();

    foreach ($events as $event) {
        $eventDate = Carbon::parse($event->event_date)->startOfDay();
        // Calcul de la différence réelle en jours
        $event->diff = (int)$today->diffInDays($eventDate, false);
    }

    $todayStr = $today->format('Y-m-d');
    return view('events.index', compact('events', 'types', 'todayStr'));
}

/*public function saveProforma(Request $request, $id) {
        $event = Event::findOrFail($id);
        
        // Supprime les anciens pour mise à jour
        $event->items()->delete(); 

        foreach ($request->items as $item) {
            if ($item['quantity'] > 0) {
                $total = ($item['quantity'] * $item['unit_price'] * $item['days']) - $item['discount'];
                
                $event->items()->create([
                    'category' => $item['category'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'days' => $item['days'],
                    'discount' => $item['discount'],
                    'total' => $total
                ]);
            }
        }
        return back()->with('success', 'Proforma enregistrée !');
    }*/


/*public function downloadProforma($id) {
    $event = Event::with('items')->findOrFail($id);
    
    // Si aucune ligne de facture n'existe, on renvoie une erreur
    if($event->items->isEmpty()) {
        return back()->with('error', 'Veuillez d\'abord remplir la proforma.');
    }

    $pdf = Pdf::loadView('events.proforma_pdf', compact('event'));
    return $pdf->download('Proforma_'.$event->title.'.pdf');
}*/

// Ajoutez ceci juste avant la méthode update()
public function store(Request $request) {
        $validated = $request->validate([
            'title'=>'required','client_name'=>'required','type'=>'required',
            'event_date'=>'required|date','duration_days'=>'required','budget'=>'required'
        ]);
        Event::create($validated);
        return redirect()->route('evenementiel.index');
    }
// Méthode pour la modification
public function update(Request $request, $id) {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return redirect()->route('evenementiel.index');
    }

// Méthode pour la suppression
public function destroy($id) {
    Event::findOrFail($id)->delete();
    return redirect()->route('evenementiel.index')->with('success', 'Supprimé');
}
}