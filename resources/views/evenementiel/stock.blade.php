<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Stock - Termitière</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>.bg-bordeaux { background-color: #800020; } .text-bordeaux { color: #800020; }</style>
</head>
<body class="bg-black text-gray-200 p-6 font-sans">
    <div class="max-w-7xl mx-auto">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-zinc-900 p-6 rounded-2xl border border-zinc-800">
                <h4 class="text-bordeaux font-black uppercase text-[10px] mb-4 tracking-widest italic">Ajouter une Catégorie</h4>
                <form action="{{ route('evenementiel.storeCategory') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="ex: Sonorisation" class="flex-1 bg-black border border-zinc-800 p-2 rounded-lg text-sm text-white outline-none focus:border-bordeaux">
                    <button class="bg-bordeaux text-white px-4 py-2 rounded-lg font-bold hover:bg-red-900">+</button>
                </form>
            </div>
            <div class="bg-zinc-900 p-6 rounded-2xl border border-zinc-800">
                <h4 class="text-bordeaux font-black uppercase text-[10px] mb-4 tracking-widest italic">Ajouter une Couleur</h4>
                <form action="{{ route('evenementiel.storeColor') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="ex: Blanc Cassé" class="flex-1 bg-black border border-zinc-800 p-2 rounded-lg text-sm text-white outline-none focus:border-bordeaux">
                    <button class="bg-bordeaux text-white px-4 py-2 rounded-lg font-bold hover:bg-red-900">+</button>
                </form>
            </div>
        </div>

        <div class="bg-zinc-900 p-8 rounded-2xl border border-zinc-800 mb-8 shadow-2xl relative">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-bordeaux"></div>
            <h2 class="text-white font-black uppercase mb-6 tracking-tighter text-xl italic">Enregistrement d'Acquisition</h2>
            
            <form action="{{ route('evenementiel.storeEquipment') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @csrf
                <div class="lg:col-span-2">
                    <label class="text-[10px] uppercase text-gray-500 font-black mb-2 block">Désignation</label>
                    <input type="text" name="name" class="w-full bg-black border border-zinc-800 p-3 rounded-xl outline-none focus:border-bordeaux text-white" required>
                </div>
                <div>
                    <label class="text-[10px] uppercase text-gray-500 font-black mb-2 block">Catégorie</label>
                    <select name="category_id" class="w-full bg-black border border-zinc-800 p-3 rounded-xl text-white focus:border-bordeaux">
                        <option value="">-- Sélection --</option>
                        @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-[10px] uppercase text-gray-500 font-black mb-2 block">Couleur</label>
                    <select name="color_id" class="w-full bg-black border border-zinc-800 p-3 rounded-xl text-white focus:border-bordeaux">
                        <option value="">-- Sélection --</option>
                        @foreach($colors as $col) <option value="{{ $col->id }}">{{ $col->name }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-[10px] uppercase text-gray-500 font-black mb-2 block">Qté Totale</label>
                    <input type="number" name="total_quantity" class="w-full bg-black border border-zinc-800 p-3 rounded-xl text-white" required>
                </div>
                <div>
                    <label class="text-[10px] uppercase text-gray-500 font-black mb-2 block">Tarif Loc. (F)</label>
                    <input type="number" name="rental_price" class="w-full bg-black border border-zinc-800 p-3 rounded-xl text-bordeaux font-black" required>
                </div>
                <div class="lg:col-span-6 flex justify-end">
                    <button type="submit" class="bg-bordeaux text-white px-10 py-3 rounded-full font-black uppercase text-xs tracking-widest shadow-lg hover:scale-105 transition">Valider l'entrée au parc</button>
                </div>
            </form>
        </div>

        <div class="bg-zinc-900 rounded-2xl border border-zinc-800 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-zinc-950 text-[10px] uppercase text-gray-500 tracking-widest border-b border-zinc-800">
                    <tr>
                        <th class="p-6">Désignation</th>
                        <th class="p-6">Catégorie / Couleur</th>
                        <th class="p-6 text-center">Quantité Totale</th>
                        <th class="p-6 text-center">Disponible</th>
                        <th class="p-6 text-right">Tarif</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach($equipments as $item)
                    <tr class="hover:bg-zinc-800/40 transition">
                        <td class="p-6">
                            <span class="text-white font-bold block uppercase tracking-tight">{{ $item->name }}</span>
                            <span class="text-[9px] text-gray-600 font-bold">ID: #00{{ $item->id }}</span>
                        </td>
                        <td class="p-6">
                            <span class="text-gray-400 text-xs uppercase">{{ $item->category->name ?? '---' }}</span>
                            <span class="text-bordeaux font-bold ml-2">| {{ $item->color->name ?? '---' }}</span>
                        </td>
                        <td class="p-6 text-center font-bold">{{ $item->total_quantity }}</td>
                        <td class="p-6 text-center">
                            @php $percent = ($item->available_quantity / $item->total_quantity) * 100; @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $percent < 20 ? 'bg-red-900/30 text-red-500' : 'bg-green-900/30 text-green-500' }}">
                                {{ $item->available_quantity }} EN STOCK
                            </span>
                        </td>
                        <td class="p-6 text-right font-mono text-bordeaux font-black text-lg">{{ number_format($item->rental_price, 0, ',', ' ') }} F</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>