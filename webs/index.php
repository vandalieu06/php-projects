<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorio de Proyectos | Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@400;500;700&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @theme {
            --font-display: 'Orbitron', sans-serif;
            --font-body: 'Zen Kaku Gothic New', sans-serif;
        }
    </style>
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        :root {
            --bg-main: #fefefe;
            --bg-card: #ffffff;
            --text-primary: #18181b;
            --text-secondary: #52525b;
            --accent: #7c3aed;
            --accent-light: #a78bfa;
        }

        body {
            font-family: 'Zen Kaku Gothic New', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
        }

        .accent-gradient {
            background: linear-gradient(135deg, #7c3aed 0%, #06b6d4 100%);
        }

        .text-gradient {
            background: linear-gradient(135deg, #7c3aed 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .border-accent {
            border-color: rgba(124, 58, 237, 0.3);
        }

        .shadow-accent {
            box-shadow: 0 4px 20px rgba(124, 58, 237, 0.15);
        }

        .shadow-accent-hover {
            box-shadow: 0 8px 30px rgba(124, 58, 237, 0.25);
        }
    </style>
</head>
<body class="text-zinc-900 min-h-screen">
    <header class="py-16 px-6 text-center border-b border-zinc-200 bg-white/80 backdrop-blur-sm">
        <div class="flex items-center justify-center gap-2 mb-4">
            <span class="w-2 h-2 rounded-full bg-violet-600 animate-pulse"></span>
            <span class="text-xs tracking-widest uppercase text-zinc-500 font-medium">Sistema Activo</span>
        </div>
        
        <h1 class="font-['Orbitron'] font-bold text-4xl md:text-5xl text-zinc-900 mb-4">
            LAB<span class="text-gradient">PROJECTS</span>
        </h1>
        
        <p class="text-zinc-600 max-w-lg mx-auto text-base">
            Portafolio de experimentos y proyectos web desarrollados con pasión por la innovación
        </p>

        <div class="flex items-center justify-center mt-6">
            <div class="h-px w-20 bg-gradient-to-r from-transparent to-violet-500"></div>
            <div class="w-3 h-3 mx-3 rotate-45 bg-violet-500"></div>
            <div class="h-px w-20 bg-gradient-to-l from-transparent to-violet-500"></div>
        </div>
    </header>
    
    <main class="py-12 px-6 max-w-7xl mx-auto">
        <?php
        $activities = [];
        $currentDir = __DIR__;
        
        if ($handle = opendir($currentDir)) {
            while (false !== ($entry = readdir($handle))) {
                if (is_dir($entry) && preg_match('/^act(\d{2})$/', $entry, $matches)) {
                    $num = intval($matches[1]);
                    $activities[$num] = $entry;
                }
            }
            closedir($handle);
        }
        
        ksort($activities);
        $totalActivities = count($activities);
        ?>
        
        <?php if ($totalActivities > 0): ?>
        <div class="flex flex-wrap justify-center items-center gap-8 mb-12 p-6 bg-white rounded-2xl border border-zinc-200 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-violet-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-violet-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-['Orbitron'] font-bold text-2xl text-zinc-900"><?php echo $totalActivities; ?></div>
                    <div class="text-xs tracking-widest uppercase text-zinc-500">Proyectos</div>
                </div>
            </div>

            <div class="w-px h-12 bg-zinc-200"></div>

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-['Orbitron'] font-bold text-2xl text-zinc-900"><?php echo date('Y'); ?></div>
                    <div class="text-xs tracking-widest uppercase text-zinc-500">Año</div>
                </div>
            </div>

            <div class="w-px h-12 bg-zinc-200"></div>

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-pink-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-['Orbitron'] font-bold text-2xl text-zinc-900">100%</div>
                    <div class="text-xs tracking-widest uppercase text-zinc-500">Dedicación</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php
            $delay = 0;
            $colors = [
                ['bg' => 'bg-violet-50', 'border' => 'border-violet-200', 'text' => 'text-violet-700', 'icon' => 'text-violet-600', 'hover' => 'hover:border-violet-300', 'shadow' => 'shadow-violet-100'],
                ['bg' => 'bg-cyan-50', 'border' => 'border-cyan-200', 'text' => 'text-cyan-700', 'icon' => 'text-cyan-600', 'hover' => 'hover:border-cyan-300', 'shadow' => 'shadow-cyan-100'],
                ['bg' => 'bg-pink-50', 'border' => 'border-pink-200', 'text' => 'text-pink-700', 'icon' => 'text-pink-600', 'hover' => 'hover:border-pink-300', 'shadow' => 'shadow-pink-100'],
                ['bg' => 'bg-amber-50', 'border' => 'border-amber-200', 'text' => 'text-amber-700', 'icon' => 'text-amber-600', 'hover' => 'hover:border-amber-300', 'shadow' => 'shadow-amber-100'],
                ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-700', 'icon' => 'text-emerald-600', 'hover' => 'hover:border-emerald-300', 'shadow' => 'shadow-emerald-100'],
                ['bg' => 'bg-indigo-50', 'border' => 'border-indigo-200', 'text' => 'text-indigo-700', 'icon' => 'text-indigo-600', 'hover' => 'hover:border-indigo-300', 'shadow' => 'shadow-indigo-100'],
            ];
            
            foreach ($activities as $num => $folder):
                $colorIndex = ($num - 1) % count($colors);
                $color = $colors[$colorIndex];
                $activityName = "Actividad " . sprintf("%02d", $num);
                
                $descriptions = [
                    1 => "Introducción a PHP y estructuras básicas del lenguaje.",
                    2 => "Variables, tipos de datos y operadores fundamentales.",
                    3 => "Estructuras de control: condicionales y bucles.",
                    4 => "Funciones y manejo de formularios web.",
                    5 => "Arrays y estructuras de datos complejas.",
                    6 => "Programación orientada a objetos en PHP.",
                    7 => "Manejo de archivos y sesiones.",
                    8 => "Conexión a bases de datos MySQL.",
                    9 => "CRUD completo con PHP y MySQL.",
                    10 => "Autenticación y gestión de usuarios.",
                    11 => "Proyecto integrador: Aplicación web completa."
                ];
                $description = isset($descriptions[$num]) ? $descriptions[$num] : "Proyecto de desarrollo web con PHP.";
            ?>
            <article class="card-hover group bg-white rounded-2xl p-6 border-2 border-zinc-200 hover:border-violet-300 shadow-md hover:shadow-xl transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl <?php echo $color['bg']; ?> flex items-center justify-center border border-zinc-200">
                        <span class="font-['Orbitron'] font-bold text-lg <?php echo $color['text']; ?>"><?php echo sprintf("%02d", $num); ?></span>
                    </div>
                    <div class="w-3 h-3 rounded-full <?php echo $color['icon']; ?> bg-opacity-20"></div>
                </div>
                
                <h2 class="font-['Orbitron'] text-lg font-bold text-zinc-900 mb-2">
                    <?php echo $activityName; ?>
                </h2>
                
                <p class="text-zinc-600 text-sm leading-relaxed mb-5">
                    <?php echo $description; ?>
                </p>
                
                <a href="<?php echo $folder; ?>/" class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-lg border-2 border-zinc-300 hover:border-violet-400 hover:bg-violet-50 text-zinc-700 hover:text-violet-700 font-semibold text-sm transition-all duration-300">
                    <span>Acceder</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </article>
            <?php 
                $delay += 0.05;
            endforeach; 
            ?>
        </div>
        <?php else: ?>
        <div class="text-center py-20 px-8 bg-white rounded-2xl border border-zinc-200">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-zinc-100 flex items-center justify-center">
                <svg class="w-10 h-10 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
            </div>
            <p class="text-zinc-700 text-lg font-medium">No se encontraron proyectos</p>
            <p class="text-zinc-500 text-sm mt-2">Crea carpetas con el formato "act##" para comenzar</p>
        </div>
        <?php endif; ?>
    </main>
    
    <footer class="py-8 px-6 text-center border-t border-zinc-200 bg-white/60">
        <p class="text-zinc-600 text-sm">
            <span class="font-['Orbitron']">© <?php echo date('Y'); ?></span> 
            <span class="mx-2">·</span> 
            Laboratorio de Proyectos Web
            <span class="mx-2">·</span> 
            <span class="text-violet-600 font-medium">Hecho con pasión</span>
        </p>
    </footer>
</body>
</html>
