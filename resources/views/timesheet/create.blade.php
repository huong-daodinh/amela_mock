<x-app-layout>
    <div class="flex justify-center py-12">
        <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">Check In</h5>
            <div class="flex items-baseline text-gray-900 dark:text-white">
            <span class="text-xl font-extrabold">Time:</span>
            <span class="mx-2 text-xl font-normal text-black dark:text-gray-400">{{ date('d/m/Y') }}</span>
        </div>

        <form action=" {{ route('store') }} " method="POST">
            @csrf
            <input type="time" value="{{ date('h:i A') }}" name="time_in">
            <button type="submit" class="px-7 py-2 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Check-in</button>
        </form>
    </div>

    </div>
</x-app-layout>
