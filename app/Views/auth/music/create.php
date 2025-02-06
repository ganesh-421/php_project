<?php require_once __DIR__ . '/../../layout/auth/header.php'; ?>
    <!-- Main Content -->
    <div class="bg-white p-4 shadow rounded-lg">
    <form action="/store/music" method="POST" class="space-y-4 p-4 border rounded-lg max-w-lg mx-auto">
    <div>
        <label class="block text-sm font-medium">Artist</label>
        <select name="artist_id" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            <option value="">Select an Artist</option>
            <?php foreach ($artists as $artist) { ?>
                <option value="<?= $artist['id'] ?>"><?= htmlspecialchars($artist['name']) ?></option>
            <?php } ?>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Title</label>
        <input type="text" name="title" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label class="block text-sm font-medium">Album Name</label>
        <input type="text" name="album_name" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label class="block text-sm font-medium">Genre</label>
        <select name="genre" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            <option value="">Select a Genre</option>
            <?php foreach ($genres as $genre) { ?>
                <option value="<?= $genre ?>"><?= ucfirst($genre) ?></option>
            <?php } ?>
        </select>
    </div>

    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600">
        Add Music
    </button>
</form>
    </div>

<?php require_once __DIR__ . '/../../layout/auth/footer.php'; ?>