@if (session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 rounded mb-6" role="alert">
    <div class="p-6 text-green-700">
        {{ session('success') }}
    </div>
</div>
@endif

@if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 rounded mb-6" role="alert">
    <div class="p-6 text-gray-900">
        <ul class="list-disc list-inside text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif