<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Employees' }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <div class="relative overflow-x-auto">

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <div class="inline-flex items-center">
                                Name
                                <div class="inline-flex flex-col mx-3">
                                    {{-- <a href="{{ route('sort', ['column' => 'name', 'direction' => 'asc']) }}"><i class="fa-solid fa-caret-up"></i></a>
                                    <a href="{{ route('sort', ['column' => 'name', 'direction' => 'desc']) }}"><i class="fa-solid fa-caret-down"></i></a> --}}
                                    <button class=" px-4 data-sort" data-column="name" data-direction="asc" href=""><i class="fa-solid fa-caret-up"></i></button>
                                    <button class=" px-4 data-sort" data-column="name" data-direction="desc" href=""><i class="fa-solid fa-caret-down"></i></button>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="inline-flex items-center">
                                Email
                                <div class="inline-flex flex-col mx-3">
                                    <button class=" px-4 data-sort" data-column="email" data-direction="asc" href=""><i class="fa-solid fa-caret-up"></i></button>
                                    <button class=" px-4 data-sort" data-column="email" data-direction="desc" href=""><i class="fa-solid fa-caret-down"></i></button>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="inline-flex items-center">
                                Age
                                <div class="inline-flex flex-col mx-3">
                                    <button class=" px-4 data-sort" data-column="date_of_birth" data-direction="asc" href=""><i class="fa-solid fa-caret-up"></i></button>
                                    <button class=" px-4 data-sort" data-column="date_of_birth" data-direction="desc" href=""><i class="fa-solid fa-caret-down"></i></button>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="inline-flex items-center">
                                Department
                                <div class="inline-flex flex-col mx-3">
                                    <button class=" px-4 data-sort" data-column="department_id" data-direction="asc" href=""><i class="fa-solid fa-caret-up"></i></button>
                                    <button class=" px-4 data-sort" data-column="department_id" data-direction="desc" href=""><i class="fa-solid fa-caret-down"></i></button>
                                </div>
                            </div>
                        </th>
                        @if (Auth::user()->is_admin)
                            <th scope="col" class="px-6 py-3 text-center">
                                Action
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$user->name}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$user->email}}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $date = explode('-', $user->date_of_birth);
                                        echo date('Y') - $date[0];
                                    @endphp
                                </td>
                                <td class="px-6 py-4">
                                    {{$user->department->name}}
                                </td>
                                @if (Auth::user()->is_admin)
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('employee.update.show', $user->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a> |
                                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                                    </td>
                                @endif
                            </tr>
                    @empty
                        <tr>
                            <th colspan="5">No data</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="py-3">
        {{$users->links()}}
    </div>
</div>
</x-app-layout>

<x-js>
    document.querySelectorAll('.data-sort').forEach( function(button) {
        button.addEventListener('click', function() {
            const column = this.dataset.column;
            const direction = this.dataset.direction;
            const url = `{{ route('sort') }}?page=&column=${column}&direction=${direction}`;
            this.style.display = 'none';
            window.location.href = url;
        })
    })
</x-js>
