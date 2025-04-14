<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        @include('partials.sidebar')

        <main class="flex-1 p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Employee</h2>

            <div class="bg-white p-6 rounded shadow">
                <form method="POST" action="/employees/update/{{ $employee->id }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="name" value="{{ $employee->name }}" required class="border p-2 rounded">
                        <input type="email" name="email" value="{{ $employee->email }}" required class="border p-2 rounded">
                        <input type="text" name="position" value="{{ $employee->position }}" required class="border p-2 rounded">
                    </div>
                    <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        Update Employee
                    </button>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
