<!DOCTYPE html>
<html lang="az" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoftMail X | Tailwind Edition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#13b999',
                        brandDark: '#0e9b7e',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .accordion-item.active .accordion-content {
            max-height: 200px;
        }
        .accordion-item.active .icon-rotate {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="#" class="text-2xl font-extrabold flex items-center gap-2">
   <!-- Ən doğru və təhlükəsiz üsul -->
<img src="{{ asset('img/logos/logo2.png') }}" class="w-[200px]" alt="SoftMail X Logo">
            <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="#features" class="hover:text-brand transition-colors">Xüsusiyyətlər</a>
                <a href="#pricing" class="hover:text-brand transition-colors">Qiymətlər</a>
                <a href="#faq" class="hover:text-brand transition-colors">Suallar</a>
            </div>
            <div class="flex items-center gap-4">
                <button class="hidden sm:block text-sm font-bold text-slate-700">Giriş</button>
                <button class="bg-brand hover:bg-brandDark text-white px-6 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-brand/20">Başla</button>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="py-20 lg:py-32 px-6">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-5xl lg:text-7xl font-extrabold leading-[1.1] tracking-tight mb-8">
                    Email marketinqi <span class="text-brand">çox asan</span> oldu.
                </h1>
                <p class="text-lg text-slate-500 mb-10 max-w-lg">
                    SoftMail X ilə müştəri bazanızı saniyələr içində idarə edin və professional kampaniyalar yaradın.
                </p>
                <div class="flex flex-wrap gap-4">
                    <button class="bg-brand hover:bg-brandDark text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all">Pulsuz yoxla</button>
                    <button class="border border-slate-200 hover:border-brand hover:text-brand px-8 py-4 rounded-2xl font-bold text-lg transition-all">Demo bax</button>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 bg-brand/5 rounded-3xl -rotate-2"></div>
                <div class="relative bg-white border border-slate-100 p-8 rounded-3xl shadow-2xl">
                    <div class="flex items-center justify-between mb-8">
                        <div class="h-3 w-20 bg-slate-100 rounded-full"></div>
                        <div class="h-8 w-8 bg-brand/10 rounded-full flex items-center justify-center text-brand">
                            <i class="ti ti-chart-bar"></i>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="h-4 w-full bg-slate-50 rounded-lg"></div>
                        <div class="h-4 w-3/4 bg-slate-50 rounded-lg"></div>
                        <div class="h-24 w-full bg-brand/5 rounded-2xl border border-brand/10 flex items-end p-4 gap-2">
                            <div class="flex-1 bg-brand rounded-t-sm h-1/2"></div>
                            <div class="flex-1 bg-brand rounded-t-sm h-3/4"></div>
                            <div class="flex-1 bg-brand rounded-t-sm h-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-24 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold mb-4">Niyə biz?</h2>
                <p class="text-slate-500">Biznesinizi böyütmək üçün lazım olan bütün alətlər.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-10 rounded-3xl border border-slate-100 hover:border-brand transition-all group">
                    <div class="w-14 h-14 bg-brand/10 rounded-2xl flex items-center justify-center text-2xl text-brand mb-6 group-hover:scale-110 transition-transform">
                        <i class="ti ti-bolt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Sürətli Göndəriş</h3>
                    <p class="text-slate-500">Minlərlə istifadəçiyə saniyələr içində gecikmə olmadan çatın.</p>
                </div>
                <div class="bg-white p-10 rounded-3xl border border-slate-100 hover:border-brand transition-all group">
                    <div class="w-14 h-14 bg-brand/10 rounded-2xl flex items-center justify-center text-2xl text-brand mb-6 group-hover:scale-110 transition-transform">
                        <i class="ti ti-chart-pie"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Dərin Analitika</h3>
                    <p class="text-slate-500">Açılma və kliklənmə faizlərini real vaxtda izləyin.</p>
                </div>
                <div class="bg-white p-10 rounded-3xl border border-slate-100 hover:border-brand transition-all group">
                    <div class="w-14 h-14 bg-brand/10 rounded-2xl flex items-center justify-center text-2xl text-brand mb-6 group-hover:scale-110 transition-transform">
                        <i class="ti ti-device-mobile-message"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Mobil Uyğunluq</h3>
                    <p class="text-slate-500">Bütün şablonlar mobil cihazlarda mükəmməl görünür.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section id="pricing" class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold mb-4">Qiymət Paketləri</h2>
                <p class="text-slate-500">Biznesinizlə birlikdə böyüyən çevik planlar.</p>
            </div>
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Free -->
                <div class="p-10 rounded-[32px] border border-slate-100 flex flex-col">
                    <h4 class="font-bold text-slate-400 mb-4">Başlanğıc</h4>
                    <div class="text-5xl font-black mb-8">30 AZN <span class="text-lg font-medium text-slate-400">/ay</span></div>
                    <ul class="space-y-4 mb-10 flex-1 text-sm font-medium">
                        <li class="flex items-center gap-3"><i class="ti ti-circle-check text-brand text-lg"></i> Daxil etme (manual)</li>
                        <li class="flex items-center gap-3"><i class="ti ti-circle-check text-brand text-lg"></i>300 Mail/ay</li>
                        <li class="flex items-center gap-3 text-slate-300"><i class="ti ti-circle-x text-lg"></i> </li>
                    </ul>
                    <button class="w-full py-4 rounded-2xl border-2 border-slate-100 font-bold hover:border-brand transition-all">İndi Başla</button>
                </div>
                <!-- Pro -->
                <div class="p-10 rounded-[32px] border-2 border-brand bg-white shadow-2xl shadow-brand/10 flex flex-col relative overflow-hidden">
                    <div class="absolute top-5 right-5 bg-brand text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Populyar</div>
                    <h4 class="font-bold text-brand mb-4">Professional</h4>
                    <div class="text-5xl font-black mb-8">39 AZN <span class="text-lg font-medium text-slate-400">/ay</span></div>
                    <ul class="space-y-4 mb-10 flex-1 text-sm font-medium">
                        <li class="flex items-center gap-3"><i class="ti ti-circle-check text-brand text-lg"></i> 10,000 Abunəçi</li>
                        <li class="flex items-center gap-3"><i class="ti ti-circle-check text-brand text-lg"></i> Limitsiz Mail</li>
                        <li class="flex items-center gap-3"><i class="ti ti-circle-check text-brand text-lg"></i> Avtomatlaşdırma</li>
                    </ul>
                    <button class="w-full py-4 rounded-2xl bg-brand text-white font-bold hover:bg-brandDark transition-all">Paketi Seç</button>
                </div>
                <!-- Business -->
                <div class="p-10 rounded-[32px] border border-slate-100 flex flex-col">
                    <h4 class="font-bold text-slate-400 mb-4">Business</h4>
                    <div class="text-5xl font-black mb-8">99 AZN <span class="text-lg font-medium text-slate-400">/ay</span></div>
                    <ul class="space-y-4 mb-10 flex-1 text-sm font-medium">
                        <li class="flex items-center gap-3"><i class="ti ti-circle-check text-brand text-lg"></i> 50,000 Abunəçi</li>
                        <li class="flex items-center gap-3"><i class="ti ti-circle-check text-brand text-lg"></i> Özəl IP Ünvanı</li>
                        <li class="flex items-center gap-3"><i class="ti ti-circle-check text-brand text-lg"></i> VIP Dəstək</li>
                    </ul>
                    <button class="w-full py-4 rounded-2xl border-2 border-slate-100 font-bold hover:border-brand transition-all">İndi Başla</button>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ (Accordions) -->
    <section id="faq" class="py-24 bg-white">
        <div class="max-w-3xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold mb-4">Tez-tez verilən suallar</h2>
            </div>
            
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="accordion-item border border-slate-100 rounded-2xl overflow-hidden">
                    <button onclick="toggleAccordion(this)" class="w-full p-6 text-left flex justify-between items-center bg-white hover:bg-slate-50 transition-colors">
                        <span class="font-bold">Ödənişsiz paketdə hansı limitlər var?</span>
                        <i class="ti ti-chevron-down icon-rotate transition-transform text-brand"></i>
                    </button>
                    <div class="accordion-content bg-white px-6">
                        <p class="pb-6 text-slate-500">Ödənişsiz paketlə 1,000 abunəçiyə qədər baza saxlaya və ayda 5,000 email göndərə bilərsiniz. Bütün əsas şablonlar aktivdir.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="accordion-item border border-slate-100 rounded-2xl overflow-hidden">
                    <button onclick="toggleAccordion(this)" class="w-full p-6 text-left flex justify-between items-center bg-white hover:bg-slate-50 transition-colors">
                        <span class="font-bold">Məlumatlarımın təhlükəsizliyinə necə zəmanət verilir?</span>
                        <i class="ti ti-chevron-down icon-rotate transition-transform text-brand"></i>
                    </button>
                    <div class="accordion-content bg-white px-6">
                        <p class="pb-6 text-slate-500">Bütün datalarınız müasir SSL şifrələmə ilə qorunur və gündəlik olaraq ehtiyat nüsxələri çıxarılır.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="accordion-item border border-slate-100 rounded-2xl overflow-hidden">
                    <button onclick="toggleAccordion(this)" class="w-full p-6 text-left flex justify-between items-center bg-white hover:bg-slate-50 transition-colors">
                        <span class="font-bold">Dəstək xidməti necə işləyir?</span>
                        <i class="ti ti-chevron-down icon-rotate transition-transform text-brand"></i>
                    </button>
                    <div class="accordion-content bg-white px-6">
                        <p class="pb-6 text-slate-500">Hər gün 24 saat ərzində canlı çat və email vasitəsilə texniki dəstək komandamız suallarınızı cavablandırır.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-slate-100 bg-white">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-8">
            <p class="text-sm text-slate-400 italic">© 2026 SoftMail X. "Soft Link Solutions" tərəfindən sevgi ilə.</p>
            <div class="flex gap-6 text-2xl text-slate-300">
                <i class="ti ti-brand-instagram hover:text-brand cursor-pointer transition-colors"></i>
                <i class="ti ti-brand-linkedin hover:text-brand cursor-pointer transition-colors"></i>
                <i class="ti ti-brand-facebook hover:text-brand cursor-pointer transition-colors"></i>
            </div>
        </div>
    </footer>

    <script>
        function toggleAccordion(element) {
            const item = element.parentElement;
            const isActive = item.classList.contains('active');
            
            // Bütün digər accordion-ları bağla (istəyirsənsə)
            document.querySelectorAll('.accordion-item').forEach(el => {
                el.classList.remove('active');
            });

            // Kliklənəni aç və ya bağla
            if (!isActive) {
                item.classList.add('active');
            }
        }
    </script>
</body>
</html>