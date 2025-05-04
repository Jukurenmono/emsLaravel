<div class="w-64 bg-gray-900 shadow-md min-h-screen p-4 text-white">
    <div class="p-6 border-b border-gray-700">
        <h1 class="text-xl font-bold text-white">E-M-A-M-S Admin</h1>
        <h1 class="text-xs font-bold text-gray-300">(Employee Management and Attendance Monitoring System)</h1>
    </div>
    <nav class="mt-4">
        <ul>
            <li>
                <a href="/dashboard"
                   class="block px-6 py-3 text-gray-200 hover:bg-gray-800 {{ request()->is('dashboard') ? 'bg-gray-800 font-semibold' : '' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/employees"
                   class="block px-6 py-3 text-gray-200 hover:bg-gray-800 {{ request()->is('employees') ? 'bg-gray-800 font-semibold' : '' }}">
                    Employees
                </a>
            </li>
            <li>
                <a href="/attendance_list"
                   class="block px-6 py-3 text-gray-200 hover:bg-gray-800 {{ request()->is('attendance_list') ? 'bg-gray-800 font-semibold' : '' }}">
                    Attendance
                </a>
            </li>
        </ul>
    </nav>
</div>
