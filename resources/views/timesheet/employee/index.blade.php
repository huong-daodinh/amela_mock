<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Timesheets / Histories' }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <div class="d-flex justify-between bg-white pt-4 pb-1">
            <div class="flex justify-end px-5">
                <a class="mx-4 py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" href="{{route('timesheet.create')}}">Checkin / Checkout</a>
                <form action="">
                    @csrf
                    <input type="text" name="search" id="" class="block text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search....">
                </form>
            </div>
            <table class="min-w-full leading-normal my-5">
                <thead class="bg-slate-200">
                <tr class="">
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Employee's name
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Date
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Time
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Status
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse ($timesheets as $item)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ Auth::user()->name }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $item->date}}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="text-gray-600 whitespace-no-wrap">{{$item->check_in}}</span> /
                            <span class="text-gray-600 whitespace-no-wrap">{{$item->check_out}}</span>
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
                    </tr>
                @empty
                    <tr>
                        <th colspan="4">
                            {{ 'You have no datas' }}
                        </th>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mx-3">
            {{$timesheets->links()}}
        </div>
    </div>
</x-app-layout>
