<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        body { margin: 0; font-family: system-ui, sans-serif; background: #0f172a; color: #e2e8f0; }
        main { max-width: 40rem; margin: 0 auto; padding: 4rem 1rem; }
        a { color: #38bdf8; }
    </style>
</head>
<body>
    <main>
        <h1>EletronTech</h1>
        <p>Electrical calculators and a floor-plan editor for low-voltage residential projects (ABNT NBR 5410).</p>
        <p>Version 2 is being rewritten. The original 2015 project is kept at the
            <a href="https://github.com/NicollasFrazao/eletrontech/tree/v1">v1 tag</a>.</p>
    </main>
</body>
</html>
