<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             @if(Auth::check() && Auth::user()->role === 'admin')
            {{ __('Admin Dashboard') }}
            @else
            {{ __('User Dashboard') }}
            @endif
        </h2>
    </x-slot>
@section('content')
    
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="">
                        <input type="text" name="title" placeholder="Title">
                        <input type="text" name="title" placeholder="Title">
                        <input type="text" name="title" placeholder="Title">
                        <input type="text" name="title" placeholder="Title">
                        <input type="text" name="title" placeholder="Title">
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
