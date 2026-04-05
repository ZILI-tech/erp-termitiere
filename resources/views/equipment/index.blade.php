<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Termitière</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-red-800 mb-8 border-b pb-2">Événementiel</h1>

            <div class="grid grid-cols-2 gap-8 mb-10">
                <form action="{{ route('category.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Nouvelle Catégorie" class="flex-1 border-gray-300 border p-2 rounded">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</button>
                </form>
                <form action="{{ route('color.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Nouvelle Couleur" class="flex-1 border-gray-300 border p-2 rounded">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</button>
                </form>
            </div>
        <div class="bg-white p-8 shadow-lg rounded-lg mb-8">
            <!--<h1 class="text-3xl font-bold text-red-800 mb-6 border-b">Événementiel</h1>-->
            <form action="{{ route('equipment.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-4 gap-4 mb-4">
                    <input type="text" name="name" placeholder="Nom" required class="border p-2 rounded">
                    <select name="category_id" class="border p-2 rounded">
                        @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                    </select>
                    <select name="color_id" class="border p-2 rounded">
                        @foreach($colors as $col) <option value="{{ $col->id }}">{{ $col->name }}</option> @endforeach
                    </select>
                    <input type="number" name="quantity" placeholder="Quantité" required class="border p-2 rounded">
                </div>
                <button type="submit" class="bg-black text-white px-10 py-2 rounded uppercase font-bold w-full">Enregistrer</button>
            </form>
        </div>

        <div class="bg-white p-6 shadow-lg rounded-lg">
            <table class="w-full text-left">
                <h3 class="text-3xl font-bold text-red-800 mb-8 border-b pb-2">Liste des Matériels</h3>
                <thead>
                    
                    <tr class="bg-gray-100">
                        
                        <th class="p-3">Nom</th><th class="p-3">Catégorie</th><th class="p-3">Couleur</th><th class="p-3">Qté</th><th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipments as $item)
                    <tr class="border-b">
                        <td class="p-3">{{ $item->name }}</td>
                        <td class="p-3">{{ $item->category->name }}</td>
                        <td class="p-3">{{ $item->color->name }}</td>
                        <td class="p-3 font-bold text-blue-600">{{ $item->available_quantity }}</td>
                        <td class="p-3 flex gap-4">
                            <button onclick="openEditModal({{ $item }})" class="text-blue-600"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('equipment.destroy', $item->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg w-1/2">
            <h2 class="text-xl font-bold mb-4">Modifier le matériel</h2>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <input placeholder="Nom" type="text" name="name" id="edit_name" class="border p-2 rounded">
                    <input placeholder="quantité" type="number" name="quantity" id="edit_quantity" class="border p-2 rounded">
                    <select name="category_id" id="edit_category" class="border p-2 rounded">
                        @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                    </select>
                    <select name="color_id" id="edit_color" class="border p-2 rounded">
                        @foreach($colors as $col) <option value="{{ $col->id }}">{{ $col->name }}</option> @endforeach
                    </select>
                </div>
                <div class="mt-6 flex justify-end gap-4">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Annuler</button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(item) {
            document.getElementById('edit_name').value = item.name;
            document.getElementById('edit_quantity').value = item.quantity;
            document.getElementById('edit_category').value = item.category_id;
            document.getElementById('edit_color').value = item.color_id;
            document.getElementById('editForm').action = "/equipments/" + item.id;
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeModal() { document.getElementById('editModal').classList.add('hidden'); }
    </script>
</body>
</html>