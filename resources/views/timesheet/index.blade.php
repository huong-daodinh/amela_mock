<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Timesheets / Index' }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="d-flex justify-between pt-4 pb-1">
            <div class="flex justify-between mb-5">
                <form action="{{route('timesheet.index')}}" class="flex justify-between gap-5 items-end" method="POST">
                    @csrf
                    <div class="">
                        <input type="text" name="search" id="" class="block text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search....">
                    </div>
                    <div>
                        <label for="from">From</label>
                        <input type="date" name="from" id="" class="block text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div>
                        <label for="from">To</label>
                        <input type="date" name="to" id="" class="block text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Search</button>
                    </div>
                </form>
                <div class="">
                    <a class="mx-4 py-2.5 px-2 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" href="{{route('timesheet.create')}}">Create new timesheet</a>
                </div>
            </div>
            <table class="min-w-full leading-normal">
                <thead class="bg-slate-200">
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        Employee's name
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        Date
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        Time
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        Duration
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($timesheets as $item)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{$item->user->name}}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{$item->date}}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="text-gray-600 whitespace-no-wrap">{{$item->check_in}}</span> /
                                <span class="text-gray-600 whitespace-no-wrap">{{$item->check_out}}</span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @php
                                    $checkOutTime = Carbon\Carbon::createFromTimeString($item->check_out);
                                @endphp
                                <span class="text-gray-600 whitespace-no-wrap">{{ gmdate('H:i', $checkOutTime->diffInSeconds($item->check_in)) }}</span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative">{{$item->check_in_status}}</span>
                                </span>
                                /
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative">{{$item->check_out_status}}</span>
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm" >
                                <a href="{{route('timesheet.edit', $item->id)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" >Edit</a> |
                                <a href="{{route('timesheet.destroy', $item->id)}}" onclick="sure()" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th>
                                {{'No datas'}}
                            </th>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        <div class="mt-3 px-4">
            {{$timesheets->links()}}
        </div>
    </div>
</x-app-layout>

<x-js>
    function sure() {
        confirm('Are you sure to delete ?');
    }
</x-js>
