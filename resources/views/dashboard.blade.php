<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>  Dashboard - ERP Termitière</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .card-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="min-h-screen">
        <nav class="bg-slate-800 p-4 shadow-lg text-white">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-xl font-bold tracking-wider uppercase">ERP TERMITIÈRE</h1>
                <span class="text-sm bg-slate-700 px-3 py-1 rounded"><img src="{{ asset('images/logo_termitiere_0.jpeg') }}" alt="TERMITIERE-GESTION ERP" class="h-10 w-10"></span>
                <div class="flex items-center gap-4">
    <span class="text-sm bg-slate-700 px-3 py-1 rounded">{{ Auth::user()->name }}</span>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm hover:text-red-400 transition">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </button>
    </form>
</div>
            </div>
        </nav>

        <div class="container mx-auto p-8">
            <header class="mb-10">
                <!--<img src="{{ asset('images/logo_termitiere_0.jpeg') }}" alt="TERMITIERE-GESTION ERP" class="h-10 w-10">-->
                <h2 class="text-3xl font-extrabold text-gray-800">Tableau de bord</h2>
                <p class="text-gray-500">Sélectionnez un module pour commencer.</p>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <a href="{{ route('btp.index') }}" class="group relative bg-white p-8 rounded-2xl shadow-xl border-b-8 border-orange-500 hover:scale-105 transition transform">
            <div class="flex flex-col items-center">
                <i class="fas fa-building fa-3x text-orange-500 mb-4"></i>
                <span class="text-2xl font-black text-center text-gray-800 uppercase tracking-tight">BTP</span>
                <p class="text-gray-500 text-sm font-bold mt-1">Gestion Chantiers</p>
            </div>
        </a>

                <a href="{{ route('briqueterie.index') }}" class="group relative bg-white p-8 rounded-2xl shadow-xl border-b-8 border-orange-500 hover:scale-105 transition transform">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-cubes fa-3x text-orange-500 mb-4"></i>
                        <span class="text-2xl font-black text-center text-gray-800 uppercase tracking-tight">BTP</span>
                        <p class="text-gray-500 text-sm font-bold mt-1">Fabrication et vente de briques</p>
                    </div>
                </a>

               
    <a href="{{ route('evenementiel.index') }}" class="group relative bg-white p-8 rounded-2xl shadow-xl border-b-8 border-red-700 hover:scale-105 transition transform z-10">
            <div class="flex flex-col items-center">
                <i class="fas fa-calendar-alt fa-3x text-red-700 mb-4"></i>
                <span class="text-2xl font-black text-center text-gray-800 uppercase tracking-tight">Événementiel</span>
                <p class="text-gray-500 text-sm font-bold mt-1">Organisation & Archives</p>
            </div>
        </a>


                <a href="{{ route('garderie.index') }}" class="group relative bg-white p-8 rounded-2xl shadow-xl border-b-8 border-orange-500 hover:scale-105 transition transform">
            <div class="flex flex-col items-center">
                <i class="fas fa-child fa-3x text-orange-500 mb-4"></i>
                <span class="text-2xl font-black text-center text-gray-800 uppercase tracking-tight">BTP</span>
                <p class="text-gray-500 text-sm font-bold mt-1">Gestion Chantiers</p>
            </div>
        </a>

                <a href="{{ route('agro.index') }}" class="group relative bg-white p-8 rounded-2xl shadow-xl border-b-8 border-orange-500 hover:scale-105 transition transform">
            <div class="flex flex-col items-center">
                <i class="fas fa-seedling fa-3x text-orange-500 mb-4"></i>
                <span class="text-2xl font-black text-center text-gray-800 uppercase tracking-tight">BTP</span>
                <p class="text-gray-500 text-sm font-bold mt-1">Gestion Chantiers</p>
            </div>
        </a>

                <a href="{{ route('gym.index') }}" class="group relative bg-white p-8 rounded-2xl shadow-xl border-b-8 border-orange-500 hover:scale-105 transition transform">
            <div class="flex flex-col items-center">
                <i class="fas fa-dumbbell fa-3x text-orange-500 mb-4"></i>
                <span class="text-2xl font-black text-center text-gray-800 uppercase tracking-tight">BTP</span>
                <p class="text-gray-500 text-sm font-bold mt-1">Gestion Chantiers</p>
            </div>
        </a>

            </div>
        </div>
    </div>

</body>
</html>