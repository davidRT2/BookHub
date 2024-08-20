<!-- Modal HTML -->
<div id="delete-modal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="relative p-4 w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-700">
        <button type="button" class="absolute top-3 right-3 text-gray-400 dark:text-gray-300"
            data-modal-hide="delete-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
        <div class="p-4 text-center">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this
                book?</h3>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="delete-cat-id">
                <button type="submit"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Yes, I'm sure
                </button>
                <button type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:ring-4 focus:ring-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white"
                    data-modal-hide="delete-modal">
                    No, cancel
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Menangani klik pada tombol delete
        document.querySelectorAll('#deleteCatButton').forEach(button => {
            button.addEventListener('click', function() {
                const bookId = this.getAttribute('data-id');
                const modal = document.getElementById('delete-modal');
                const form = document.getElementById('delete-form');
                form.action = `/categories/${bookId}`; // Menetapkan URL penghapusan
                document.getElementById('delete-cat-id').value = bookId;
                modal.classList.remove('hidden');
            });
        });

        // Menangani klik untuk menutup modal
        document.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', function() {
                const modal = document.getElementById(this.getAttribute('data-modal-hide'));
                modal.classList.add('hidden');
            });
        });

        // Menangani klik di luar modal untuk menutup modal
        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('delete-modal')) {
                document.getElementById('delete-modal').classList.add('hidden');
            }
        });
    });
</script>
