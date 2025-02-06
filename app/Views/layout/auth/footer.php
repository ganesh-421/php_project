</main>
</div>
<script>
        document.getElementById('user-menu-btn').addEventListener('click', function() {
            let menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
            menu.classList.toggle('opacity-100');
        });

        function showDeleteModal(artist_id) {
            document.getElementById('delete-modal').classList.remove('hidden');
            document.getElementById('artist_id').value = artist_id;
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

        document.querySelector("form").addEventListener("submit", function() {
            document.querySelector("button[type=submit]").disabled = true;
        });

    </script>
</body>
</html>