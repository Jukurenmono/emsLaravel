<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        @include('partials.sidebar')

        <main class="flex-1 p-6">
            @include('partials.flash')

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Employee Attendance</h2>

            <!-- Attendance Records Filter Section -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <div class="flex items-center justify-between">
                    <!-- Left side: Label and Date input -->
                    <div class="flex items-center space-x-2">
                        <label for="date-input" class="text-gray-700 font-medium">Select Date:</label>
                        <form method="GET" action="/attendance_list" id="attendance-form">
                            <input type="date" name="date" id="date-input" value="{{ $selectedDate ?? now()->toDateString() }}" class="border p-2 rounded">
                        </form>
                    </div>

                    <!-- Right side: Print button -->
                    <a href="{{ route('attendance_list.print', ['date' => request('date', now()->toDateString())]) }}" 
                        target="_blank"
                        class="bg-green-500 text-white px-4 py-2 rounded" id="print-report-btn">
                        Print Report
                    </a>
                </div>

                <p class="text-sm text-gray-500 mt-2">Select a date and click 'Filter' to update the attendance list.</p>
            </div>

            <!-- Attendance Records Section -->
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Attendance Records</h3>
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2">Employee Name</th>
                            <th class="p-2">Position</th>
                            <th class="p-2">Employee ID</th>
                            <th class="p-2">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $attendance)
                            <tr class="border-b">
                                <td class="p-2">{{ $attendance->name }}</td>
                                <td class="p-2">{{ $attendance->position }}</td>
                                <td class="p-2">{{ $attendance->employee_id }}</td>
                                <td class="p-2">{{ $attendance->attended_at->format('F d, Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-2 text-center text-gray-500">No attendance records found.</td>
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
