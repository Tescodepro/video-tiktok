<nav x-data="{ open: false }" @click.away="open = false" class="bg-white border-b border-gray-200 shadow-sm fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left: Logo + Links -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <x-application-logo class="h-8 w-auto text-blue-600" />
                    <span class="text-lg font-semibold text-gray-800">TikTok Clone</span>
                </a>
                <div class="hidden sm:flex space-x-8 ml-10">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-nav-link>
                    @auth
                        <x-nav-link :href="route('videos.store')" :active="request()->routeIs('videos.store')">Upload</x-nav-link>
                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">Profile</x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Right: Auth/User Info -->
            <div class="hidden sm:flex items-center space-x-4">
                @auth
                    <div class="flex items-center gap-3">
                        <!-- Avatar -->
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                            alt="Avatar" class="h-8 w-8 rounded-full">
                        <!-- Name -->
                        <span class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</span>
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-red-500">Log Out</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-600">Log In</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-blue-600">Register</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="sm:hidden">
                <button @click="open = !open" class="p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0"
         class="sm:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('videos.store')" :active="request()->routeIs('videos.store')">Upload</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">Profile</x-responsive-nav-link>
            @endauth
        </div>
        <div class="pt-4 pb-1 border-t border-gray-100">
            @auth
                <div class="px-4 flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                        alt="Avatar" class="h-8 w-8 rounded-full">
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                    </form>
                </div>
            @else
                <x-responsive-nav-link :href="route('login')">Log In</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">Register</x-responsive-nav-link>
            @endauth
        </div>
    </div>
</nav>