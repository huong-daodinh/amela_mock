<x-app-layout>
    <div class="flex justify-center py-12">
        <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">Check In</h5>
            <div class="flex items-baseline text-gray-900 dark:text-white">
            <span class="text-xl font-extrabold">Time:</span>
            <span class="mx-2 text-xl font-normal text-black dark:text-gray-400" id="time"></span>
        </div>

        <form action=" {{ route('timesheet.store') }} " method="POST" class="mt-5">
            @csrf
            @php
                if (!isset($timesheets)) {
                    $name = 'check_in';
                }
                if (isset($timesheets->check_in)) {
                    $name = 'check_out';
                }
            @endphp
            <input type="time" name="{{ $name }}" style="display: none">
            <button type="submit" class="px-7 py-2 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Check-in</button>
        </form>
    </div>
    </div>
</x-app-layout>

<x-js>
    function updateTime() {
        const now = new Date();
        const date = now.getDate().toString();
        const month = now.getMonth().toString();
        const year = now.getFullYear().toString();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        {{-- const seconds = now.getSeconds().toString(); --}}

        {{-- const time = `${date}/${month}/${year}  ${hours}:${minutes}`; --}}
        const time = `${date}/${month}/${year}  ${hours}:${minutes}:${seconds}`;
        document.getElementById('time').textContent = time;
    }

    setInterval(updateTime, 1000);
    updateTime();
</x-js>
