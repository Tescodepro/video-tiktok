<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikTok Clone - Latest Videos</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .video-container {
            height: calc(100vh - 64px);
            /* Adjust for nav bar height */
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
        }

        .video-card {
            scroll-snap-align: start;
            height: calc(100vh - 64px);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .video-player {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        .video-info {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            padding: 10px;
        }

        .sidebar {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sidebar button,
        .sidebar a {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .comments-section {
            max-height: 200px;
            overflow-y: auto;
        }

        .nav-bar {
            background: rgba(0, 0, 0, 0.9);
            height: 64px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 10;
        }
    </style>
</head>

<body class="bg-black font-sans">
    <div class="nav-bar">
        @include('layouts.navigation')
    </div>
    <div class="video-container mt-16">
        @if ($videos->isEmpty())
            <div class="no-videos-message">
                <div class="no-videos-icon">
                    <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="gray" stroke-dasharray="4 2" fill="#222" />
                        <path d="M8 12h8M12 8v8" stroke="gray" stroke-linecap="round"/>
                    </svg>
                </div>
                <p class="no-videos-title">No videos available</p>
                <p class="no-videos-desc">Check back later or upload the first video!</p>
            </div>
            <style>
                .no-videos-message {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    min-height: 60vh;
                    color: #fff;
                    background: linear-gradient(135deg, #232526 0%, #414345 100%);
                    border-radius: 16px;
                    margin: 40px auto;
                    max-width: 420px;
                    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
                    padding: 48px 32px;
                    border: 1px solid rgba(255,255,255,0.08);
                }
                .no-videos-icon {
                    margin-bottom: 18px;
                    opacity: 0.7;
                }
                .no-videos-title {
                    font-size: 1.5rem;
                    font-weight: 700;
                    margin-bottom: 8px;
                    letter-spacing: 0.02em;
                }
                .no-videos-desc {
                    font-size: 1rem;
                    color: #b0b0b0;
                    text-align: center;
                }
            </style>
        @else
            @foreach ($videos as $video)
                <div class="video-card">
                    <video class="video-player" preload="metadata" poster="{{ asset($video->thumbnail_path) }}#t=1" loop>
                        <source src="{{ asset($video->video_path) }}#t=1" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                    <!-- Video Info -->
                    <div class="video-info text-white">
                        <h2 class="text-lg font-semibold truncate">{{ $video->title }}</h2>
                        <p class="text-sm opacity-80 line-clamp-2">{{ $video->description }}</p>
                        <p class="text-xs opacity-70 mt-1">
                            Publisher: <a class="text-blue-400 hover:underline">
                                {{ $video->user->name }}
                            </a>
                        </p>
                        <p class="text-xs opacity-70">
                            Uploaded: {{ $video->created_at->diffForHumans() }}
                        </p>
                        <p>
                            <span class="text-xs opacity-70">Genre: {{ $video->genre ?? 'N/A' }}</span>
                            <span class="text-xs opacity-70"> | Age Range: {{ $video->age_range ?? 'N/A' }}</span>
                        </p>
                    </div>

                    <!-- Sidebar Actions -->
                    <div class="sidebar">
                        <!-- Like Button -->
                        <form action="{{ route('videos.like', $video) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex flex-col items-center text-sm font-medium {{ $video->likes->contains('user_id', auth()->id()) ? 'text-red-600' : 'text-white' }} hover:text-red-600 transition">
                                <svg class="w-8 h-8"
                                    fill="{{ $video->likes->contains('user_id', auth()->id()) ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span>{{ $video->likes->count() }}</span>
                            </button>
                        </form>

                        <!-- Comments Toggle -->
                        <button onclick="toggleComments('comments-{{ $video->id }}')" class="text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5v-4a2 2 0 012-2h10a2 2 0 012 2v4h-4m-6 0h6" />
                            </svg>
                        </button>
                    </div>

                    <!-- Comments Section -->
                    <div id="comments-{{ $video->id }}"
                        class="hidden absolute bottom-20 left-20 right-20 bg-black bg-opacity-80 text-white p-4 rounded-lg comments-section">
                        <h3 class="text-sm font-semibold">Comments</h3>
                        <div class="mt-2 text-sm space-y-2">
                            @if ($video->comments->isEmpty())
                                <p class="text-gray-400">No comments yet.</p>
                            @else
                                @foreach ($video->comments as $comment)
                                    <p><strong class="text-gray-200">{{ $comment->user->username }}:</strong>
                                        {{ $comment->content }}</p>
                                @endforeach
                            @endif
                        </div>
                        @auth
                            <form action="{{ route('videos.comment', $video) }}" method="POST" class="mt-3">
                                @csrf
                                <textarea name="content" rows="2"
                                    class="w-full text-sm bg-gray-800 text-white border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Write a comment..." required></textarea>
                                <button type="submit"
                                    class="mt-2 bg-blue-500 text-white px-4 py-1 rounded-lg text-sm">Comment</button>
                            </form>
                        @else
                            <p class="text-sm text-gray-400 mt-2">
                                <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Log in</a> to comment.
                            </p>
                        @endauth
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const videos = document.querySelectorAll('.video-player');

            // Require user interaction first
            function enableAutoplayAfterInteraction() {
                window.removeEventListener('click', enableAutoplayAfterInteraction);
                window.removeEventListener('scroll', enableAutoplayAfterInteraction);

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        const video = entry.target;
                        if (entry.isIntersecting) {
                            document.querySelectorAll('.video-player').forEach(v => {
                                if (v !== video) v.pause();
                            });
                            video.play().catch(err => {
                                console.warn('Play failed:', err);
                            });
                        } else {
                            video.pause();
                            // Optional: video.currentTime = 0;
                        }
                    });
                }, {
                    threshold: 0.7
                });

                videos.forEach(video => observer.observe(video));
            }

            // Wait for first user interaction
            window.addEventListener('click', enableAutoplayAfterInteraction);
            window.addEventListener('scroll', enableAutoplayAfterInteraction);
        });
    </script>

</body>

</html>
