<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        @include('partials.sidebar')
        

        <main class="flex-1 p-6">
        @include('partials.flash')
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Employee List</h2>

            <div class="bg-white p-6 rounded shadow mb-6">
                <form method="POST" action="/employees">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="text" name="name" placeholder="Full Name" required class="border p-2 rounded">
                        <input type="email" name="email" placeholder="Email" required class="border p-2 rounded">
                        <input type="text" name="position" placeholder="Position" required class="border p-2 rounded">
                        <button type="submit" class="bg-gray-800 text-gray-200 hover:bg-gray-700 rounded">
                            Add Employee
                        </button>
                    </div>


                </form>
            </div>

            <div class="bg-white p-6 rounded shadow ">
                <form method="GET" action="/employees" class="mb-4 flex gap-2">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Employee ID or Name" class="border p-2 rounded">
                    <button type="submit" class="bg-gray-800 text-gray-200 hover:bg-gray-700 px-4 py-2 rounded">Filter</button>
                </form>
                
                <table class="w-full table-auto mt-4">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2">Employee_ID</th>
                            <th class="p-2">Name</th>
                            <th class="p-2">Email</th>
                            <th class="p-2">Position</th>
                            <th class="p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr class="border-b">
                            <td class="p-2">{{ $employee->employee_id }}</td>
                            <td class="p-2">{{ $employee->name }}</td>
                            <td class="p-2">{{ $employee->email }}</td>
                            <td class="p-2">{{ $employee->position }}</td>
                            <td class="p-2 space-x-2">
                                <a href="/employees/edit/{{ $employee->id }}" class="text-blue-500 hover:underline">Edit</a>
                                <a href="/employees/delete/{{ $employee->id }}" class="text-red-500 hover:underline"
                                    onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</x-app-layout>
