<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800  leading-tight">
                Article / Edit
            </h2>

            <a href="{{url()->previous()}}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('article.update', $article->id)}}" method="POST">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Title</label>
                            <div class="my-3">
                                <input type="text"  name="title"  value="{{old('title', $article->title)}}" placeholder="Enter Title" class="border-gray-300 shadow-sm w-1/2 rounded-lg" >
                            </div>
                            @error('title')
                            <p class="text-red-500 font-medium"> {{$message}}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="" class="text-lg font-medium">Content</label>
                            <div class="my-3">
                                <textarea type="text"  name="content" placeholder="Enter some content..." class="border-gray-300 shadow-sm w-1/2 rounded-lg" >
                                    {{ $article->description }}
                                </textarea>
                            </div>

                        </div>

                        <div>
                            <label for="" class="text-lg font-medium">Author</label>
                            <div class="my-3">
                                <input type="text"  name="author"  value="{{old('author', $article->author)}}" placeholder="Enter author" class="border-gray-300 shadow-sm w-1/2 rounded-lg" >
                            </div>
                            @error('author')
                            <p class="text-red-500 font-medium"> {{$message}}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script"></x-slot>
</x-app-layout>
