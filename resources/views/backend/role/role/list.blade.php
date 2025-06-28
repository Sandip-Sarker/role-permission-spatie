<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800  leading-tight">
                {{ __('Roles') }}
            </h2>

            <a href="{{route('roles.create')}}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">
                Create
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <x-message></x-message>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full">
                        <thead class="border-gray-50-">
                        <tr class="border-b">
                            <th class="px-6 py-3 text-left">#</th>
                            <td class="px-6 py-3 text-left">Name</td>
                            <td class="px-6 py-3 text-left">Permission</td>
                            <td class="px-6 py-3 text-left">Created</td>
                            <td class="px-6 py-3 text-center">Action</td>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        @if($roles)
                            @foreach($roles as $role)
                                <tr class="border-b">
                                    <td class="px-6 py-3 text-left">{{$loop->iteration}}</td>
                                    <td class="px-6 py-3 text-left">{{$role->name}}</td>
                                    <td class="px-6 py-3 text-left">
                                        {{$role->permissions->pluck('name')->implode(',')}}
{{--                                        <ol>--}}
{{--                                            @foreach($role->permissions as $permission)--}}
{{--                                                <li class="list-item">{{$permission->name}},</li>--}}
{{--                                            @endforeach--}}
{{--                                        </ol>--}}
                                    </td>
                                    <td class="px-6 py-3 text-left">{{\Carbon\Carbon::parse($role->created_at)->format('d M, Y')}}</td>
                                    <td class="px-6 py-3 text-center">
                                        <a href="{{route('roles.edit', $role->id)}}" class="bg-blue-700 text-sm rounded-md px-3 py-2 text-white hover:bg-blue-500">
                                            Edit
                                        </a>

                                        <a href="javascript:void(0);" onclick="deleteRole({{ $role->id }})" class="bg-red-700 text-sm rounded-md px-3 py-2 text-white hover:bg-red-500">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    <div class="my-3">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            function deleteRole(id)
            {
                if(confirm("Are you sure you want to delete?")){
                    $.ajax({
                        url : '{{ route("roles.destroy", ":id") }}'.replace(":id", id),
                        type : 'GET',
                        dataType: 'json',
                        headers:{
                            'x-csrf-token': "{{ csrf_token() }}"
                        },
                        success:function (response){
                            window.location.href = "{{route('roles.index')}}"
                        }
                    })
                }
            }
        </script>
    </x-slot>
</x-app-layout>
