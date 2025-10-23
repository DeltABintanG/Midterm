<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="mb-6 bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800">
        <form action="{{ route('tasks.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..."
                class="w-full rounded border px-3 py-2 sm:w-1/3 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">

            <select name="category"
                class="rounded border px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="rounded bg-blue-600 px-4 py-2 text-white transition-colors duration-150 hover:bg-blue-700">
                Search
            </button>

            <a href="{{ route('tasks.create') }}"
                class="ml-auto rounded bg-green-600 px-4 py-2 text-white transition-colors duration-150 hover:bg-green-700">
                + New Task
            </a>
        </form>
    </div>

    <div class="bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800">
        @if ($tasks->isEmpty())
            <p class="text-center text-gray-500 dark:text-gray-400">No tasks found.</p>
        @else
            <table class="min-w-full border border-gray-200 dark:border-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Title</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Description</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Category</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Due Date</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Mark</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Status</th>
                        <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                <span
                                    class="{{ $task->is_completed ? 'line-through text-gray-400 dark:text-gray-500' : '' }}">
                                    {{ $task->title }}
                                </span>
                            </td>

                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                {{ $task->description ?? '-' }}
                            </td>

                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                {{ $task->category->name ?? 'Uncategorized' }}
                            </td>

                            <td class="px-4 py-2 text-center text-gray-900 dark:text-gray-100">
                                @if ($task->due_date)
                                    @php
                                        $isOverdue =
                                            !$task->is_completed && \Carbon\Carbon::parse($task->due_date)->isPast();
                                    @endphp
                                    <span
                                        class="{{ $isOverdue ? 'text-red-500 font-semibold' : 'text-gray-800 dark:text-gray-200' }}">
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                    </span>
                                    @if ($isOverdue)
                                        <span
                                            class="ml-2 rounded bg-red-100 px-2 py-1 text-xs text-red-700">Overdue</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <form action="{{ route('tasks.toggle', $task->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="{{ $task->is_completed ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-500 hover:bg-gray-600' }} rounded px-3 py-1 text-white">
                                        {{ $task->is_completed ? 'Completed' : 'Mark Done' }}
                                    </button>
                                </form>
                            </td>

                            <td class="px-4 py-2 text-center">
                                @if ($task->is_completed)
                                    <span class="rounded bg-green-100 px-2 py-1 text-sm text-green-700">Completed</span>
                                @else
                                    <span class="rounded bg-yellow-100 px-2 py-1 text-sm text-yellow-700">Pending</span>
                                @endif
                            </td>

                            <td class="flex justify-center gap-2 px-4 py-2 text-center">
                                <a href="{{ route('tasks.edit', $task->id) }}"
                                    class="rounded bg-yellow-500 px-3 py-1 text-white hover:bg-yellow-600">
                                    Edit
                                </a>

                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Are you sure you want to delete this task?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <div class="mt-4">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
