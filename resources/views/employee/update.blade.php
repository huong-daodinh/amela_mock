<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Employees / Profile' }}
        </h2>
    </x-slot>
    <div class="container mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
        <form class="w-2/3 mx-auto" action="{{ route('employee.update.store', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="relative z-0 w-full mb-5 group flex justify-center">
                <img class="rounded-full w-36 h-36 border" src="
                @if ($user->avatar)
                    {{ asset('/storage/avatars/' . $user->avatar) }}
                @else
                    {{ $user->gender == 1 ? asset('assets/images/avt_male.png') : asset('assets/images/avt_female.png') }}
                @endif
                " alt="Extra large avatar">
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input value="{{ old('email') ? old('email') : $user->email}}" type="text" name="email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  />
                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
                @error('email')
                    <span class="text-red-700">{{$message}}</span>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input value="{{ old('name') ? old('name') : $user->name}}" type="text" name="name" id="floating_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  />
                <label for="floating_Name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Name</label>
                @error('name')
                    <span class="text-red-700">{{$message}}</span>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input value="{{ old('password') }}" type="password" name="password" id="floating_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  />
                <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                @error('password')
                    <span class="text-red-700">{{$message}}</span>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input value="{{ old('password_confirmation') }}" type="password" name="password_confirmation" id="floating_password_confirmation" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  />
                <label for="floating_password_confirmation" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm password</label>
                @error('password_confirmation')
                    <span class="text-red-700">{{$message}}</span>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input value="{{ old('date_of_birth') ? old('date_of_birth') : $user->date_of_birth}}" type="date" name="date_of_birth" id="floating_date_of_birth" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  />
                <label for="floating_date_of_birth" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Date of birth</label>
                @error('date_of_birth')
                    <span class="text-red-700">{{$message}}</span>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_gender" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Gender</label>
                <select name="gender" id="countries" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option value="0" {{$user->gender == 0 ? 'selected' : null}}>Female</option>
                    <option value="1" {{$user->gender == 1 ? 'selected' : null}}>Male</option>
                    <option value="2" {{$user->gender == 2 ? 'selected' : null}}>Prefer not to say</option>
                </select>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_department" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Department</label>
                <select name="department" id="countries" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    @forelse ($departments as $department)
                        <option value="{{$department->id}}" {{$user->department_id == $department->id ? 'selected' : null}} >{{$department->name}}</option>
                    @empty
                        <p>No departments</p>
                    @endforelse
                </select>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input value="{{ $user->avatar }}" type="file" name="avatar" id="floating_avatar" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  />
                <label for="floating_avatar" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Avatar</label>
                @error('avatar')
                    <span class="text-red-700">{{$message}}</span>
                @enderror
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
        </form>

    </div>
</x-app-layout>
