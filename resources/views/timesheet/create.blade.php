<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Timesheets / Create' }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="d-flex justify-between pt-4 pb-1">
            <form class="w-2/3 mx-auto" method="POST" action="{{route('timesheet.store')}}">
                @csrf
                <div class="mb-5">
                    <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select user:</label>
                    <div class="flex">
                        <select name="user_id" id="user_id"
                                class="rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                            <option value="" selected>Chose user</option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}" {{old('user_id') == $user->id ? 'selected' : null}}>{{ $user->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    @error('user_id')
                    <span class="text-red-700">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select check_in time:</label>
                    <div class="flex">
                        <input  type="time" id="time" name="check_in"
                                class="rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{old('check_in')}}"
                                >

                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-s-0 border-s-0 border-gray-300 rounded-e-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                    </div>
                    @error('check_in')
                        <span class="text-red-700">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select check_out time:</label>
                    <div class="flex">
                        <input  type="time" id="time" name="check_out"
                                class="rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{old('check_out')}}"
                                >
                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-s-0 border-s-0 border-gray-300 rounded-e-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                    </div>
                    @error('check_out')
                        <span class="text-red-700">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="">Select date: </label>
                    <input  datepicker datepicker-format="yyyy/m/d" name="date" type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date"
                            value="{{old('date')}}"
                    >
                    @error('date')
                        <span class="text-red-700">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-5">
                    <input type="checkbox" name="overtime" id="overtime" value="{{old('overtime')}}">
                    <label for="overtime">Overtime ?</label>
                </div>
                <div >
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    <a  href="{{route('timesheet.index')}}"
                        class="bg-transparent hover:bg-blue-500 text-black font-semibold hover:text-white py-2 px-4 border border-black-500 hover:border-transparent rounded"
                    >Back</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
