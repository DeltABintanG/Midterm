<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Edit Task
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg dark:bg-gray-800">
                <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="title" class="block text-gray-700 dark:text-gray-200">Title</label>
                        <input type="text" name="title" value="{{ old('title', $task->title) }}"
                            class="w-full rounded border px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <div>
                        <label for="description" class="block text-gray-700 dark:text-gray-200">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full rounded border px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div>
                        <label for="due_date" class="block text-gray-700 dark:text-gray-200">Due Date</label>
                        <input type="date" name="due_date" id="due_date"
                            value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                            class="w-full rounded border px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <div>
                        <label for="category_id" class="block text-gray-700 dark:text-gray-200">Category</label>
                        <select name="category_id"
                            class="w-full rounded border px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <option value="">None</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $task->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_completed" id="is_completed" value="1"
                            {{ $task->is_completed ? 'checked' : '' }}>
                        <label for="is_completed" class="text-gray-700 dark:text-gray-200">Completed</label>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('tasks.index') }}"
                            class="rounded bg-gray-500 px-4 py-2 text-white transition hover:bg-gray-600">Cancel</a>
                        <button type="submit"
                            class="rounded bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700">Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
