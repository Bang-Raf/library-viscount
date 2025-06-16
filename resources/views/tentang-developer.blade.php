@extends('layouts.app')

@section('title', 'Tentang Developer - Alfalimbany Tech')

@section('content')
    <div class="relative overflow-hidden">
        <!-- Hero Section -->
        <div
            class="w-full bg-gradient-to-tr from-blue-400 via-green-200 to-blue-300 py-16 px-4 flex flex-col items-center justify-center shadow-lg relative">
            <div class="absolute top-0 left-0 w-40 h-40 bg-blue-200 opacity-30 rounded-full blur-2xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-green-200 opacity-30 rounded-full blur-2xl animate-pulse">
            </div>
            <div class="z-10 flex flex-col items-center">
                <div class="bg-white shadow-xl rounded-full p-2 mb-4 animate-fade-in">
                    <img src="https://ui-avatars.com/api/?name=Alfalimbany+Tech&background=2563eb&color=fff&size=96"
                        alt="Alfalimbany Tech" class="w-24 h-24 rounded-full border-4 border-blue-400 shadow-lg">
                </div>
                <h1 class="text-4xl font-extrabold text-blue-700 drop-shadow mb-2 animate-fade-in">Alfalimbany Tech</h1>
                <p class="text-lg text-blue-900 max-w-3xl animate-fade-in-slow leading-relaxed text-justify mx-auto">
                    Kami berpengalaman sebagai ICT Educator, Associate Data Scientist, serta Freelance Software Engineer
                    sejak 2020. Keahlian kami didukung oleh sertifikasi Associate Data Scientist dan Mobile App Development
                    (React Native), serta latar belakang pendidikan Magister dan Sarjana Informatika.
                    <br>
                    Kami menyediakan layanan pengembangan aplikasi web, mobile, dan solusi data untuk berbagai kebutuhan
                    bisnis, edukasi, organisasi, dan startup. Mulai dari pembuatan sistem informasi, aplikasi mobile modern,
                    integrasi data, hingga konsultasi dan pelatihan IT. Setiap solusi dirancang agar mudah digunakan,
                    scalable, dan siap mendukung transformasi digital Anda.
                </p>
            </div>
        </div>
        <!-- Layanan Section -->
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 mt-[-3rem] z-20 relative px-4">
            <div
                class="bg-white rounded-2xl shadow-xl p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300 group border border-blue-100">
                <div
                    class="bg-gradient-to-tr from-blue-400 to-green-300 p-3 rounded-full mb-3 shadow-lg group-hover:rotate-6 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h2 class="font-bold text-xl mb-2 text-blue-700">Layanan Utama</h2>
                <ul class="list-none text-blue-900 space-y-2 text-base">
                    <li class="flex items-center gap-2"><span class="inline-block w-2 h-2 bg-blue-400 rounded-full"></span>
                        Pengembangan aplikasi web (Laravel, Livewire, Tailwind, dsb)</li>
                    <li class="flex items-center gap-2"><span class="inline-block w-2 h-2 bg-green-400 rounded-full"></span>
                        Pengembangan aplikasi mobile (React Native, Flutter)</li>
                    <li class="flex items-center gap-2"><span
                            class="inline-block w-2 h-2 bg-yellow-400 rounded-full"></span> Integrasi & analisis data (Data
                        Science, API, Dashboard)</li>
                    <li class="flex items-center gap-2"><span class="inline-block w-2 h-2 bg-pink-400 rounded-full"></span>
                        Konsultasi, pelatihan IT, dan maintenance/support aplikasi</li>
                </ul>
            </div>
            <div
                class="bg-white rounded-2xl shadow-xl p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300 group border border-green-100">
                <div
                    class="bg-gradient-to-tr from-green-300 to-blue-300 p-3 rounded-full mb-3 shadow-lg group-hover:-rotate-6 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 01.88 7.903A5.5 5.5 0 1112 6.5" />
                    </svg>
                </div>
                <h2 class="font-bold text-xl mb-2 text-green-700">Kontak & Sosial</h2>
                <div class="flex flex-col gap-2 text-base">
                    <a href="mailto:alfalimbany@gmail.com"
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 transition transform hover:scale-105 hover:shadow-lg duration-200"><svg
                            class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2.94 6.94A8 8 0 1116.5 3.5l-1.42 1.42A6 6 0 104.5 15.5l1.42-1.42A8 8 0 012.94 6.94z" />
                        </svg>Email: alfalimbany@gmail.com</a>
                    <a href="https://wa.me/6289614514647" target="_blank"
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-700 hover:bg-green-200 transition transform hover:scale-105 hover:shadow-lg duration-200"><svg
                            class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382a13.37 13.37 0 01-5.453-5.453l2.032-2.032a1.12 1.12 0 00.273-1.112l-.637-2.13A1.12 1.12 0 0012.6 3.6h-2.25A2.25 2.25 0 008.1 5.85c0 7.18 5.82 13 13 13a2.25 2.25 0 002.25-2.25v-2.25a1.12 1.12 0 00-.885-1.09l-2.13-.637a1.12 1.12 0 00-1.112.273l-2.032 2.032z" />
                        </svg>WhatsApp: +62-896-145-146-47</a>
                    <a href="https://linkedin.com/in/r-abdullah-hammami" target="_blank"
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-800 hover:bg-blue-100 transition transform hover:scale-105 hover:shadow-lg duration-200"><svg
                            class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M12.293 2.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-8 8a1 1 0 01-.707.293H5a1 1 0 01-1-1v-4a1 1 0 01.293-.707l8-8z" />
                        </svg>LinkedIn: Alfalimbany Tech</a>
                    <a href="https://instagram.com/rf7404" target="_blank"
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-100 text-pink-700 hover:bg-pink-200 transition transform hover:scale-105 hover:shadow-lg duration-200"><svg
                            class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5a4.25 4.25 0 0 0 4.25-4.25v-8.5A4.25 4.25 0 0 0 16.25 3.5zm4.25 2.25a5.25 5.25 0 1 1-5.25 5.25a5.25 5.25 0 0 1 5.25-5.25zm0 1.5a3.75 3.75 0 1 0 3.75 3.75a3.75 3.75 0 0 0-3.75-3.75zm5.25 1.25a1 1 0 1 1-2 0a1 1 0 0 1 2 0z" />
                        </svg>Instagram: @RF7404</a>
                </div>
            </div>
        </div>
        <div class="text-center text-base text-blue-700 border-t pt-6 mt-12 tracking-wide animate-fade-in-slow bg-blue-50">
            Terima kasih telah mempercayakan pengembangan sistem Anda kepada <span
                class="font-semibold text-green-700">Alfalimbany Tech</span>. <span class="ml-1">🚀</span>
        </div>
        <div class="flex justify-center mt-8 mb-6">
            <a href="/"
                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition text-base">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Halaman Beranda
            </a>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-slow {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s cubic-bezier(.4, 0, .2, 1) both;
        }

        .animate-fade-in-slow {
            animation: fade-in-slow 1.2s cubic-bezier(.4, 0, .2, 1) both;
        }
    </style>
@endsection
