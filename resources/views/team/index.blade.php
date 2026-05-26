<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Workspace') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-end">
                <a href="{{ route('teams.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Buat Workspace Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($teams->isEmpty())
                    <p class="text-gray-500">Lo belum punya workspace. Ayo bikin satu buat mulai project for himatif lo!</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($teams as $team)
                            <li class="py-4 flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">
                                        <a href="{{ route('teams.show', $team->slug) }}" class="hover:text-blue-500">{{ $team->name }}</a>
                                    </h3>
                                    <p class="text-sm text-gray-500">Role: {{ $team->pivot->role ?? 'Owner' }} | Status: {{ $team->status }}</p>
                                </div>
                                <a href="{{ route('teams.show', $team->slug) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-1 px-3 rounded text-sm">
                                    Buka
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>