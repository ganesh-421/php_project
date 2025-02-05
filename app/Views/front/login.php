<?php require_once __DIR__ . '/header.php'; ?>

        <h2 class="text-2xl font-semibold text-center text-gray-700">Admin Login</h2>
        
        <form class="mt-6" action="/login" method="POST">
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input name="email" type="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your email">
            </div>
            
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input name="password" type="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter your password">
            </div>
            
            <div class="mt-6">
                <button class="w-full px-4 py-2 font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700">Login</button>
            </div>
        </form>
        
        <p class="mt-4 text-center text-sm text-gray-600">
            Don't have an account? 
            <a href="/register" class="text-blue-600 hover:underline">Register here</a>
        </p>

    <?php require_once  __DIR__ . '/footer.php'; ?>