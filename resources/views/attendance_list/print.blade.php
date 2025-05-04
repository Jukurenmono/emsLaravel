<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report - {{ $selectedDate }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
        .date { margin-top: 10px; font-size: 14px; text-align: center; }
    </style>
</head>
<body>
    <h2>Employee Attendance Report</h2>
    <div class="date">Date: {{ $selectedDate->format('F d, Y') }}</div>

    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Position</th>
                <th>Employee ID</th>
                <th>Time In</th>
                <th>Time Out</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->name }}</td>
                    <td>{{ $attendance->position }}</td>
                    <td>{{ $attendance->employee_id }}</td>
                    <td>{{ $attendance->time_in->format('h:i A') }}</td>
                    <td>{{ $attendance->time_out ? $attendance->time_out->format('h:i A') : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No attendance records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };

        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>
</html>
