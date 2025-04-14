<div class="w-64 bg-white shadow-md min-h-screen p-4">
    <div class="p-6 border-b">
        <h1 class="text-2xl font-bold text-gray-800">EMS Admin</h1>
    </div>
    <nav class="mt-4">
        <ul>
            <li>
                <a href="/dashboard"
                   class="block px-6 py-3 text-gray-700 hover:bg-gray-200 {{ request()->is('dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/employees"
                   class="block px-6 py-3 text-gray-700 hover:bg-gray-200 {{ request()->is('employees') ? 'bg-gray-200 font-semibold' : '' }}">
                    Employees
                </a>
            </li>
            <li>
                <a href="/attendance_list"
                   class="block px-6 py-3 text-gray-700 hover:bg-gray-200 {{ request()->is('attendance_list') ? 'bg-gray-200 font-semibold' : '' }}">
                    Attendance
                </a>
            </li>
        </ul>
    </nav>
</div>
