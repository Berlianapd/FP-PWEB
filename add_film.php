<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: dashboard.php");
    exit();
}

// Proses submit data film
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_data = [
        'title' => $_POST['title'] ?? '',
        'genre' => $_POST['genre'] ?? '',
        'director' => $_POST['director'] ?? '',
        'cast' => $_POST['cast'] ?? '',
        'time' => $_POST['time'] ?? '',
        'synopsis' => $_POST['synopsis'] ?? '',
    ];

    // Proses upload gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/'; // Direktori untuk menyimpan file
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $filename = basename($_FILES['image']['name']);
        $target_path = $upload_dir . $filename;

        // Pindahkan file yang diunggah ke folder tujuan
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $movie_data['image'] = $target_path; // Simpan path gambar
        } else {
            $movie_data['image'] = ''; // Gagal upload
        }
    } else {
        $movie_data['image'] = ''; // Tidak ada gambar diunggah
    }

    // Simpan data film ke session
    $_SESSION['movie_data'] = $movie_data;

    // Redirect ke detail_film.php
    header("Location: film_detail.php");
    exit();


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Film</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000; /* Latar belakang hitam */
            color: #fff; /* Teks menjadi putih agar kontras */
        }
        .form-container {
            max-width: 700px;
            margin: 50px auto;
            background: #1c1c1c; /* Card form dengan warna abu gelap */
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007BFF; /* Warna teks biru untuk judul */
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
            font-size: 14px;
            color: #ddd; /* Warna teks abu terang */
        }
        input, textarea, button {
            padding: 12px;
            border: 1px solid #444; /* Border dengan warna abu gelap */
            border-radius: 4px;
            font-size: 16px;
            background-color: #333; /* Background input */
            color: #fff; /* Warna teks input */
        }
        input:focus, textarea:focus {
            border-color: #007BFF; /* Warna biru saat fokus */
            outline: none;
        }
        textarea {
            resize: none;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .note {
            font-size: 12px;
            color: #bbb; /* Warna teks catatan abu terang */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Film</h2>
        <form id="movieForm" method="POST" action="add_film.php" enctype="multipart/form-data">
            <label for="title">Film Title</label>
            <input type="text" id="title" name="title" placeholder="Enter film title" required>

            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre" placeholder="Enter film genre" required>

            <label for="director">Director</label>
            <input type="text" id="director" name="director" placeholder="Enter director's name" required>

            <label for="cast">Cast</label>
            <input type="text" id="cast" name="cast" placeholder="Enter main cast" required>

            <label for="time">Duration</label>
            <input type="text" id="time" name="time" placeholder="e.g., 120 minutes" required>

            <label for="synopsis">Synopsis</label>
            <textarea id="synopsis" name="synopsis" rows="4" placeholder="Enter film synopsis" required></textarea>

            <label for="image">Upload Poster</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <span class="note">* Supported formats: JPG, PNG. Maximum size: 2MB.</span>

            <button type="submit">Submit Film</button>
        </form>
    </div>
</body>
</html>
