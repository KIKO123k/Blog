<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politique des Cookies - EduBlog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="max-w-3xl mx-auto px-6 py-16">
        <header class="mb-8">
            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                &larr; Retour à l'accueil
            </a>
            <h1 class="text-4xl font-bold mt-4">Politique des Cookies</h1>
            <p class="text-gray-600 mt-2">Dernière mise à jour : {{ date('d/m/Y') }}</p>
        </header>

        <main class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm space-y-6">
            <section>
                <h2 class="text-2xl font-semibold mb-3">Utilisation des cookies</h2>
                <p class="leading-relaxed text-gray-700">
                    Nous utilisons des cookies pour améliorer votre expérience sur notre blog, notamment pour maintenir votre session active (si vous êtes connecté) et pour analyser le trafic de manière anonyme.
                </p>
            </section>
            <p class="text-sm text-gray-500 italic">Cette page est requise pour la conformité légale et le bon fonctionnement des liens du pied de page.</p>
        </main>
    </div>
</body>
</html>
