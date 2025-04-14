<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        @include('partials.sidebar')

        <main class="flex-1 p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dashboard</h2>

            <div class="bg-white p-6 rounded shadow mb-6">
                <p class="text-gray-700">Welcome back, Admin!</p>
            </div>
        </main>
    </div>
</x-app-layout>
