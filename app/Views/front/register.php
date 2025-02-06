<?php require_once __DIR__ . '/../layout/guest/header.php'; ?>
    <h2 class="text-2xl font-semibold text-center text-gray-700">Admin Register</h2>

    <form class="mt-6" action="/register" method="POST">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- First Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" name="first_name" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your first name" required>
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" name="last_name" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your last name" required>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your email" required>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your password" required>
            </div>

            <!-- Phone -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your phone number" required>
            </div>

            <!-- Date of Birth -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" name="dob" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" required>
            </div>

            <!-- Gender -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" required>
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                    <option value="o">Other</option>
                </select>
            </div>

            <!-- Address -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your address" required>
            </div>

            <!-- Role -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" required>
                    <option value="super_admin">Super Admin</option>
                    <option value="artist_manager">Artist Manager</option>
                    <option value="artist">Artist</option>
                </select>
            </div>

        </div>

        <div class="mt-6">
            <button type="submit" class="w-full px-4 py-2 font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700">Register</button>
        </div>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        Already have an account? 
        <a href="/login" class="text-blue-600 hover:underline">Login here</a>
    </p>

<?php require_once  __DIR__ . '/../layout/guest/footer.php'; ?>
