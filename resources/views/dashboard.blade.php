<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
        <style>
            .dashboard-center {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 300px;
            gap: 2rem;
            margin-top: 2rem;
            }
            .dashboard-card {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 2rem;
            width: 100%;
            max-width: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
            }
            .dashboard-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #1a202c;
            margin-top: 20px;
            }
            .dashboard-text {
            margin-bottom: 1.5rem;
            color: #1a202c;
            text-align: center;
            }
            .dashboard-link {
            background: #2563eb;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(37,99,235,0.15);
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
            transition: background 0.2s;
            width: 100%;
            }
            .dashboard-link:hover {
            background: #1d4ed8;
            }
            .dashboard-link svg {
            width: 20px;
            height: 20px;
            }
        </style>
        <div class="dashboard-center">
            @auth
            <div class="dashboard-card">
            <h3 class="dashboard-title">Upload Video</h3>
            <p class="dashboard-text">Share your moments with others by uploading a new video.</p>
            <a href="{{ route('videos.store') }}" class="dashboard-link">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v6m0 0l-3-3m3 3l3-3M12 6v6" />
                </svg>
                Upload Video
            </a>
            </div>
            <div class="dashboard-card">
            <h3 class="dashboard-title">Stream Video</h3>
            <p class="dashboard-text">Watch and enjoy videos from the community.</p>
            <a href="{{ route('home') }}" class="dashboard-link">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M4 6v12a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2z" />
                </svg>
                Stream Video
            </a>
            </div>
            @endauth
        </div>
    </div>


</x-app-layout>
