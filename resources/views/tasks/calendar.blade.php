<?php
use Carbon\Carbon;
?>

<x-app-layout>
    @php
        $today = Carbon::today();
        $currentMonth = request('month') ? Carbon::parse(request('month')) : $today->copy()->startOfMonth();
        $firstDay = $currentMonth->copy()->startOfMonth();
        $lastDay = $currentMonth->copy()->endOfMonth();
        $startDate = $firstDay->copy()->startOfWeek(Carbon::SUNDAY);
        $endDate = $lastDay->copy()->endOfWeek(Carbon::SATURDAY);
    @endphp

    <div class="mx-auto max-w-6xl py-6 sm:px-6 lg:px-8">
        <h1 class="mb-6 text-center text-2xl font-bold text-gray-200">
            {{ $currentMonth->format('F Y') }}
        </h1>

        <div class="mb-4 flex justify-between">
            <a href="{{ route('tasks.calendar', ['month' => $currentMonth->copy()->subMonth()->format('Y-m')]) }}"
                class="text-blue-500 hover:underline">« Prev</a>
            <a href="{{ route('tasks.calendar', ['month' => $currentMonth->copy()->addMonth()->format('Y-m')]) }}"
                class="text-blue-500 hover:underline">Next »</a>
        </div>

        <div class="overflow-x-auto rounded-lg bg-white p-4 shadow dark:bg-gray-800">
            <table class="w-full table-auto border-collapse border border-gray-300 dark:border-gray-700">
                <thead class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="border border-gray-300 p-2">Sun</th>
                        <th class="border border-gray-300 p-2">Mon</th>
                        <th class="border border-gray-300 p-2">Tue</th>
                        <th class="border border-gray-300 p-2">Wed</th>
                        <th class="border border-gray-300 p-2">Thu</th>
                        <th class="border border-gray-300 p-2">Fri</th>
                        <th class="border border-gray-300 p-2">Sat</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $date = $startDate->copy();
                    @endphp

                    @while ($date <= $endDate)
                        <tr>
                            @for ($i = 0; $i < 7; $i++)
                                @php
                                    $isCurrentMonth = $date->month == $currentMonth->month;
                                    $tasksForDay = $tasks->filter(
                                        fn($task) => $task->due_date && $task->due_date->isSameDay($date),
                                    );
                                @endphp
                                <td
                                    class="{{ $isCurrentMonth ? 'bg-white dark:bg-gray-800' : 'bg-gray-100 dark:bg-gray-700 opacity-50' }} h-28 w-32 border border-gray-300 p-2 align-top">
                                    <div
                                        class="{{ $isCurrentMonth ? 'text-gray-800 dark:text-gray-200' : 'text-gray-400' }} text-sm font-bold">
                                        {{ $date->day }}
                                    </div>

                                    @foreach ($tasksForDay as $task)
                                        <div class="mt-1 truncate text-xs text-blue-600 dark:text-blue-400">
                                            • {{ $task->title }}
                                        </div>
                                    @endforeach
                                </td>
                                @php $date->addDay(); @endphp
                            @endfor
                        </tr>
                    @endwhile
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
