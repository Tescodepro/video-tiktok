<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video - TikTok Clone</title>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #000, #111);
            color: white;
        }
        .upload-container {
            min-height: calc(100vh - 64px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .upload-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 24px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        .form-input {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
        }
        .form-input:focus {
            outline: none;
            border-color: #fe2c55;
            box-shadow: 0 0 0 3px rgba(254, 44, 85, 0.2);
        }
        .upload-button {
            background: #fe2c55;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            padding: 12px 24px;
            transition: background 0.3s ease;
        }
        .upload-button:hover {
            background: #ff4d7d;
        }
        .video-preview {
            max-height: 300px;
            object-fit: contain;
            border-radius: 10px;
            margin-bottom: 16px;
        }
        .nav-bar {
            background: rgba(0, 0, 0, 0.9);
            height: 64px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 10;
        }
        .error-message {
            color: #ff4d7d;
            font-size: 0.875rem;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="nav-bar">
        @include('layouts.navigation')
    </div>
    <div class="upload-container">
        <div class="upload-card mt-16">
            <h1 class="text-2xl font-bold text-center mb-2 mt-5">📤 Upload a New Video</h1>
            <p class="text-center text-gray-300 mb-6">Share your creativity with the world!</p>
            <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <!-- Video File Input -->
                <div class="mb-6">
                    <label for="video" class="block text-sm font-semibold mb-2">Video File <span class="text-red-500">*</span></label>
                    <input type="file" name="video" id="video" accept="video/*" required class="form-input">
                    @error('video')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <video id="videoPreview" class="video-preview hidden w-full mt-4" controls></video>
                </div>

                <!-- Title Input -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold mb-2">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="form-input">
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description Input -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="form-input" placeholder="Say something about your video...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Producer Input -->
                <div class="mb-6">
                    <label for="producer" class="block text-sm font-semibold mb-2">Producer</label>
                    <input type="text" name="producer" id="producer" value="{{ old('producer') }}" class="form-input">
                    @error('producer')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Genre Input -->
                <div class="mb-6">
                    <label for="genre" class="block text-sm font-semibold mb-2">Genre</label>
                    <input type="text" name="genre" id="genre" value="{{ old('genre') }}" class="form-input">
                    @error('genre')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Age Range Input -->
                <div class="mb-6">
                    <label for="age_range" class="block text-sm font-semibold mb-2">Age Range</label>
                    <input type="text" name="age_range" id="age_range" value="{{ old('age_range') }}" class="form-input">
                    @error('age_range')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="text-center">
                    <button type="submit" class="upload-button">🚀 Upload</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Video preview functionality
        document.getElementById('video').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('videoPreview');
            if (file) {
                const url = URL.createObjectURL(file);
                preview.src = url;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
                preview.src = '';
            }
        });
    </script>
</body>
</html>