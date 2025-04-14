<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Main Content -->
    <div class="p-6">
        <!-- Flash Messages -->
        @include('partials.flash')

        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Employee Attendance</h2>

        <!-- Attendance Form -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <form method="POST" action="/attendance">
                @csrf
                <div class="flex flex-col md:flex-row md:space-x-4">
                    <input type="text" name="employee_id" placeholder="Employee ID" required class="border p-2 rounded mb-4 md:mb-0 md:w-1/4">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Mark Attendance</button>
                </div>
            </form>
        </div>

        <!-- Attendance Records -->
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
                    @foreach ($attendances as $attendance)
                        <tr class="border-b">
                            <td class="p-2">{{ $attendance->name }}</td>
                            <td class="p-2">{{ $attendance->position }}</td>
                            <td class="p-2">{{ $attendance->employee_id }}</td>
                            <td class="p-2">{{ $attendance->attended_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
