<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Stats Cards -->
            <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="rounded-lg bg-white p-6 text-center shadow-sm dark:bg-gray-800">
                    <h3 class="text-gray-500 dark:text-gray-400">Total Tasks</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalTasks }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 text-center shadow-sm dark:bg-gray-800">
                    <h3 class="text-gray-500 dark:text-gray-400">Completed</h3>
                    <p class="text-3xl font-bold text-green-500">{{ $completedTasks }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 text-center shadow-sm dark:bg-gray-800">
                    <h3 class="text-gray-500 dark:text-gray-400">Pending</h3>
                    <p class="text-3xl font-bold text-red-500">{{ $pendingTasks }}</p>
                </div>
            </div>

            <!-- Task List -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Your Tasks</h3>
                    <a href="{{ route('tasks.create') }}"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">+ Add Task</a>
                </div>

                @if ($tasks->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Title</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Due Date</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-100">
                                        {{ $task->title }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($task->is_completed)
                                            <span
                                                class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Completed</span>
                                        @else
                                            <span
                                                class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Pending</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-500 dark:text-gray-300">
                                        {{ $task->due_date?->format('M d, Y') }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('tasks.edit', $task->id) }}"
                                            class="mr-3 text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No tasks yet. Add a new task to get started!</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
