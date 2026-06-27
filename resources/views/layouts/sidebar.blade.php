<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-gray-200 flex flex-col transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0 shadow-2xl md:shadow-none">
    
    <div class="h-20 flex items-center px-8 border-b border-gray-200">
        <div class="w-10 h-10 bg-emerald-600/90 rounded-xl flex items-center justify-center mr-3 shadow-lg shadow-emerald-600/20">
            <i class="fas fa-box-open text-xl text-white"></i>
        </div>
        <span class="font-bold text-[18px] tracking-wide">Inventaris-App</span>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-8 space-y-2">
        <a href="{{ route('dashboard') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->is('dashboard') ? 'bg-emerald-600/10 text-emerald-400 hover:text-green-600 font-medium border border-emerald-500/20' : 'text-slate-500 hover:text-slate-400 hover:bg-white/5' }}">
            <i class="fas fa-chart-pie w-6"></i> Dashboard
        </a>

        <a href="{{ route('barang') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->is('barang*') ? 'bg-emerald-600/10 text-emerald-400 hover:text-green-600 font-medium border border-emerald-500/20' : 'text-slate-500 hover:text-slate-400 hover:bg-white/5' }}">
            <i class="fas fa-boxes-stacked w-6"></i> Data Barang
        </a>

        @if (auth()->user()->role === 'admin')
            <a href="{{ route('kategori') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->is('kategori*') ? 'bg-emerald-600/10 text-emerald-400 hover:text-green-600 font-medium border border-emerald-500/20' : 'text-slate-500 hover:text-slate-400 hover:bg-white/5' }}">
                <i class="fas fa-layer-group w-6"></i> Data Kategori
            </a>
        @endif 

        @if (auth()->user()->role === 'admin')
            <a href="{{ route('supplier') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->is('supplier*') ? 'bg-emerald-600/10 text-emerald-400 hover:text-green-600 font-medium border border-emerald-500/20' : 'text-slate-500 hover:text-slate-400 hover:bg-white/5' }}">
                <i class="fas fa-truck w-6"></i> Data Supplier
            </a>
        @endif

        <a href="{{ route('permintaan') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->is('permintaan*') ? 'bg-emerald-600/10 text-emerald-400 hover:text-green-600 font-medium border border-emerald-500/20' : 'text-slate-500 hover:text-slate-400 hover:bg-white/5' }}">
            <i class="fas fa-hand-holding-dollar w-6"></i> Permintaan
        </a>

        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'gudang')
            <a href="{{ route('mutasi_barang') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->is('mutasi_barang*') ? 'bg-emerald-600/10 text-emerald-400 hover:text-green-600 font-medium border border-emerald-500/20' : 'text-slate-500 hover:text-slate-400 hover:bg-white/5' }}">
                <i class="fas fa-box-archive w-6"></i> Mutasi Barang
            </a>
        @endif

        @if (auth()->user()->role === 'admin')
            <div class="pt-4 border-t border-slate-200">
                <p class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-widest">Admin</p>

                <a href="{{ route('user') }}"
                    class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->is('user*') ? 'bg-emerald-600/10 text-emerald-400 hover:text-green-600 font-medium border border-emerald-500/20' : 'text-slate-500 hover:text-slate-400 hover:bg-white/5' }}">
                    <i class="fas fa-users w-6"></i> Data User
                </a>
            </div>
        @endif
    </nav>

    <div class="px-4 py-6 border-t border-gray-200 bg-slate-50 flex items-center justify-between">
        <a class="font-semibold text-rose-600 hover:text-rose-700 transition-colors w-full text-center md:text-left flex items-center justify-center md:justify-start" href="{{ route('logout') }}">
            Logout <i class="fa-solid fa-arrow-right-from-bracket ms-2"></i>
        </a>
    </div>
</aside>