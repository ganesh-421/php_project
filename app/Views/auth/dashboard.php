<?php require_once __DIR__ . '/../layout/auth/header.php'; ?>
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
    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center" onclick="closeDeleteModal()">
        <div class="bg-white p-6 rounded-lg shadow-lg transform scale-95 transition-transform" onclick="event.stopPropagation()">
            <p class="text-lg">Are you sure you want to delete this item?</p>
            <div class="flex justify-end space-x-2 mt-4">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg">Delete</button>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/../layout/auth/footer.php'; ?>