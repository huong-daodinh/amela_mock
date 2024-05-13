<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Timesheets / Index' }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="d-flex justify-between pt-4 pb-1">
            <div class="flex justify-end item-center">
                <a class="mx-4 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" href="{{route('timesheet.create')}}">Create new timesheet</a>
                <form action="" class="mb-5">
                    @csrf
                    <input type="text" name="search" id="" class="block text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search....">
                </form>
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
                          Status
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">
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
