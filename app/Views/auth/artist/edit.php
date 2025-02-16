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
                <a href="/artists">Artists</a>
                <span class="pointer-events-none mx-2 text-slate-800">
                    /
                </span>
            </li>
            <li class="flex cursor-pointer items-center text-sm text-slate-500 transition-colors duration-300 hover:text-slate-800">
                <a href="/edit/artist">Edit</a>
                <span class="pointer-events-none mx-2 text-slate-800">
                    /
                </span>
            </li>
        </ol>
    </nav>
    <div class="bg-white p-4 shadow rounded-lg">
        <form action="/update/artist" method="POST" class="space-y-4 p-4 border rounded-lg max-w-lg mx-auto">
            <input type="hidden" name="artist_id" value="<?= $artist['id'] ?>" />
            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" value="<?= $artist['name'] ?>" name="name" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium">Date of Birth</label>
                <input type="date" name="dob" value="<?=  date('Y-m-d', strtotime($artist['dob'])) ?>" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium">Gender</label>
                <select name="gender" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                    <option value="m" <?= ($artist['gender'] === 'm') ?"selected": "" ?>>Male</option>
                    <option value="f" <?= ($artist['gender'] === 'f') ?"selected": "" ?>>Female</option>
                    <option value="o" <?= ($artist['gender'] === 'o') ?"selected": "" ?>>Other</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Address</label>
                <textarea name="address" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400"><?= $artist['address'] ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">First Release Year</label>
                <input type="number" value="<?= $artist['first_release_year'] ?>" name="first_release_year" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium">No. of Albums Released</label>
                <input type="number" value="<?= $artist['no_of_albums_released'] ?>" name="no_of_albums_released" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>

<?php require_once __DIR__ . '/../../layout/auth/footer.php'; ?>