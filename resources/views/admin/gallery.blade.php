<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
    <style>
<style>
    body {
        background-color: #1e1e1e; /* خلفية عامة */
        font-family: Arial, sans-serif;
        color: #f1f1f1;
    }

    .page-content {
        display: flex;
        justify-content: center;
        padding: 50px 20px;
        min-height: 100vh;
    }

    .gallery-container {
        background-color: #2f3136; /* نفس لون الميل */
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.7);
        width: 100%;
        max-width: 1000px;
    }

    .gallery-container h1 {
        margin-bottom: 25px;
        text-align: center;
        color: #f1f1f1;
        font-size: 28px;
    }

    .gallery-form label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #ddd;
        text-align: left;
    }

    .gallery-form input[type="file"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: 1px solid #3e4147; /* نفس البوردر بتاع الميل */
        background: #2f3136;
        color: #f1f1f1;
    }

    .gallery-form input[type="submit"] {
        padding: 12px 25px;
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .gallery-form input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .alert-success {
        margin-bottom: 15px;
        padding: 12px;
        border-radius: 8px;
        background-color: #28a745;
        color: #fff;
        text-align: center;
    }

    /* Grid للصور */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        width: 100%;
    }

    .gallery-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: #2f3136; /* نفس الكارد */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
    }

    .gallery-item img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .gallery-item img:hover {
        transform: scale(1.07);
    }

    .delete-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        background-color: rgba(231, 76, 60, 0.9);
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 13px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .delete-btn:hover {
        background-color: rgba(192, 57, 43, 0.9);
    }
</style>

    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="gallery-container">
            <h1>Gallery</h1>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="gallery-form">
                <form action="{{ url('upload_gallery') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="image">Upload Image</label>
                    <input type="file" name="image" id="image" required>
                    <input type="submit" name="submit" value="Add Image">
                </form>
            </div>

            {{-- عرض الصور --}}
            <div class="gallery-grid">
                @foreach ($gallery as $gallerys)
                    <div class="gallery-item">
                        <img src="{{ asset($gallerys->image) }}" alt="Gallery Image">
                        <form action="{{ url('delete_gallery', $gallerys->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this image?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('admin.footer')
</body>
</html>
