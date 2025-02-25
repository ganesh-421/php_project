<?php require_once __DIR__ . '/../../layout/auth/header.php'; ?>
    <nav aria-label="breadcrumb" class="w-full mb-3">
        <ol class="flex w-full flex-wrap items-center rounded-md bg-slate-50 px-4 py-2">
            <li class="flex cursor-pointer items-center text-sm text-slate-500 transition-colors duration-300 hover:text-slate-800">
                <a href="/dashboard">Dashboard</a>
                <span class="pointer-events-none mx-2 text-slate-800">
                    /
                </span>
            </li>
            <li class="flex cursor-pointer items-center text-sm text-slate-500 transition-colors duration-300 hover:text-slate-800">
                <a href="/musics">Music</a>
                <span class="pointer-events-none mx-2 text-slate-800">
                    /
                </span>
            </li>
            <li class="flex cursor-pointer items-center text-sm text-slate-500 transition-colors duration-300 hover:text-slate-800">
                <a href="/edit/music">Edit</a>
                <span class="pointer-events-none mx-2 text-slate-800">
                    /
                </span>
            </li>
        </ol>
    </nav>
    <div class="bg-white p-4 shadow rounded-lg">
        <form action="/update/music" method="POST" class="space-y-4 p-4 border rounded-lg max-w-lg mx-auto">
            <input type="hidden" name="music_id" value="<?= $_GET['music_id'] ?>">
            <div>
                <label class="block text-sm font-medium">Artist</label>
                <select name="artist_id" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                    <option value="">Select an Artist</option>
                    <?php foreach ($artists as $artist) { ?>
                        <option value="<?= $artist['id'] ?>" <?= ($artist['id'] === $music['artist_id']) ? "selected" : "" ?>><?= htmlspecialchars($artist['name']) ?></option>
                    <?php } ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Title</label>
                <input type="text" name="title" value="<?= $music['title'] ?>" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium">Album Name</label>
                <input type="text" name="album_name" value="<?= $music['album_name'] ?>" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium">Genre</label>
                <select name="genre" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                    <option value="">Select a Genre</option>
                    <?php foreach ($genres as $genre) { ?>
                        <option value="<?= $genre ?>" <?= ($genre === $music['genre']) ? "selected" : "" ?>><?= ucfirst($genre) ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600">
                Update Music
            </button>
        </form>
    </div>

<?php require_once __DIR__ . '/../../layout/auth/footer.php'; ?>