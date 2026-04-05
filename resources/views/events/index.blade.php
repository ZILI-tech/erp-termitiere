@extends('layouts.app')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-black text-gray-800 uppercase tracking-widest border-l-8 border-red-700 pl-4">
            Dossiers Événementiels
        </h2>
        <button onclick="toggleModal('modal-add', true)" class="bg-red-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:bg-red-800 transition">
            + NOUVEL ÉVÉNEMENT
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($events as $event)
            @php
                $eventDate = \Carbon\Carbon::parse($event->event_date)->startOfDay();
                $todayDate = \Carbon\Carbon::today();
                $diff = (int)$todayDate->diffInDays($eventDate, false);
            @endphp

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-8 
                {{ $diff === 0 ? 'border-red-600 animate-pulse' : ($diff > 0 && $diff <= 2 ? 'border-orange-500' : 'border-gray-200') }} 
                hover:scale-105 transition transform">
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <span class="bg-gray-100 text-gray-600 text-xs font-black px-3 py-1 rounded-full uppercase">
                            {{ $event->type }}
                        </span>
                        
                        @if($diff === 0)
                            <span class="bg-red-600 text-white text-xs font-black px-3 py-1 rounded-full uppercase shadow-sm">
                                🔔 AUJOURD'HUI
                            </span>
                        @elseif($diff > 0 && $diff <= 2)
                            <span class="bg-orange-500 text-white text-xs font-black px-3 py-1 rounded-full uppercase shadow-sm">
                                ⏳ IMMINENT
                            </span>
                        @endif
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-1 uppercase">{{ $event->title }}</h3>
                    <p class="text-red-700 font-bold mb-4 italic">Client: {{ $event->client_name }}</p>

                    <div class="space-y-3 border-t pt-4">
                        <div class="flex items-center justify-between text-gray-600">
                            <div class="flex items-center">
                                <span class="font-bold w-20">Date :</span>
                                <span>{{ $eventDate->format('d/m/Y') }}</span>
                            </div>
                            
                            @if($diff > 0)
                                <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase {{ $diff <= 2 ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-600' }}">
                                    {{ $diff }} jours restants
                                </span>
                            @elseif($diff < 0)
                                <span class="px-2 py-1 rounded-lg bg-gray-100 text-gray-400 text-[10px] font-black uppercase">Terminé</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center text-gray-600">
                            <span class="font-bold w-20">Durée :</span>
                            <span>{{ $event->duration_days }} jour(s)</span>
                        </div>
                        <div class="flex items-center text-gray-800 font-black">
                            <span class="w-20">Budget :</span>
                            <span class="text-xl">{{ number_format($event->budget, 0, ',', ' ') }} F CFA</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 flex justify-around border-t">
                    <button onclick="openEditModal({{ json_encode($event) }})" class="text-blue-600 font-bold hover:underline text-sm uppercase">Modifier</button>
                    <button onclick="showDetailsModal({{ json_encode($event) }})" class="text-gray-400 font-bold hover:underline text-sm uppercase">Détails</button>
                    <button onclick="openProformaModal({{ json_encode($event) }})" class="text-green-600 font-bold hover:underline text-sm uppercase">Proforma</button>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Supprimer cet événement ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 font-bold hover:underline text-sm uppercase">Supprimer</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- MODALE AJOUT --}}
<div id="modal-add" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-8 max-w-lg w-full shadow-2xl">
        <h3 class="text-2xl font-black mb-6 border-b pb-2">ENREGISTRER UN ÉVÉNEMENT</h3>
        <form action="{{ route('events.store') }}" method="POST">
            @csrf
            <div class="grid gap-4">
                <input type="text" name="title" placeholder="Nom de l'événement" class="border-2 p-3 rounded-xl focus:border-red-700 outline-none" required>
                <input type="text" name="client_name" placeholder="Nom du Client" class="border-2 p-3 rounded-xl focus:border-red-700 outline-none" required>
                <select name="type" class="border-2 p-3 rounded-xl focus:border-red-700 outline-none">
                    @foreach($types as $type)
                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                <div class="grid grid-cols-2 gap-4">
                    <input type="date" name="event_date" class="border-2 p-3 rounded-xl focus:border-red-700 outline-none" required>
                    <input type="number" name="duration_days" placeholder="Jours" class="border-2 p-3 rounded-xl focus:border-red-700 outline-none" required>
                </div>
                <input type="number" name="budget" placeholder="Budget Total" class="border-2 p-3 rounded-xl focus:border-red-700 outline-none" required>
            </div>
            <div class="flex justify-end mt-6 gap-4">
                <button type="button" onclick="toggleModal('modal-add', false)" class="text-gray-500 font-bold">ANNULER</button>
                <button type="submit" class="bg-red-700 text-white px-8 py-3 rounded-xl font-black">VALIDER</button>
            </div>
        </form>
    </div>
</div>

{{-- MODALE MODIFIER --}}
<div id="modal-edit" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-8 max-w-lg w-full shadow-2xl">
        <h3 class="text-2xl font-black mb-6 border-b pb-2 text-blue-600 uppercase">Modifier l'événement</h3>
        <form id="edit-form" method="POST">
            @csrf @method('PUT')
            <div class="grid gap-4">
                <input type="text" name="title" id="edit-title" class="border-2 p-3 rounded-xl focus:border-blue-600 outline-none" required>
                <input type="text" name="client_name" id="edit-client" class="border-2 p-3 rounded-xl focus:border-blue-600 outline-none" required>
                <div class="grid grid-cols-2 gap-4">
                    <input type="date" name="event_date" id="edit-date" class="border-2 p-3 rounded-xl focus:border-blue-600 outline-none" required>
                    <input type="number" name="budget" id="edit-budget" class="border-2 p-3 rounded-xl focus:border-blue-600 outline-none" required>
                </div>
            </div>
            <div class="flex justify-end mt-6 gap-4">
                <button type="button" onclick="toggleModal('modal-edit', false)" class="text-gray-500 font-bold">ANNULER</button>
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-black">SAUVEGARDER</button>
            </div>
        </form>
    </div>
</div>

{{-- MODALE DETAILS --}}
<div id="modal-details" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl text-center">
        <h3 id="det-title" class="text-2xl font-black uppercase text-gray-800 mb-2"></h3>
        <p id="det-type" class="text-blue-600 font-bold text-xs uppercase mb-6"></p>
        <div class="text-left space-y-4 bg-gray-50 p-4 rounded-xl">
            <p><strong>👤 Client :</strong> <span id="det-client"></span></p>
            <p><strong>📅 Date :</strong> <span id="det-date"></span></p>
            <p><strong>💰 Budget :</strong> <span id="det-budget"></span> F CFA</p>
        </div>
        <button onclick="toggleModal('modal-details', false)" class="mt-8 w-full bg-gray-800 text-white py-3 rounded-xl font-bold">FERMER</button>
    </div>
</div>

{{-- MODALE PROFORMA --}}
<!--<div id="modal-proforma" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl p-6 max-w-4xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h3 class="text-2xl font-black uppercase text-gray-800">Facture Proforma - <span id="prof-event-title" class="text-red-700"></span></h3>
            <button onclick="toggleModal('modal-proforma', false)" class="text-gray-400 text-2xl">&times;</button>
        </div>

        <form id="proforma-form" method="POST">
            @csrf
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-[10px] uppercase font-black text-gray-600">
                        <th class="p-2">Catégorie</th>
                        <th class="p-2">Qté</th>
                        <th class="p-2">Prix Unit (F)</th>
                        <th class="p-2">Jours</th>
                        <th class="p-2">Remise (F)</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @php 
                        $categories = ['Chaises', 'Tables', 'Charpente', 'Housses', 'Appatames', 'Petits Chapitaux', 'Grands Chapitaux']; 
                    @endphp
                    @foreach($categories as $index => $cat)
                    <tr class="border-b">
                        <td class="p-2 font-bold">{{ $cat }}</td>
                        <input type="hidden" name="items[{{$index}}][category]" value="{{ $cat }}">
                        <td class="p-2"><input type="number" name="items[{{$index}}][quantity]" class="w-16 border p-1 rounded" value="0"></td>
                        <td class="p-2"><input type="number" name="items[{{$index}}][unit_price]" class="w-24 border p-1 rounded" value="0"></td>
                        <td class="p-2"><input type="number" name="items[{{$index}}][days]" class="w-16 border p-1 rounded" value="1"></td>
                        <td class="p-2"><input type="number" name="items[{{$index}}][discount]" class="w-20 border p-1 rounded" value="0"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
<a href="{{ route('events.proforma.download', $event->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded font-bold text-xs">
    📄 TÉLÉCHARGER PDF
</a>-->
            <div class="flex justify-end mt-8 gap-4">
                <button type="button" onclick="toggleModal('modal-proforma', false)" class="font-bold text-gray-400 uppercase">Annuler</button>
                <button type="submit" class="bg-green-600 text-white px-10 py-3 rounded-xl font-black shadow-lg hover:bg-green-700">GÉNÉRER LA PROFORMA</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id, show) {
        const m = document.getElementById(id);
        show ? m.classList.remove('hidden') : m.classList.add('hidden');
    }

    function showDetailsModal(event) {
        document.getElementById('det-title').innerText = event.title;
        document.getElementById('det-type').innerText = event.type;
        document.getElementById('det-client').innerText = event.client_name;
        document.getElementById('det-date').innerText = event.event_date;
        document.getElementById('det-budget').innerText = new Intl.NumberFormat().format(event.budget);
        toggleModal('modal-details', true);
    }

    function openEditModal(event) {
        document.getElementById('edit-title').value = event.title;
        document.getElementById('edit-client').value = event.client_name;
        document.getElementById('edit-date').value = event.event_date;
        document.getElementById('edit-budget').value = event.budget;
        // Met à jour l'URL d'action pour le PUT
        document.getElementById('edit-form').action = "/evenementiel/update/" + event.id;
        toggleModal('modal-edit', true);
    }

    /*function openProformaModal(event) {
    document.getElementById('prof-event-title').innerText = event.title;
    document.getElementById('proforma-form').action = "/evenementiel/proforma/" + event.id;
    toggleModal('modal-proforma', true);
}*/

</script>
@endsection