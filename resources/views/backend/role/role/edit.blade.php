<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800  leading-tight">
                Role / Update
            </h2>

            <a href="{{route('roles.index')}}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('roles.update', $role->id)}}" method="POST">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input type="text" name="name"  value="{{old('name', $role->name)}}" placeholder="Enter Name" class="border-gray-300 shadow-sm w-1/2 rounded-lg" >
                            </div>
                            @error('name')
                            <p class="text-red-500 font-medium"> {{$message}}</p>
                            @enderror
                            <button type="submit" class="bg-slate-700 text-sm rounded-md px-5 py-3 text-white">Save</button>
                        </div>

                        <div class="grid grid-cols-4">

                            @if($permission)
                                @foreach($permission as $permission)
                                    <div class="mt-3">
                                        <input {{ in_array($permission->name, $hasPermissions) ? 'checked' : '' }} type="checkbox"  id="permission-" class="rounded" name="permission[]" value="{{$permission->name}}">
                                        <label for="permission-"> {{ $permission->name }} </label>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script"></x-slot>
</x-app-layout>
