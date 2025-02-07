<?php require_once __DIR__ . '/../../layout/auth/header.php'; ?>
    <!-- Main Content -->
    <div class="bg-white p-4 shadow rounded-lg">
        <form class="space-y-4 p-4 border rounded-lg max-w-lg mx-auto" action="/update/user" method="POST">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- First Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" value="<?= $user['first_name'] ?>" name="first_name" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your first name" required>
                </div>

                <!-- Last Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" value="<?= $user['last_name'] ?>" name="last_name" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your last name" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" value="<?= $user['email'] ?>" name="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your email" required>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your password" required>
                </div>

                <!-- Phone -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" value="<?= $user['phone'] ?>" name="phone" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your phone number" required>
                </div>

                <!-- Date of Birth -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" value="<?=  date('Y-m-d', strtotime($user['dob'])) ?>" name="dob" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" required>
                </div>

                <!-- Gender -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" required>
                        <option value="m" <?= ($user['gender'] === 'm') ?"selected": "" ?>>Male</option>
                        <option value="f" <?= ($user['gender'] === 'f') ?"selected": "" ?>>Female</option>
                        <option value="o" <?= ($user['gender'] === 'o') ?"selected": "" ?>>Other</option>
                    </select>
                </div>

                <!-- Address -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" value="<?= $user['address'] ?>" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your address" required>
                </div>

                <!-- Role -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" required>
                        <option value="super_admin" <?= ($user['role'] === 'super_admin') ?"selected": "" ?>>Super Admin</option>
                        <option value="artist_manager" <?= ($user['role'] === 'artist_manager') ?"selected": "" ?>>Artist Manager</option>
                        <option value="artist" <?= ($user['role'] === 'artist') ?"selected": "" ?>>Artist</option>
                    </select>
                </div>

            </div>

            <div class="mt-6">
                <button type="submit" class="w-full px-4 py-2 font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700">Register</button>
            </div>
        </form>
    </div>
<?php require_once __DIR__ . '/../../layout/auth/footer.php'; ?>