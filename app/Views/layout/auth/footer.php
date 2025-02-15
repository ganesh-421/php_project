</main>
</div>
<script>
        document.getElementById('user-menu-btn').addEventListener('click', function() {
            let menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
            menu.classList.toggle('opacity-100');
        });

        function showDeleteModal(elementId, id) {
            document.getElementById('delete-modal').classList.remove('hidden');
            document.getElementById(elementId).value = id;
        }
        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }
        
        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }

        function showCsvModal() {
            document.getElementById('csv-modal').classList.remove('hidden');
        }

        function closeCsvModal(event) {
            document.getElementById('csv-modal').classList.add('hidden');
        }

        document.querySelectorAll(".dropdown-btn").forEach(button => {
            button.addEventListener("click", () => {
                const menu = button.nextElementSibling;
                menu.classList.toggle("hidden");
                menu.classList.toggle("scale-y-100");
                button.querySelector(".ph-caret-down").classList.toggle("rotate-180");
            });
        });

        document.querySelector("form").addEventListener("submit", function() {
            document.querySelector("button[type=submit]").disabled = true;
        });

        document.querySelector("#sidebar-toggle-btn").addEventListener('click', function() {
            document.querySelector("#sidebar").classList.toggle('-translate-x-full');
        });

    </script>
</body>
</html>