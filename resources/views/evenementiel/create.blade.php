<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Termitière - Gestion Événementiel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 p-4 md:p-8">

    <div class="max-w-6xl mx-auto">
        <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-red-700 mb-8">
            <h1 class="text-2xl font-black text-gray-800 mb-6 uppercase">Nouveau Dossier Événement</h1>
            
            <form action="{{ route('events.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nom de l'événement</label>
                        <input type="text" name="title" required placeholder="ex: Mariage de Baba" 
                               class="w-full border border-gray-300 p-2 rounded focus:border-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nom du Client</label>
                        <input type="text" name="client_name" required placeholder="ex: M. Alifa" 
                               class="w-full border border-gray-300 p-2 rounded focus:border-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Type d'événement</label>
                       <select name="type" required class="w-full border border-gray-300 p-2 rounded focus:border-gray-500 outline-none">
                            <option value="">Sélectionner un type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Date prévue</label>
                        <input type="date" name="event_date" required class="w-full border border-gray-300 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Emplacement / Lieu</label>
                        <input type="text" name="location" required placeholder="ex: Agoè adjougba" 
                               class="w-full border border-gray-300 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Budget prévisionnel (FCFA)</label>
                        <input type="number" name="budget" required placeholder="0" 
                               class="w-full border border-gray-300 p-2 rounded font-bold text-green-700">
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-10 py-3 rounded font-bold uppercase transition shadow-lg">
                        Enregistrer l'événement
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gray-800 p-4">
                <h2 class="text-white font-bold uppercase tracking-tight">Archives et Événements en cours</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="p-4 text-sm font-bold text-gray-600">Événement</th>
                            <th class="p-4 text-sm font-bold text-gray-600">Lieu / Type</th>
                            <th class="p-4 text-sm font-bold text-gray-600">Budget</th>
                            <th class="p-4 text-sm font-bold text-gray-600">Échéance</th> {{-- Nouvelle colonne --}}
                            <th class="p-4 text-center text-sm font-bold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($events as $event)
                        @php
                            $dateEvent = \Carbon\Carbon::parse($event->event_date);
                            $aujourdhui = \Carbon\Carbon::now()->startOfDay();
                            $diff = $aujourdhui->diffInDays($dateEvent, false);
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="font-bold text-gray-900">{{ $event->title }}</div>
                                <div class="text-xs text-gray-400">Client: {{ $event->client_name }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-sm text-gray-600 italic">{{ $event->location }}</div>
                                <span class="inline-block bg-blue-100 text-blue-800 text-[10px] font-black px-2 py-0.5 rounded uppercase">
                                    {{ $event->type ?? 'Non spécifié' }}
                                </span>
                            </td>
                            <td class="p-4 font-bold text-green-700">
                                {{ number_format($event->budget, 0, ',', ' ') }} F
                            </td>
                            <td class="p-4">
                                @if($diff > 0)
                                    <span class="text-sm font-bold text-orange-600">J - {{ $diff }}</span>
                                @elseif($diff == 0)
                                    <span class="text-sm font-black text-red-600 animate-pulse uppercase italic">C'est aujourd'hui !</span>
                                @else
                                    <span class="text-xs text-gray-400 italic">Terminé ({{ abs($diff) }} j)</span>
                                @endif
                                <div class="text-[10px] text-gray-400">{{ $dateEvent->format('d/m/Y') }}</div>
                            </td>
                            <td class="p-4">
                                <div class="flex justify-center items-center gap-3">
                                    <button onclick="openEditModal({{ $event }})" class="text-blue-600 hover:bg-blue-50 p-2 rounded-lg transition">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet événement ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:bg-red-50 p-2 rounded-lg transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="bg-blue-700 p-4">
                <h3 class="text-white font-bold uppercase">Modifier les informations</h3>
            </div>
            <form id="editForm" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Titre</label>
                        <input type="text" name="title" id="edit_title" class="w-full border p-2 rounded">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Client</label>
                            <input type="text" name="client_name" id="edit_client" class="w-full border p-2 rounded">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Budget (FCFA)</label>
                            <input type="number" name="budget" id="edit_budget" class="w-full border p-2 rounded font-bold text-green-700">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Date</label>
                            <input type="date" name="event_date" id="edit_date" class="w-full border p-2 rounded">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Lieu</label>
                            <input type="text" name="location" id="edit_location" class="w-full border p-2 rounded">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Type</label>
                        <select name="type" id="edit_type" class="w-full border p-2 rounded bg-white">
                            @foreach($types as $type)
                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()" class="px-6 py-2 bg-gray-100 text-gray-600 rounded font-bold uppercase text-xs">Annuler</button>
                    <button type="submit" class="px-6 py-2 bg-blue-700 text-white rounded font-bold uppercase text-xs shadow-md">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(event) {
            document.getElementById('edit_title').value = event.title;
            document.getElementById('edit_client').value = event.client_name;
            document.getElementById('edit_date').value = event.event_date;
            document.getElementById('edit_location').value = event.location;
            document.getElementById('edit_budget').value = event.budget;
            document.getElementById('edit_type').value = event.type;
            document.getElementById('editForm').action = "/evenementiel/" + event.id;
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeModal() { document.getElementById('editModal').classList.add('hidden'); }
        window.onclick = function(event) { if (event.target == document.getElementById('editModal')) closeModal(); }
    </script>

</body>
</html>