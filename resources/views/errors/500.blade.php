<!DOCTYPE html>
{{-- Standalone page on purpose: a 500 can mean the DB or layout is down,
     so this view must not depend on layouts/app or any query. --}}
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur serveur — 500</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #f0fdf9 0%, #eef2ff 100%);
            color: #0f172a; padding: 1.5rem;
        }
        .box { max-width: 480px; text-align: center; }
        .code { font-size: 7rem; font-weight: 900; letter-spacing: -.05em; line-height: 1; }
        .code span { background: linear-gradient(135deg, #6EE7B7, #34d399); -webkit-background-clip: text; background-clip: text; color: transparent; }
        h1 { font-size: 1.35rem; font-weight: 800; margin: 1rem 0 .5rem; }
        p { font-size: .92rem; color: #64748b; line-height: 1.65; margin-bottom: 1.75rem; }
        a {
            display: inline-block; padding: 12px 26px; border-radius: 12px;
            background: linear-gradient(135deg, #6EE7B7, #34d399); color: #0f172a;
            font-weight: 800; font-size: .9rem; text-decoration: none;
        }
        a:hover { opacity: .88; }
    </style>
</head>
<body>
    <div class="box">
        <div class="code">5<span>0</span>0</div>
        <h1>Une erreur est survenue</h1>
        <p>Quelque chose s'est mal passé de notre côté. Nos équipes sont prévenues — réessayez dans quelques instants.</p>
        <a href="/">Retour à l'accueil</a>
    </div>
</body>
</html>
