<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                @php
        $adminGuard = Auth::guard('admin');
        $userGuard = Auth::guard('web');
        $webUser = $userGuard->check() ? $userGuard->user() : null;
        $adminUser = $adminGuard->check() ? $adminGuard->user() : null;
        $authUser = $webUser ?? $adminUser;
        $isAdmin = $adminGuard->check();
    @endphp

    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        @if($webUser)
            <x-nav-link :href="route('profile.show')" :active="request()->routeIs('profile.show')">
                {{ __('L\'Espace') }}
            </x-nav-link>
        @endif

        @if($isAdmin)
            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                {{ __('Admin') }}
            </x-nav-link>
        @endif
    </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if($authUser)
                    <a href="{{ route('profile.show') }}" class="text-gray-500 hover:text-gray-700">
                        {{ $authUser->name }}
                    </a>
                @endif

                @if($isAdmin)
                    <form method="POST" action="{{ route('admin.logout') }}" class="ms-4 inline">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700">
                            {{ __('Admin Logout') }}
                        </button>
                    </form>
                @elseif($authUser)
                    <form method="POST" action="{{ route('logout') }}" class="ms-4">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if($webUser)
                <x-responsive-nav-link :href="route('profile.show')" :active="request()->routeIs('profile.show')">
                    {{ __('L\'Espace') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                @if($authUser)
                    <div class="font-medium text-base text-gray-800">{{ $authUser->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ $authUser->email }}</div>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                @if($webUser)
                    <x-responsive-nav-link :href="route('profile.show')">
                        {{ __('L\'Espace') }}
                    </x-responsive-nav-link>
                @endif

                @if($isAdmin)
                    <x-responsive-nav-link :href="route('admin.dashboard')">
                        {{ __('Admin') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                @if($isAdmin)
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('admin.logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Admin Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @elseif($authUser)
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @endif
            </div>
        </div>
    </div>
</nav>
