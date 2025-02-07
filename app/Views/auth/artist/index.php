<?php require_once __DIR__ . '/../../layout/auth/header.php'; ?>
    <!-- Main Content -->
    <main class="flex-1 p-6">
        <div class="bg-white p-4 shadow rounded-lg">
            <div class="flex flex-col md:flex-row justify-between mb-4 space-y-2 md:space-y-0">
                <input type="text" placeholder="Search..." class="border p-2 rounded-lg w-full md:w-auto">
                <?php if(($_SESSION['role'] === 'artist_manager')) { ?>
                    <div class="flex gap-5">
                        <a href="/create/artist" class="bg-gray-600 text-white px-4 py-2 rounded-lg" title="Impoer From CSV File">Import</a>
                        <form action="/export/artist" method="POST">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg" title="Export To CSV">Export</button>
                        </form>
                        <a href="/create/artist" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Create New</a>
                    </div>
                <?php } ?>
            </div>
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Date Of Birth</th>
                        <th class="border p-2">Gender</th>
                        <th class="border p-2">Address</th>
                        <th class="border p-2">First Release Year</th>
                        <th class="border p-2">Number Of Albums</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($artists['data'] as $key=>$artist) { ?>
                        <?php 
                            if($artist['gender'] === 'm')
                                $gender = "Male";
                            else if($artist['gender'] === 'f')
                                $gender = "Female";
                            else 
                                $gender = "Others";
                        ?>
                        <tr>
                            <td class="border p-2"><?= $artist['name']  ?></td>
                            <td class="border p-2"><?= date('Y-m-d', strtotime($artist['dob']))  ?></td>
                            <td class="border p-2"><?= $gender  ?></td>
                            <td class="border p-2"><?= $artist['address']  ?></td>
                            <td class="border p-2"><?= $artist['first_release_year']  ?></td>
                            <td class="border p-2"><?= $artist['no_of_albums_released']  ?></td>
                            <td class="border p-2 flex space-x-2">
                                <a href="/musics?artist_id=<?= $artist['id'] ?>" class="text-green-600 flex items-center"><i class="ph ph-music-notes mr-1"></i> Songs</a>
                                <?php if(($_SESSION['role'] === 'artist_manager')) { ?>
                                    <a href="/update/artist?artist_id=<?= $artist['id'] ?>" class="text-blue-600 flex items-center"><i class="ph ph-pencil-line mr-1"></i> Edit</a>
                                    <button onclick="showDeleteModal('artist_id', <?= $artist['id']  ?>)" class="text-red-600 flex items-center"><i class="ph ph-trash mr-1"></i> Delete</button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="flex space-x-1 mt-1 items-center justify-end">
                <small class="text-gray-500 hover:text-gray-600">
                    <?= "Showing from " . $artists['from'] . " to " . $artists['to'] . " out of " . $artists['total'] . " records" ?>
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
                $end = min($artists['totalPages'] - 1, $page + 1);

                for ($i = $start; $i <= $end; $i++): ?>
                    <a href="?page=<?= $i ?>" class="min-w-9 rounded-md <?= ($i == $page) ? 'bg-blue-600 text-white' : '' ?> py-2 px-3 border border-transparent text-center text-sm transition-all shadow-md hover:shadow-lg focus:bg-blue-500 hover:bg-blue-500 active:bg-blue-500 hover:text-white ml-2">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $artists['totalPages'] - 2): ?>
                    <span class="text-gray-500 px-2">...</span>
                <?php endif; ?>

                <?php if ($artists['totalPages'] > 1): ?>
                    <a href="?page=<?= $artists['totalPages'] ?>" class="min-w-9 rounded-md <?= ($artists['totalPages'] == $page) ? 'bg-blue-600 text-white' : '' ?> py-2 px-3 border border-transparent text-center text-sm transition-all shadow-md hover:shadow-lg focus:bg-blue-500 hover:bg-blue-500 active:bg-blue-500 hover:text-white ml-2">
                        <?= $artists['totalPages'] ?>
                    </a>
                <?php endif; ?>

                <a href="?page=<?= ($page < $artists['totalPages']) ? $page + 1 : $artists['totalPages'] ?>" 
                class="<?= ($page == $artists['totalPages']) ? "disabled " : '' ?> min-w-9 rounded-md border border-blue-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-blue-600 hover:border-blue-800 focus:text-white focus:bg-blue-600 focus:border-blue-800 active:border-blue-800 active:text-white active:bg-blue-600 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
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
                    <input type="hidden" name="artist_id" value="0" id="artist_id"/>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Delete</button>
                </form>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/../../layout/auth/footer.php'; ?>