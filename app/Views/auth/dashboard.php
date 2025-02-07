<?php require_once __DIR__ . '/../layout/auth/header.php'; ?>
    <nav aria-label="breadcrumb" class="w-full mb-3">
        <ol class="flex w-full flex-wrap items-center rounded-md bg-slate-50 px-4 py-2">
            <li class="flex cursor-pointer items-center text-sm text-slate-500 transition-colors duration-300 hover:text-slate-800">
            <a href="/dashboard">Dashboard</a>
            <span class="pointer-events-none mx-2 text-slate-800">
                /
            </span>
            </li>
        </ol>
    </nav>
    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <div class="p-4 bg-blue-500 text-white rounded-lg">
                🎵
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-bold">Total Songs</h2>
                <p class="text-gray-600 text-lg"><?= $music_count ?></p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <div class="p-4 bg-green-500 text-white rounded-lg">
                🎤
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-bold">Total Artists</h2>
                <p class="text-gray-600 text-lg"><?= $artist_count ?></p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <div class="p-4 bg-purple-500 text-white rounded-lg">
                📀
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-bold">Total Users</h2>
                <p class="text-gray-600 text-lg"><?= $user_count ?></p>
            </div>
        </div>
    </div>

    <!-- Recent Songs Table -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Recent Songs</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border">Title</th>
                    <th class="py-2 px-4 border">Artist</th>
                    <th class="py-2 px-4 border">Album</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recent_songs as $key=>$song) { ?>
                    <tr class="border text-center">
                        <td class="py-2 px-4"><?= $song['title'] ?></td>
                        <td class="py-2 px-4"><?= (new \App\Models\Artist())->findBy('id', $song['artist_id'])[0]['name'] ?></td>
                        <td class="py-2 px-4"><?= $song['album_name'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php require_once __DIR__ . '/../layout/auth/footer.php'; ?>