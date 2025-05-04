<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        @include('partials.sidebar')

        <main class="flex-1 p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dashboard</h2>

            <div class="bg-white p-6 rounded shadow mb-6">
                <p class="text-gray-700 mb-6">Welcome back, Admin {{ Auth::user()->name }}</p>

                <!-- To-Do List -->
                <div class="bg-gray-50 p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-4">Task List</h3>

                    <!-- Add New Task Form -->
                    <form action="{{ route('tasks.store') }}" method="POST" class="flex mb-4">
                        @csrf
                        <input type="text" name="title" placeholder="New task..." 
                               class="flex-1 p-2 border rounded-l focus:outline-none" required>
                        <button type="submit" class="bg-gray-800 text-gray-200 hover:bg-gray-700 p-2 rounded-r">
                            Add
                        </button>
                    </form>

                    <!-- Tasks List -->
                    <ul>
                        @forelse($tasks as $task)
                            <li class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="mr-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                    </form>
                                    <span class="{{ $task->completed ? 'line-through text-gray-500' : '' }}">
                                        {{ $task->title }}
                                    </span>
                                </div>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </li>
                        @empty
                            <li class="text-gray-500 text-center py-4">
                                No tasks yet. Add one above! 🚀
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
