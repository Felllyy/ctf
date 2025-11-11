<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .checksum {
            word-break: break-all;
            font-family: monospace;
            font-size: 0.8rem;
        }
    </style>
</head>
<body class="bg-gray-900 text-white flex flex-col items-center min-h-screen p-4">

    <div class="w-full max-w-5xl mx-auto">
        <header class="text-center mb-8">
            <h1 class="text-4xl font-bold text-cyan-400">Image Uploader</h1>
            <p class="text-gray-400 mt-2">Upload your favorite images.</p>
        </header>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-semibold mb-4 border-b border-gray-700 pb-2">Upload a New Image</h2>
            <form action="upload.php" method="post" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-4">
                <input type="file" name="imageFile" id="imageFile" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cyan-500 file:text-white hover:file:bg-cyan-600" required>
                <button type="submit" name="submit" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300">Upload</button>
            </form>
            <?php if (isset($_GET['message'])): ?>
                <p class="mt-4 text-center text-lg <?php echo str_contains($_GET['message'], 'Success') ? 'text-green-400' : 'text-red-400'; ?>">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-4">Image List</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs text-gray-300 uppercase bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3">Image Preview</th>
                            <th scope="col" class="px-6 py-3">Filename</th>
                            <th scope="col" class="px-6 py-3">Checksum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $uploadDir = 'uploads/';
                            $files = is_dir($uploadDir) ? scandir($uploadDir) : [];
                            $imageFound = false;

                            foreach ($files as $file) {
                                if ($file !== '.' && $file !== '..') {
                                    $filePath = $uploadDir . $file;
                                    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                    
                                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        $imageFound = true;
                                        $checksumPath = $filePath . '.txt';
                                        $checksum = 'Not available';
                                        if (file_exists($checksumPath)) {
                                            $checksum = htmlspecialchars(file_get_contents($checksumPath));
                                        }

                                        echo '<tr class="bg-gray-800 border-b border-gray-700">';
                                        echo '<td class="p-4"><img src="' . htmlspecialchars($filePath) . '" class="w-24 h-24 object-cover rounded-md"></td>';
                                        echo '<td class="px-6 py-4 font-medium text-white">' . htmlspecialchars($file) . '</td>';
                                        echo '<td class="px-6 py-4 checksum">' . $checksum . '</td>';
                                        echo '</tr>';
                                    }
                                }
                            }
                            if (!$imageFound) {
                                echo "<tr><td colspan='3' class='text-center text-gray-500 py-8'>No images have been uploaded yet.</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
