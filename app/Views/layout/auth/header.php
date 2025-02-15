<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music And Artists CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<?php $role = (new App\Models\Session())->role(); ?>
<body class="bg-gray-100">
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center fixed top-0 w-full z-50">
        <div class="flex gap-5 items-center">
            <span class="text-xl font-bold">
                <?= $role ?>
            </span>
            <button id="sidebar-toggle-btn" class=" hover:scale-110 transition-transform duration-200 ease-in-out md:hidden ">
                <i class="ph ph-list font-bold font-lg text-xl"></i>
            </button>
        </div>
        <div class="relative">
            <button id="user-menu-btn" class="flex items-center space-x-2 focus:outline-none">
                <img src="https://i.pravatar.cc/40" class="w-8 h-8 rounded-full">
                <span class="text-gray-700"><?php echo (new App\Models\Session())->name() ?></span>
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
        <aside class="w-64 bg-gray-900 text-white min-h-screen p-4 fixed md:relative md:block transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50" id="sidebar">
            <nav>
                <ul>
                    
                    <li>
                        <a href="/dashboard" class="block p-2 hover:bg-gray-700 <?= str_contains($_SERVER['REQUEST_URI'], '/dashboard') ? "bg-gray-700" : ""  ?>">
                        <i class="ph ph-package text-lg mr-2"></i>Dashboard
                        </a>
                    </li>
                    <?php if($role === 'super_admin') { ?>
                        <li class="mb-2">
                            <button class="w-full text-left p-2 hover:bg-gray-700 flex items-center dropdown-btn">
                                <i class="ph ph-users text-lg mr-2"></i> Users
                                <i class="ph ph-caret-down ml-auto transition-transform rotate-180"></i>
                            </button>
                            <ul class="space-y-1 pl-4 dropdown-menu transition-all duration-300 ease-in-out origin-top scale-y-100">
                                <li><a href="/users" class="block p-2 hover:bg-gray-700 <?= str_contains($_SERVER['REQUEST_URI'], '/users') ? "bg-gray-700" : ""  ?>">User List</a></li>
                                <li><a href="/create/user" class="block p-2 hover:bg-gray-700 <?= str_contains($_SERVER['REQUEST_URI'], '/create/user') ? "bg-gray-700" : ""  ?>">Add User</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if(($role === 'super_admin') || ($role === 'artist_manager')) { ?>
                        <li class="mb-2">
                            <button class="w-full text-left p-2 hover:bg-gray-700 flex items-center dropdown-btn">
                                <i class="ph ph-microphone text-lg mr-2"></i> Artists
                                <i class="ph ph-caret-down ml-auto transition-transform rotate-180"></i>
                            </button>
                            <ul class="space-y-1 pl-4 dropdown-menu transition-all duration-300 ease-in-out origin-top scale-y-100">
                                <li><a href="/artists" class="block p-2 hover:bg-gray-700 <?= str_contains($_SERVER['REQUEST_URI'], '/artists') ? "bg-gray-700" : ""  ?>">Artist List</a></li>
                                <?php if(($role === 'artist_manager')) { ?>
                                    <li><a href="/create/artist" class="block p-2 hover:bg-gray-700 <?= str_contains($_SERVER['REQUEST_URI'], '/create/artist') ? "bg-gray-700" : ""  ?>">Add Artist</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="mb-2">
                        <button class="w-full text-left p-2 hover:bg-gray-700 flex items-center dropdown-btn">
                            <i class="ph ph-music-notes text-lg mr-2"></i> Music
                            <i class="ph ph-caret-down ml-auto transition-transform rotate-180"></i>
                        </button>
                        <ul class="space-y-1 pl-4 dropdown-menu transition-all duration-300 ease-in-out origin-top scale-y-100">
                            <li><a href="/musics" class="block p-2 hover:bg-gray-700 <?= str_contains($_SERVER['REQUEST_URI'], '/musics') ? "bg-gray-700" : ""  ?>">Music List</a></li>
                            <?php if(($role === 'artist')) { ?>
                                <li><a href="/create/music" class="block p-2 hover:bg-gray-700 <?= str_contains($_SERVER['REQUEST_URI'], '/create/music') ? "bg-gray-700" : ""  ?>">Add Music</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>
        <main class="flex-1 p-6">
            <div class="w-96 absolute bottom-0 right-2">
                <?php if($_SESSION['error']) { ?>
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                        <span class="font-medium">Error!</span> <?php echo $_SESSION['error']; ?>
                    </div>
                <?php } unset($_SESSION['error']) ?>
        
                <?php if($_SESSION['success']) { ?>
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        <span class="font-medium">Success!</span> <?php echo $_SESSION['success']; ?>
                    </div>
                <?php } unset($_SESSION['success'])?>
            </div>

            