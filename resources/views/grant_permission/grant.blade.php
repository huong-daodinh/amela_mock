<x-app-layout>
    @php
        $fields = [];
        $fieldPermissions = []; // check trùng lặp
        $permissionFields = [];
        foreach($permissions as $item) {
            $field = explode('_', $item->name)[0];
            $permission = explode('_', $item->name)[1];
            if (!in_array($field, $fields)) {
                $fields[] = $field;
                $fieldPermissions[$field] = [];
            }
            if (!in_array($permission, $fieldPermissions)) {
                $fieldPermissions[] = $permission;
                $permissionFields[$permission] = [];
            }
            $permissionFields[$permission][] = $field;
        }
        // dd($fields, $permissionFields);
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Permisson / Grant' }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <div class="relative overflow-x-auto">
        <div class="relative overflow-x-auto bg-white">
            <form action="" method="POST">
                @csrf
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <div class="text-lg px-5 py-5">Recall/Grant permision to <span class="text-indigo-500 font-bold">{{$user->name}}</span></div>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                            </th>
                            @foreach ($fields as $field)
                                <th scope="col" class="px-6 py-3">
                                    {{ $field }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissionFields as $key => $values)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ucfirst($key)}}
                            </th>
                            @foreach ($values as $value)
                                <td class="px-6 py-4">
                                    <input  id="default-checkbox"
                                            name="{{$value. '_' . $key}}"
                                            type="checkbox"
                                            @foreach ($permissions as $permission)
                                                    @if ($permission->name == $value . '_' . $key)
                                                        value="{{$permission->id}}"
                                                        {{in_array($permission->id, $userPermissions) ? 'checked' : null}}
                                                    @endif
                                            @endforeach
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    >
                                </td>
                            @endforeach

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="ml-5 mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
                <x-back-btn/>
            </form>
        </div>
    </div>
</x-app-layout>
