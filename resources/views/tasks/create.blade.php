<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 dark:text-gray-300">Title</label>
                        <input type="text" name="title" id="title"
                               class="w-full mt-1 border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-200"
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full mt-1 border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-200"></textarea>
                    </div>

                     <div class="mb-4">
                        <label for="due_date" class="block text-gray-700 dark:text-gray-300">Due Date</label>
                        <input type="date" name="due_date" id="due_date"
                        class="w-full mt-1 border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 dark:text-gray-300">Category</label>
                        <select name="category_id" id="category_id"
                                class="w-full mt-1 border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-200">
                            <option value="">-- None --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('tasks.index') }}"
                           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
