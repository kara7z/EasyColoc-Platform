@extends('layouts.guest')

@section('title', 'EasyColoc — Gestion de colocation')

@section('content')
  {{-- Background Elements --}}
  <div class="fixed inset-0 overflow-hidden pointer-events-none z-[-1]">
    <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-orange-400/10 blur-[100px] mix-blend-multiply animate-[spin_30s_linear_infinite]"></div>
    <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-red-400/10 blur-[100px] mix-blend-multiply animate-[spin_40s_linear_infinite_reverse]"></div>
    <div class="absolute -bottom-[20%] left-[20%] w-[60%] h-[60%] rounded-full bg-indigo-400/5 blur-[100px] mix-blend-multiply animate-[pulse_10s_ease-in-out_infinite]"></div>
  </div>

  {{-- Hero --}}
  <section class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center min-h-[calc(100vh-8rem)] pt-10" id='features'>
    <div class="animate-[slideRight_0.6s_ease-out] relative z-10">
      
      <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/80 backdrop-blur-md border border-slate-200/60 text-orange-600 text-sm font-bold mb-8 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all cursor-default group">
        <span class="relative flex h-2.5 w-2.5">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-orange-500"></span>
        </span>
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-500 to-red-500">Gestion simple &amp; efficace</span>
      </div>

      <h1 class="text-4xl sm:text-5xl xl:text-6xl font-black text-slate-800 leading-[1.15] tracking-tight">
        La colocation, <br/>
        <span class="relative inline-block mt-2">
          <span class="relative z-10 bg-clip-text text-transparent bg-gradient-to-r from-orange-500 to-red-500">sans les calculs</span>
          <svg class="absolute w-full h-3 -bottom-1 left-0 text-orange-200/50 -z-10" viewBox="0 0 100 20" preserveAspectRatio="none"><path d="M0 10 Q 50 20 100 10" stroke="currentColor" stroke-width="8" fill="none"/></svg>
        </span>
      </h1>
      <p class="mt-6 text-xl text-slate-500 leading-relaxed font-medium max-w-lg">
        Fini les prises de tête à la fin du mois. EasyColoc suit vos dépenses en temps réel et dit précisément
        <span class="font-bold text-slate-800">« qui doit quoi à qui »</span>.
      </p>

      <div class="mt-10 flex flex-col sm:flex-row gap-4 items-center">
        <a href="{{ url('/register') }}" class="w-full sm:w-auto"><x-button-primary class="!py-4 !px-8 text-lg w-full">Commencer gratuitement</x-button-primary></a>
        
        <div class="flex items-center gap-4 mt-4 sm:mt-0 sm:ml-4 text-sm font-medium text-slate-500">
          <div class="flex -space-x-2">
            <div class="w-8 h-8 rounded-full border-2 border-white bg-orange-100 flex items-center justify-center text-xs font-bold text-orange-600">A</div>
            <div class="w-8 h-8 rounded-full border-2 border-white bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-600">M</div>
            <div class="w-8 h-8 rounded-full border-2 border-white bg-green-100 flex items-center justify-center text-xs font-bold text-green-600">J</div>
          </div>
          <div class="flex flex-col">
            <div class="flex items-center gap-1 text-orange-500">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            </div>
            <span class="text-xs font-bold leading-tight mt-0.5">+500 colocations</span>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-center lg:justify-end animate-[slideLeft_0.6s_ease-out] relative z-10">
      <div class="relative w-full max-w-lg">
        {{-- Floating visual elements --}}
        <div class="absolute -top-6 -left-6 bg-white p-4 rounded-2xl shadow-xl shadow-slate-200/50 backdrop-blur-md border border-white z-20 animate-[float_6s_ease-in-out_infinite] hidden md:block group hover:scale-105 transition-transform">
          <div class="flex items-center gap-3">
             <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-500">
               <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
             </div>
             <div>
               <div class="text-xs font-bold text-slate-500 uppercase tracking-wide">Dépense ajoutée</div>
               <div class="text-sm font-extrabold text-slate-800">+ 45.00 € (Courses)</div>
             </div>
          </div>
        </div>

        <div class="absolute -bottom-10 -right-6 bg-white p-4 rounded-2xl shadow-xl shadow-slate-200/50 backdrop-blur-md border border-white z-20 animate-[float_8s_ease-in-out_infinite_reverse] hidden md:block group hover:scale-105 transition-transform">
          <div class="flex items-center gap-3">
             <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-500">
               <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
             </div>
             <div>
               <div class="text-xs font-bold text-slate-500 uppercase tracking-wide">Solde équilibré</div>
               <div class="text-sm font-extrabold text-slate-800">Marc a remboursé Jean</div>
             </div>
          </div>
        </div>

        <div class="absolute inset-0 bg-gradient-to-tr from-orange-400 to-red-500 rounded-[3rem] blur-2xl opacity-20 transform -rotate-6"></div>
        <img src="{{ asset('assets/Illustration1.png') }}" alt="EasyColoc App" class="relative w-full drop-shadow-[0_20px_50px_rgba(0,0,0,0.15)] rounded-[3rem] bg-white border border-slate-100 hover:-translate-y-2 transition-transform duration-500 ease-in-out" />
      </div>
    </div>
  </section>

  {{-- Feature cards --}}
  <section class="mt-32 relative z-10">
    <div class="text-center mb-16 max-w-2xl mx-auto">
      <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight">Une gestion sur pilote automatique</h2>
      <p class="mt-4 text-lg text-slate-500 font-medium">Tout ce dont vous avez besoin pour vivre en communauté, concentré dans une application élégante et rapide.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="p-8 rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/40 hover:-translate-y-2 transition-all duration-300 group">
        <div class="h-14 w-14 rounded-2xl bg-orange-50 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-orange-500 group-hover:text-white transition-all duration-300 shadow-sm text-orange-500">
          <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </div>
        <div class="text-slate-800 font-bold text-xl mb-3">Colocations Centralisées</div>
        <p class="text-slate-500 leading-relaxed font-medium">Créez votre espace, invitez vos amis via un simple lien, et gérez les membres et rôles (Acrtif / Ancien) en quelques clics.</p>
      </div>
      
      <div class="p-8 rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/40 hover:-translate-y-2 transition-all duration-300 group">
        <div class="h-14 w-14 rounded-2xl bg-orange-50 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-orange-500 group-hover:text-white transition-all duration-300 shadow-sm text-orange-500">
          <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="text-slate-800 font-bold text-xl mb-3">Dépenses Intelligentes</div>
        <p class="text-slate-500 leading-relaxed font-medium">Ajoutez vos tickets de caisse. Catégorisez vos achats. Filtrez par mois pour suivre précisément le budget de la maison.</p>
      </div>
      
      <div class="p-8 rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/40 hover:-translate-y-2 transition-all duration-300 group">
        <div class="h-14 w-14 rounded-2xl bg-orange-50 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-orange-500 group-hover:text-white transition-all duration-300 shadow-sm text-orange-500">
          <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </div>
        <div class="text-slate-800 font-bold text-xl mb-3">Balances &amp; Remboursements</div>
        <p class="text-slate-500 leading-relaxed font-medium">Le moteur calcule automatiquement le solde de chacun. Consultez l'onglet « qui doit à qui » et remboursez en un clic.</p>
      </div>
    </div>
  </section>

  {{-- How it works --}}
  <section id="how" class="mt-32 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
    <div class="order-2 lg:order-1 relative">
      <div class="absolute inset-0 bg-gradient-to-tr from-orange-400 to-red-500 rounded-full blur-3xl opacity-20 transform -translate-x-10 -translate-y-10 pointer-events-none"></div>
      <img src="{{ asset('assets/Illustration2.png') }}" alt="Comment ça marche" class="relative w-full max-w-lg drop-shadow-[0_20px_50px_rgba(0,0,0,0.1)] rounded-[3rem] bg-white/50 border border-slate-100 backdrop-blur-sm p-4 hover:scale-105 transition-transform duration-500 ease-out" />
    </div>
    <div class="order-1 lg:order-2">
      <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight mb-8">Démarrez en <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-red-500">3 étapes</span></h2>
      
      <div class="relative pl-10 border-l-2 border-orange-100 space-y-10">
        
        <div class="relative group cursor-default">
          <div class="absolute -left-[50px] top-1 h-8 w-8 rounded-full bg-white border-4 border-orange-100 flex items-center justify-center transition-colors duration-300 group-hover:border-orange-500">
            <div class="h-2 w-2 rounded-full bg-orange-500"></div>
          </div>
          <div class="group-hover:translate-x-2 transition-transform duration-300">
            <h3 class="text-xl font-extrabold text-slate-800 mb-2 group-hover:text-orange-600 transition-colors">Créez votre espace</h3>
            <p class="text-slate-500 font-medium leading-relaxed">Inscrivez-vous et créez votre première colocation. Vous en deviendrez l'administrateur avec un contrôle total sur les paramètres.</p>
          </div>
        </div>

        <div class="relative group cursor-default">
          <div class="absolute -left-[50px] top-1 h-8 w-8 rounded-full bg-white border-4 border-orange-100 flex items-center justify-center transition-colors duration-300 group-hover:border-orange-500">
            <div class="h-2 w-2 rounded-full bg-orange-500"></div>
          </div>
          <div class="group-hover:translate-x-2 transition-transform duration-300">
            <h3 class="text-xl font-extrabold text-slate-800 mb-2 group-hover:text-orange-600 transition-colors">Invitez vos colocs</h3>
            <p class="text-slate-500 font-medium leading-relaxed">Envoyez des invitations directement par email. Vos colocataires reçoivent un jeton unique pour rejoindre l'espace sécurisé.</p>
          </div>
        </div>

        <div class="relative group cursor-default">
          <div class="absolute -left-[50px] top-1 h-8 w-8 rounded-full bg-white border-4 border-orange-100 flex items-center justify-center transition-colors duration-300 group-hover:border-orange-500">
            <div class="h-2 w-2 rounded-full bg-orange-500"></div>
          </div>
          <div class="group-hover:translate-x-2 transition-transform duration-300">
            <h3 class="text-xl font-extrabold text-slate-800 mb-2 group-hover:text-orange-600 transition-colors">Suivez vos dépenses</h3>
            <p class="text-slate-500 font-medium leading-relaxed">Ajoutez qui a payé quoi. L'algorithme se charge de croiser les dettes pour minimiser le nombre de remboursements à effectuer.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- Epic CTA --}}
  <section id="pricing" class="mt-32 mb-16 px-4">
    <div class="relative overflow-hidden rounded-[3rem] bg-gradient-to-br from-slate-900 to-slate-800 p-10 md:p-16 text-white shadow-2xl group border border-slate-700">
      
      {{-- Decorative rings --}}
      <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-gradient-to-r from-orange-500 to-red-600 rounded-full blur-3xl opacity-20 transform translate-x-1/3 -translate-y-1/3 group-hover:scale-110 transition-transform duration-1000 ease-out"></div>
      <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-indigo-500 rounded-full blur-3xl opacity-10 transform -translate-x-1/4 translate-y-1/4 group-hover:scale-110 transition-transform duration-1000 ease-out"></div>

      <div class="relative z-10 flex flex-col items-center text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur border border-white/20 text-white text-sm font-bold mb-8">
          <span>🚀 Totalement Gratuit</span>
        </div>
        
        <h3 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight mb-6 leading-tight">
          Prêt à simplifier <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-red-400">votre colocation ?</span>
        </h3>
        
        <p class="text-slate-300 text-lg md:text-xl font-medium max-w-2xl mb-10 leading-relaxed">
          Rejoignez des milliers de colocataires qui ont arrêté de se prendre la tête avec l'argent. Gérez vos comptes intelligemment dès aujourd'hui.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4">
          <a href="{{ url('/register') }}">
            <button class="py-4 px-10 font-bold rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 text-white hover:to-orange-400 hover:from-red-400 transition-all duration-300 shadow-xl hover:shadow-orange-glow hover:scale-105 active:scale-95 text-lg flex items-center justify-center gap-2">
               Créer mon compte
            </button>
          </a>
          <a href="{{ url('/login') }}">
            <button class="py-4 px-10 font-bold rounded-2xl bg-white/10 backdrop-blur border border-white/20 text-white hover:bg-white/20 transition-all duration-300 active:scale-95 text-lg flex items-center justify-center gap-2">
               Connexion
            </button>
          </a>
        </div>
      </div>
    </div>
  </section>

  <style>
    @keyframes slideRight { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideLeft { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes float { 
      0%, 100% { transform: translateY(0); } 
      50% { transform: translateY(-10px); } 
    }
  </style>
@endsection
