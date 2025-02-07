<?php require_once __DIR__ . '/../../layout/auth/header.php'; ?>
    <!-- Main Content -->
    <main class="flex-1 p-6">
            <div class="bg-white p-4 shadow rounded-lg">
                <div class="flex flex-col md:flex-row justify-between mb-4 space-y-2 md:space-y-0">
                    <input type="text" placeholder="Search..." class="border p-2 rounded-lg w-full md:w-auto">
                    <a href="/create/artist" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Create New</a>
                </div>
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Title</th>
                            <th class="border p-2">Artist</th>
                            <th class="border p-2">Album Name</th>
                            <th class="border p-2">Genre</th>
                            <th class="border p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($musics['data'] as $key=>$music) { ?>
                            <tr>
                                <td class="border p-2"><?= $music['title']  ?></td>
                                <td class="border p-2"><?= (new \App\Models\Artist())->findBy('id', $music['artist_id'])[0]['name']  ?></td>
                                <td class="border p-2"><?= $music['album_name']  ?></td>
                                <td class="border p-2"><?= $music['genre']  ?></td>
                                <td class="border p-2 flex space-x-2">
                                    <a href="/update/music?music_id=<?= $music['id'] ?>" class="text-blue-600 flex items-center"><i class="ph ph-pencil-line mr-1"></i> Edit</a>
                                    <button onclick="showDeleteModal('music_id', <?= $music['id']  ?>)" class="text-red-600 flex items-center"><i class="ph ph-trash mr-1"></i> Delete</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="flex space-x-1 mt-1 items-center justify-end">
                    <small class="text-gray-500 hover:text-gray-600">
                        <?= "Showing from " . $music['from'] . " to " . $music['to'] . " out of " . $music['total'] . " records" ?>
                    </small>

                    <a href="?page=<?= ($page > 1) ? $page - 1 : 1 ?>" 
                    class="<?= ($page == 1) ? "disabled " : '' ?>rounded-md border border-blue-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-blue-600 hover:border-blue-800 focus:text-white focus:bg-blue-600 focus:border-blue-800 active:border-blue-800 active:text-white active:bg-blue-600 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                        Prev
                    </a>

                    <!-- First Page -->
                    <a href="?page=1" class="min-w-9 rounded-md <?= (1 == $page) ? 'bg-blue-600 text-white' : '' ?> py-2 px-3 border border-transparent text-center text-sm transition-all shadow-md hover:shadow-lg focus:bg-blue-500 hover:bg-blue-500 active:bg-blue-500 hover:text-white ml-2">
                        1
                    </a>

                    <?php if ($page > 3): ?>
                        <span class="text-gray-500 px-2">...</span>
                    <?php endif; ?>

                    <?php 
                    $start = max(2, $page - 1);
                    $end = min($music['totalPages'] - 1, $page + 1);

                    for ($i = $start; $i <= $end; $i++): ?>
                        <a href="?page=<?= $i ?>" class="min-w-9 rounded-md <?= ($i == $page) ? 'bg-blue-600 text-white' : '' ?> py-2 px-3 border border-transparent text-center text-sm transition-all shadow-md hover:shadow-lg focus:bg-blue-500 hover:bg-blue-500 active:bg-blue-500 hover:text-white ml-2">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $music['totalPages'] - 2): ?>
                        <span class="text-gray-500 px-2">...</span>
                    <?php endif; ?>

                    <?php if ($music['totalPages'] > 1): ?>
                        <a href="?page=<?= $music['totalPages'] ?>" class="min-w-9 rounded-md <?= ($music['totalPages'] == $page) ? 'bg-blue-600 text-white' : '' ?> py-2 px-3 border border-transparent text-center text-sm transition-all shadow-md hover:shadow-lg focus:bg-blue-500 hover:bg-blue-500 active:bg-blue-500 hover:text-white ml-2">
                            <?= $music['totalPages'] ?>
                        </a>
                    <?php endif; ?>

                    <a href="?page=<?= ($page < $music['totalPages']) ? $page + 1 : $music['totalPages'] ?>" 
                    class="<?= ($page == $music['totalPages']) ? "disabled " : '' ?> min-w-9 rounded-md border border-blue-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-blue-600 hover:border-blue-800 focus:text-white focus:bg-blue-600 focus:border-blue-800 active:border-blue-800 active:text-white active:bg-blue-600 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                        Next
                    </a>
                </div>
            </div>
        </main>
    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center" onclick="closeDeleteModal()">
        <div class="bg-white p-6 rounded-lg shadow-lg transform scale-95 transition-transform" onclick="event.stopPropagation()">
            <p class="text-lg">Are you sure you want to delete this item?</p>
            <div class="flex justify-end space-x-2 mt-4">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
                <form action="/delete/artist" method="POST">
                    <input type="hidden" name="music_id" value="0" id="music_id"/>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Delete</button>
                </form>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/../../layout/auth/footer.php'; ?>