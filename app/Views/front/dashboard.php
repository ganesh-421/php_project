<?php require_once __DIR__ . '/../layout/auth/header.php'; ?>
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

    <script>
        document.getElementById('user-menu-btn').addEventListener('click', function() {
            let menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
            menu.classList.toggle('opacity-100');
        });

        function showDeleteModal() {
            document.getElementById('delete-modal').classList.remove('hidden');
        }
        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }

        document.querySelectorAll(".dropdown-btn").forEach(button => {
            button.addEventListener("click", () => {
                const menu = button.nextElementSibling;
                menu.classList.toggle("hidden");
                menu.classList.toggle("scale-y-100");
                button.querySelector(".ph-caret-down").classList.toggle("rotate-180");
            });
        });
    </script>
</body>
</html>

<?php require_once __DIR__ . '/../layout/auth/footer.php'; ?>