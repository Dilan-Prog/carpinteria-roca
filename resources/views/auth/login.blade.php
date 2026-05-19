<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">

            {{-- Header --}}
            <div class="p-8 text-center border-b border-gray-200">
                <h1 class="text-4xl font-bold text-[#E53935] mb-2">Roca</h1>
                <p class="text-gray-600">Sistema de Gestión</p>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="px-8 pt-4" :status="session('status')" />

            {{-- Tabs --}}
            <div class="flex border-b border-gray-200" role="tablist">
                <button
                    id="tab-login"
                    role="tab"
                    aria-selected="true"
                    aria-controls="panel-login"
                    onclick="switchTab('login')"
                    class="flex-1 py-4 text-sm font-medium transition-colors text-[#E53935] border-b-2 border-[#E53935] bg-red-50"
                >
                    Administrador / Empleado
                </button>
                <a
                    id="tab-orders"
                    role="tab"
                    aria-selected="false"
                    href="{{ Route::has('orders.guest') ? route('orders.guest') : '#' }}"
                    class="flex-1 py-4 text-sm font-medium transition-colors text-center text-gray-500 hover:text-gray-700"
                >
                    Consultar Pedido
                </a>
            </div>

            {{-- Login Panel --}}
            <div id="panel-login" role="tabpanel" aria-labelledby="tab-login" class="p-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo electrónico
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="correo@ejemplo.com"
                            aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                            class="w-full px-4 py-3 border rounded-lg outline-none transition
                                   focus:ring-2 focus:ring-[#E53935] focus:border-[#E53935]
                                   {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                        >
                        @error('email')
                            <p id="email-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                aria-describedby="{{ $errors->has('password') ? 'password-error' : '' }}"
                                class="w-full px-4 py-3 pr-12 border rounded-lg outline-none transition
                                       focus:ring-2 focus:ring-[#E53935] focus:border-[#E53935]
                                       {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}"
                            >
                            <button
                                type="button"
                                id="toggle-password"
                                aria-label="Mostrar u ocultar contraseña"
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            >
                                {{-- Eye icon (visible when password is hidden) --}}
                                <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     aria-hidden="true">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                {{-- Eye-off icon (visible when password is shown) --}}
                                <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     aria-hidden="true" class="hidden">
                                    <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/>
                                    <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/>
                                    <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/>
                                    <path d="m2 2 20 20"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p id="password-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="w-full bg-[#E53935] text-white py-3 rounded-lg font-medium
                               hover:bg-[#C62828] transition-colors focus:outline-none
                               focus:ring-2 focus:ring-offset-2 focus:ring-[#E53935]"
                    >
                        Iniciar sesión
                    </button>

                    {{-- Forgot password --}}
                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a
                                href="{{ route('password.request') }}"
                                class="text-sm text-[#E53935] hover:underline"
                            >
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    {{-- Demo credentials (local only) --}}
                    @if (app()->isLocal())
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-600 font-medium mb-2">Demo — Credenciales de prueba:</p>
                            <p class="text-xs text-gray-500">Admin: admin@roca.com / admin123</p>
                            <p class="text-xs text-gray-500">Empleado: empleado@roca.com / emp123</p>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input   = document.getElementById('password');
            const iconOn  = document.getElementById('icon-eye');
            const iconOff = document.getElementById('icon-eye-off');
            const btn     = document.getElementById('toggle-password');

            if (input.type === 'password') {
                input.type = 'text';
                iconOn.classList.add('hidden');
                iconOff.classList.remove('hidden');
                btn.setAttribute('aria-label', 'Ocultar contraseña');
            } else {
                input.type = 'password';
                iconOn.classList.remove('hidden');
                iconOff.classList.add('hidden');
                btn.setAttribute('aria-label', 'Mostrar contraseña');
            }
        }

        function switchTab(tab) {
            // Only the login tab is interactive here; the orders tab is a plain link.
            // This function exists so it can be extended when the orders panel is added.
            const loginTab = document.getElementById('tab-login');

            if (tab === 'login') {
                loginTab.classList.add('text-[#E53935]', 'border-b-2', 'border-[#E53935]', 'bg-red-50');
                loginTab.classList.remove('text-gray-500');
                loginTab.setAttribute('aria-selected', 'true');
            }
        }
    </script>
</x-guest-layout>
