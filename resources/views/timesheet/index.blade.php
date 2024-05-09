<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Timesheets' }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 bg-white">
        <div class="flex justify-center">
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
                                <a href="" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" >Edit</a> |
                                <a href="" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
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
