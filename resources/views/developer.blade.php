<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Developer - SIKAS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-white min-h-screen overflow-x-hidden">

    <!-- Background -->
    <div class="fixed inset-0 -z-10 overflow-hidden">

        <!-- Glow kiri -->
        <div class="absolute top-0 left-0
                    w-[300px] h-[300px]
                    bg-blue-500/20
                    rounded-full
                    blur-3xl">
        </div>

        <!-- Glow kanan -->
        <div class="absolute bottom-0 right-0
                    w-[300px] h-[300px]
                    bg-purple-500/20
                    rounded-full
                    blur-3xl">
        </div>

        <!-- Gradient -->
        <div class="absolute inset-0
                    bg-gradient-to-br
                    from-[#1e1b4b]
                    via-[#111827]
                    to-[#020617]">
        </div>

    </div>

    <!-- Container -->
    <div class="relative max-w-6xl mx-auto px-6 py-10">

        <!-- Header -->
        <div class="text-center mb-12">

            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight">

                <span class="text-white">
                    Profile
                </span>

                <span class="bg-gradient-to-r
                             from-blue-400
                             via-cyan-400
                             to-purple-500
                             bg-clip-text
                             text-transparent">

                    Developer

                </span>

            </h1>

            <p class="text-gray-400 text-lg md:text-xl mt-4">
                Mahasiswa Politeknik Negeri Jakarta
            </p>

            <div class="w-24 h-1
                        bg-gradient-to-r
                        from-blue-400
                        to-purple-500
                        rounded-full
                        mx-auto
                        mt-5">
            </div>

        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Card Rafly -->
            <div class="relative
                        bg-slate-900/40
                        border border-white/10
                        backdrop-blur-xl
                        rounded-[30px]
                        overflow-hidden
                        shadow-xl
                        hover:border-blue-400/30
                        hover:scale-[1.02]
                        transition-all duration-300">

                <!-- Glow -->
                <div class="absolute inset-0
                            bg-gradient-to-br
                            from-blue-500/10
                            to-purple-500/5">
                </div>

                <!-- Content -->
                <div class="relative z-10 p-6 text-center">

                    <!-- Foto -->
                    <div class="flex justify-center mb-5">

                        <img
                            src="{{ asset('public/foto-rafly.jpeg') }}"
                            alt="Muhammad Rafly Fadilla"

                            class="w-40 h-40
                                   rounded-full
                                   object-cover
                                   object-top
                                   border-4 border-blue-400
                                   shadow-[0_0_20px_rgba(59,130,246,0.5)]">

                    </div>

                    <!-- Nama -->
                    <h2 class="text-2xl md:text-3xl font-bold leading-tight">
                        Muhammad Rafly Fadilla
                    </h2>

                    <!-- Role -->
                    <p class="mt-2 text-blue-400 font-medium">
                        Front-End Developer
                    </p>

                    <!-- NIM -->
                    <p class="text-blue-400
                              text-xl md:text-2xl
                              font-bold
                              mt-4">
                        2403421003
                    </p>

                    <!-- Kelas -->
                    <p class="text-gray-300 text-base md:text-lg mt-3">
                        Kelas 4B - Broadband Multimedia
                    </p>

                    <!-- Divider -->
                    <div class="w-20 h-1
                                bg-gradient-to-r
                                from-blue-400
                                to-purple-500
                                rounded-full
                                mx-auto
                                my-4">
                    </div>

                    <!-- Kampus -->
                    <p class="text-lg md:text-xl font-semibold">
                        Politeknik Negeri Jakarta
                    </p>

                    <!-- Email -->
                    <p class="mt-4 text-gray-400 text-sm break-all">
                        muhammad.rafly.fadilla.te24@stu.pnj.ac.id
                    </p>

                </div>

            </div>

            <!-- Card Flemon -->
            <div class="relative
                        bg-slate-900/40
                        border border-white/10
                        backdrop-blur-xl
                        rounded-[30px]
                        overflow-hidden
                        shadow-xl
                        hover:border-purple-400/30
                        hover:scale-[1.02]
                        transition-all duration-300">

                <!-- Glow -->
                <div class="absolute inset-0
                            bg-gradient-to-br
                            from-purple-500/10
                            to-blue-500/5">
                </div>

                <!-- Content -->
                <div class="relative z-10 p-6 text-center">

                    <!-- Foto -->
                    <div class="flex justify-center mb-5">

                        <img
                            src="{{ asset('public/foto-flemon.jpeg') }}"
                            alt="Flemon Tigor Tri Sinaga"

                            class="w-40 h-40
                                   rounded-full
                                   object-cover
                                   border-4 border-purple-400
                                   shadow-[0_0_20px_rgba(168,85,247,0.5)]">

                    </div>

                    <!-- Nama -->
                    <h2 class="text-2xl md:text-3xl font-bold leading-tight">
                        Flemon Tigor Tri Sinaga
                    </h2>

                    <!-- Role -->
                    <p class="mt-2 text-purple-400 font-medium">
                        Back-End Developer
                    </p>

                    <!-- NIM -->
                    <p class="text-blue-400
                              text-xl md:text-2xl
                              font-bold
                              mt-4">
                        2403421009
                    </p>

                    <!-- Kelas -->
                    <p class="text-gray-300 text-base md:text-lg mt-3">
                        Kelas 4B - Broadband Multimedia
                    </p>

                    <!-- Divider -->
                    <div class="w-20 h-1
                                bg-gradient-to-r
                                from-blue-400
                                to-purple-500
                                rounded-full
                                mx-auto
                                my-4">
                    </div>

                    <!-- Kampus -->
                    <p class="text-lg md:text-xl font-semibold">
                        Politeknik Negeri Jakarta
                    </p>

                    <!-- Email -->
                    <p class="mt-4 text-gray-400 text-sm break-all">
                        flemon.tigor.tri.sinaga.te24@stu.pnj.ac.id
                    </p>

                </div>

            </div>

        </div>

    </div>

</body>
</html>