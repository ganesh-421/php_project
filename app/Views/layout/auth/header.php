<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-100">
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center fixed top-0 w-full z-50">
        <span class="text-xl font-bold">Admin Panel</span>
        <div class="relative">
            <button id="user-menu-btn" class="flex items-center space-x-2 focus:outline-none">
                <img src="https://i.pravatar.cc/40" class="w-8 h-8 rounded-full">
                <span class="text-gray-700"><?php echo $_SESSION['user_name'] ?></span>
            </button>
            <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg overflow-hidden transition-opacity opacity-0">
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">View Profile</a>
                <form action="/logout" method="POST">

                    <button type="submit" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="flex pt-16 flex-col md:flex-row">
        <aside class="w-64 bg-gray-900 text-white min-h-screen p-4 hidden md:block transition-all duration-300 ease-in-out" id="sidebar">
            <nav>
                <ul>
                    <li class="mb-2">
                        <button class="w-full text-left p-2 hover:bg-gray-700 flex items-center dropdown-btn">
                            <i class="ph ph-users text-lg mr-2"></i> Users
                            <i class="ph ph-caret-down ml-auto transition-transform"></i>
                        </button>
                        <ul class="hidden space-y-1 pl-4 dropdown-menu transition-all duration-300 ease-in-out origin-top scale-y-0">
                            <li><a href="#" class="block p-2 hover:bg-gray-700">User List</a></li>
                            <li><a href="#" class="block p-2 hover:bg-gray-700">Add User</a></li>
                        </ul>
                    </li>
                    <li class="mb-2">
                        <button class="w-full text-left p-2 hover:bg-gray-700 flex items-center dropdown-btn">
                            <i class="ph ph-microphone text-lg mr-2"></i> Artists
                            <i class="ph ph-caret-down ml-auto transition-transform"></i>
                        </button>
                        <ul class="hidden space-y-1 pl-4 dropdown-menu transition-all duration-300 ease-in-out origin-top scale-y-0">
                            <li><a href="#" class="block p-2 hover:bg-gray-700">Artist List</a></li>
                            <li><a href="#" class="block p-2 hover:bg-gray-700">Add Artist</a></li>
                        </ul>
                    </li>
                    <li class="mb-2">
                        <button class="w-full text-left p-2 hover:bg-gray-700 flex items-center dropdown-btn">
                            <i class="ph ph-music-notes text-lg mr-2"></i> Music
                            <i class="ph ph-caret-down ml-auto transition-transform"></i>
                        </button>
                        <ul class="hidden space-y-1 pl-4 dropdown-menu transition-all duration-300 ease-in-out origin-top scale-y-0">
                            <li><a href="#" class="block p-2 hover:bg-gray-700">Music List</a></li>
                            <li><a href="#" class="block p-2 hover:bg-gray-700">Add Music</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="bg-white p-4 shadow rounded-lg">
                <div class="flex flex-col md:flex-row justify-between mb-4 space-y-2 md:space-y-0">
                    <input type="text" placeholder="Search..." class="border p-2 rounded-lg w-full md:w-auto">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Create New</button>
                </div>
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Name</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border p-2">John Doe</td>
                            <td class="border p-2">john@example.com</td>
                            <td class="border p-2 flex space-x-2">
                                <button class="text-blue-600 flex items-center"><i class="ph ph-pencil-line mr-1"></i> Edit</button>
                                <button class="text-green-600 flex items-center"><i class="ph ph-eye mr-1"></i> View</button>
                                <button onclick="showDeleteModal()" class="text-red-600 flex items-center"><i class="ph ph-trash mr-1"></i> Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>