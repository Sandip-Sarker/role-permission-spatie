@if(session('success'))
    <div class="border-gray-200 border-green-500 p-4 mb-3 rounded-sm shadow-sm" >
        {{ session()->get('success') }}
    </div>
@endif

@if(session('error'))
    <div class="border-red-200 border-red-600 p-4 mb-3 rounded-sm shadow-sm" >
        {{ session()->get('error') }}
    </div>
@endif
