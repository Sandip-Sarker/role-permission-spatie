<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800  leading-tight">
                {{ __('Article') }}
            </h2>

            @can('create articles')
                <a href="{{route('article.create')}}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">
                    Create
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <x-message></x-message>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full" id="yajra-table">
                        <thead class="border-gray-50-">
                        <tr class="border-b">
                            <th class="px-6 py-3 text-left">#</th>
                            <td class="px-6 py-3 text-left">Title</td>
                            <td class="px-6 py-3 text-left">Content</td>
                            <td class="px-6 py-3 text-left">Image</td>
                            <td class="px-6 py-3 text-left">Author</td>
                            <td class="px-6 py-3 text-left">Create</td>
                            <td class="px-6 py-3 text-center">Action</td>
                        </tr>
                        </thead>
{{--                        <tbody class="bg-white">--}}
{{--                        @if($articles)--}}
{{--                            @foreach($articles as $article)--}}
{{--                                <tr class="border-b">--}}
{{--                                    <td class="px-6 py-3 text-left">{{$loop->iteration}}</td>--}}
{{--                                    <td class="px-6 py-3 text-left">{{$article->title ?? ''}}</td>--}}
{{--                                    <td class="px-6 py-3 text-left">{{$article->description ?? ''}}</td>--}}
{{--                                    <td class="px-6 py-3 text-left">--}}
{{--                                        <img src="{{asset('/storage/'. $article->image)}}" height="50" width="50">--}}
{{--                                    </td>--}}
{{--                                    <td class="px-6 py-3 text-left">{{$article->author ?? ''}}</td>--}}
{{--                                    <td class="px-6 py-3 text-left">{{\Carbon\Carbon::parse($article->created_at)->format('d M, Y')}}</td>--}}
{{--                                    <td class="px-6 py-3 text-center">--}}
{{--                                        @can('edit articles')--}}
{{--                                            <a href="{{route('article.edit', $article->id)}}" class="bg-blue-700 text-sm rounded-md px-3 py-2 text-white hover:bg-blue-500">--}}
{{--                                                Edit--}}
{{--                                            </a>--}}
{{--                                        @endcan--}}

{{--                                        @can('destroy articles')--}}
{{--                                            <a href="javascript:void(0);" onclick="deleteArticle({{ $article->id }})" class="bg-red-700 text-sm rounded-md px-3 py-2 text-white hover:bg-red-500">--}}
{{--                                                Delete--}}
{{--                                            </a>--}}
{{--                                        @endcan--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                        </tbody>--}}
                    </table>

{{--                    <div class="my-3">--}}
{{--                        {{ $articles->links() }}--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            $(function () {
                $('#yajra-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('article.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'title', name: 'title'},
                        {data: 'description', name: 'description'},
                        {data: 'image', name: 'image', orderable: false, searchable: false},
                        {data: 'author', name: 'author'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
            });




            function deleteArticle(id)
            {
                if(confirm('Are you sure you want to delete?')){
                    $.ajax({
                        url : '{{route('article.destroy', ":id")}}'.replace(":id", id),
                        type: 'GET',
                        dataType : 'json',
                        headers:{
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success:function (response){
                            window.location.href = "{{route('article.index')}}"
                        }
                    })
                }
            }



            {{--function deletePermission(id)--}}
            {{--{--}}
            {{--    if(confirm("Are you sure you want to delete?")){--}}
            {{--        $.ajax({--}}
            {{--            url : '{{ route("roles.permission.destroy", ":id") }}'.replace(":id", id),--}}
            {{--            type : 'GET',--}}
            {{--            dataType: 'json',--}}
            {{--            headers:{--}}
            {{--                'x-csrf-token': "{{ csrf_token() }}"--}}
            {{--            },--}}
            {{--            success:function (response){--}}
            {{--                window.location.href = "{{route('roles.permission.index')}}"--}}
            {{--            }--}}
            {{--        })--}}
            {{--    }--}}
            {{--}--}}
        </script>
    </x-slot>
</x-app-layout>
