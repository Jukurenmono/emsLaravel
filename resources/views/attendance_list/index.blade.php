<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        @include('partials.sidebar')

        <main class="flex-1 p-6">
            @include('partials.flash')

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Employee Attendance</h2>

            <!-- Attendance Records Filter Section -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <!-- Left side: Label, Date input, and Search bar -->
                    <form method="GET" action="/attendance_list" id="attendance-form" class="flex items-center gap-2 flex-wrap">
                        <label for="search" class="text-gray-700 font-medium">Search:</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Employee ID or Name" class="border p-2 rounded">
                        
                        <button type="submit" class="bg-gray-800 text-gray-200 hover:bg-gray-700 mr-4 px-4 py-2 rounded">Search</button>

                        <label for="date-input" class="text-gray-700 font-medium">Select Date:</label>
                        <input type="date" name="date" id="date-input" value="{{ $selectedDate ?? now()->toDateString() }}" class="border p-2 rounded">

                    </form>

                    <!-- Right side: Print button -->
                    <a href="{{ route('attendance_list.print', ['date' => request('date', now()->toDateString())]) }}" 
                        target="_blank"
                        class="bg-green-500 text-white px-4 py-2 rounded" id="print-report-btn">
                        Print Report
                    </a>
                </div>

                <p class="text-sm text-gray-500 mt-2">Search for an employee by name or ID or filter attendance list by date.</p>
            </div>

            <!-- Attendance Records Section -->
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Attendance Records</h3>
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Position</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $attendance)
                            <tr class="border-b">
                                <td class="p-2">{{ $attendance->employee_id }}</td>
                                <td class="p-2">{{ $attendance->name }}</td>
                                <td class="p-2">{{ $attendance->position }}</td>
                                <td class="p-2">
                                    {{ $attendance->time_in ? $attendance->time_in->format('h:i A') : '—' }}
                                </td>
                                <td class="p-2">
                                    {{ $attendance->time_out ? $attendance->time_out->format('h:i A') : '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-2 text-center text-gray-500">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        const dateInput = document.getElementById('date-input');
        const form = document.getElementById('attendance-form');

        dateInput.addEventListener('change', function() {
            form.submit();
        });

        if (!dateInput.value) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
            form.submit();
        }
    </script>
</x-app-layout>
