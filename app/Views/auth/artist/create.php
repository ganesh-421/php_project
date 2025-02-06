<?php require_once __DIR__ . '/../../layout/auth/header.php'; ?>
    <!-- Main Content -->
    <div class="bg-white p-4 shadow rounded-lg">
        <form action="/create/artist" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium">Date of Birth</label>
                <input type="date" name="dob" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium">Gender</label>
                <select name="gender" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                    <option value="o">Other</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Address</label>
                <textarea name="address" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">First Release Year</label>
                <input type="number" name="first_release_year" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium">No. of Albums Released</label>
                <input type="number" name="no_of_albums_released" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>

<?php require_once __DIR__ . '/../../layout/auth/footer.php'; ?>