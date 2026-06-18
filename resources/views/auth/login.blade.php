@extends('layouts.app')

@section('title', 'Login - TOEFLin')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-8 pt-8 pb-6 bg-gradient-to-br from-blue-600 to-indigo-700 text-white text-center">
            <h2 class="text-3xl font-bold mb-2">TOEFLin</h2>
            <p class="text-blue-100 opacity-90">Computer Based Test Simulation</p>
        </div>
        
        <div class="p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-lg text-sm border border-red-100">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    Sign In
                </button>
                
                @if(request('role') !== 'admin')
                <p class="text-center text-sm text-slate-600 mt-4">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">Daftar di sini</a>
                </p>
                @else
                <p class="text-center text-sm text-slate-500 mt-4 font-medium">
                    -- Administrator Login --
                </p>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
