<?php
/**
 * -----------------------------------------------------------------------------
 * Shared layout — the one HTML shell every page is wrapped in.
 * -----------------------------------------------------------------------------
 * The view() helper renders a page into $content, then loads this file to place
 * that content between the shared <head>, navigation and footer. Because it
 * lives in one file, no page ever duplicates the <head> or the styling setup.
 *
 * STYLING: 100% Tailwind CSS utility classes via the Play CDN — zero build step,
 * nothing to install, works the same on macOS/Windows/Ubuntu. The framework is
 * dark-mode only, so the dark palette is applied directly (no theme toggling).
 */
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSTANT Framework</title>

    <!-- Make every relative link/asset resolve no matter where the app is installed. -->
    <base href="<?= base_url() ?>">
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">

    <!-- Tailwind CSS (Play CDN): the zero-build styling engine. -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Typography: Space Grotesk (display), Inter (body), JetBrains Mono (data/labels). -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <script>
        // A tiny Tailwind theme so the design tokens read like the brief, not defaults.
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Space Grotesk"', 'ui-sans-serif', 'sans-serif'],
                        sans:    ['Inter', 'ui-sans-serif', 'sans-serif'],
                        mono:    ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    },
                    colors: {
                        ink:   '#0B0F17', // page background
                        panel: '#111827', // cards / surfaces
                        edge:  '#1F2937', // hairlines / borders
                    },
                },
            },
        };
    </script>
</head>
<body class="min-h-screen bg-ink font-sans text-slate-200 antialiased flex flex-col">

    <?php require __DIR__ . '/partials/nav.php'; ?>

    <main class="mx-auto w-full max-w-5xl flex-1 px-6 py-10">
        <?php
        // --- Flash messages: one-time success / error banners after a redirect ---
        if ($msg = flash('success')): ?>
            <div class="mb-6 flex items-center gap-3 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
                <span class="font-mono text-xs uppercase tracking-widest text-emerald-400">OK</span>
                <?= e($msg) ?>
            </div>
        <?php endif; ?>
        <?php if ($msg = flash('error')): ?>
            <div class="mb-6 flex items-center gap-3 rounded-lg border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-300">
                <span class="font-mono text-xs uppercase tracking-widest text-rose-400">FIX</span>
                <?= e($msg) ?>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <?php require __DIR__ . '/partials/footer.php'; ?>

    <script src="public/js/app.js"></script>
</body>
</html>
