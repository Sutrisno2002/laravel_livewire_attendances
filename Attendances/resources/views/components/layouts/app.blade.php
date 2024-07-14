<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Laravel 10 Livewire ' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            padding-top: 56px; /* Adjust based on the height of your navbar */
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #f8f9fa;
            padding: 1rem;
        }
        .content {
            margin-left: 250px; /* Adjust based on the width of your sidebar */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ URL('/dashboard') }}" wire:navigate>Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('login')) ? 'active' : '' }}" href="/login" wire:navigate>Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('register')) ? 'active' : '' }}" href="/register" wire:navigate>Register</a>
                        </li>
                    @else    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <livewire:logout />
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <div class="sidebar">
            <h4>Dashboard</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                
                @if(Auth::check() && Auth::user()->position_id == '2') {{-- Sesuaikan posisi manager --}}
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('karyawan')) ? 'active' : '' }}" href="{{ route('karyawan') }}">Karyawan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('attendance')) ? 'active' : '' }}" href="{{ route('attendance') }}">Absensi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('attendance-report')) ? 'active' : '' }}" href="{{ route('attendance-report') }}">attendance-report</a>
                    </li>
                    {{-- Add more manager-specific menu items here --}}
                @elseif(Auth::check() && Auth::user()->position_id == '1')
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('absensi')) ? 'active' : '' }}" href="{{ route('attendance') }}">Absensi</a>
                </li>
                @endif
            </ul>
        </div>

        <div class="content p-4">
            @if (session()->has('message'))
                <div class="row justify-content-center text-center mt-3">
                    <div class="col-md-8">
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    </div>
                </div>
            @endif

            {{ $slot }}

            <div class="row justify-content-center text-center mt-3">
                <div class="col-md-12">
                    {{-- Additional footer or other content --}}
                </div>
            </div>
        </div>
    </div>

    <script data-navigate-once src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
