@extends('layout.layout')

@section('content')
    @include('partial.sidebar')

    <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>

    <div id="main-content" class="dark relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
        <main>
            <div
                class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
                <div class="w-full mb-1">
                    <div class="mb-4">
                        <nav class="flex mb-5" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('home') }}"
                                        class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                        <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <a href="#"
                                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">E-commerce</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                            aria-current="page">Products</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Categories</h1>
                    </div>
                    <div
                        class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                        <div class="flex items-center mb-4 sm:mb-0">
                            <div class="flex items-center w-full sm:justify-end">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <a href="#"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg shadow-sm hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700"
                                data-modal-target="create-modal" data-modal-toggle="create-modal">
                                Add Category
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="w-full p-4">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-white uppercase bg-gray-800 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3  text-white">ID</th>
                                <th class="px-6 py-3 text-white" style="min-width: 200px;">Name</th>
                                <th class="px-6 py-3  text-white">Description</th>
                                <th class="px-6 py-3 text-center text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample Data Row -->
                            @foreach ($categories as $category)
                                <tr class="bg-gray-900 border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 text-white">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-white name">{{ $category->name }}</td>
                                    <td class="px-6 py-4 text-white description" style="min-width: 300px;">
                                        {{ $category->description }}
                                    </td>
                                    <td class="p-4 space-x-2 whitespace-nowrap text-white">
                                        <!-- Edit Button -->
                                        <!-- Edit Button -->
                                        <button id="edit-button" data-modal-target="edit-modal"
                                            data-modal-toggle="edit-modal" data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}"
                                            data-description="{{ $category->description }}"
                                            class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                            type="button">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Update
                                        </button>
                                        <!-- Delete Button -->
                                        <button id="deleteCatButton" type="button" data-modal-target="delete-modal"
                                            data-modal-toggle="delete-modal" data-id="{{ $category->id }}"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Delete item
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                            <!-- End of Sample Data Row -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div
                class="bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <!-- Previous Page Link -->
                    <a href="?page={{ $currentPage - 1 }}"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white {{ $currentPage <= 1 ? 'cursor-not-allowed opacity-50' : '' }}"
                        aria-disabled="{{ $currentPage <= 1 ? 'true' : 'false' }}">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <!-- Next Page Link -->
                    <a href="?page={{ $currentPage + 1 }}"
                        class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white {{ $currentPage >= $totalPages ? 'cursor-not-allowed opacity-50' : '' }}"
                        aria-disabled="{{ $currentPage >= $totalPages ? 'true' : 'false' }}">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing
                        <span
                            class="font-semibold text-gray-900 dark:text-white">{{ $start }}-{{ $end }}</span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $totalItems }}</span>
                    </span>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Previous Button -->
                    <a href="?page={{ $currentPage - 1 }}"
                        class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $currentPage <= 1 ? 'cursor-not-allowed opacity-50' : '' }}"
                        aria-disabled="{{ $currentPage <= 1 ? 'true' : 'false' }}">
                        <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenod"></path>
                        </svg>
                        Previous
                    </a>
                    <!-- Next Button -->
                    <a href="?page={{ $currentPage + 1 }}"
                        class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $currentPage >= $totalPages ? 'cursor-not-allowed opacity-50' : '' }}"
                        aria-disabled="{{ $currentPage >= $totalPages ? 'true' : 'false' }}">
                        Next
                        <svg class="w-5 h-5 ml-1 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </main>
    </div>
    @include('admin.category.create')
    @include('admin.category.delete')
    @include('admin.category.edit')
    <!-- Main modal -->
    <script>
        $(document).on('click', '#edit-button', function(e) {

            $("#id").val($(this).attr('data-id'));
            $("#name").val($(this).attr('data-name'));
            $("#description").val($(this).attr('data-description'));

        });
    </script>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('table').forEach(table => {
            const ths = table.querySelectorAll('thead th');
            const lastTh = ths[ths.length - 1];
            lastTh.style.textAlign = 'right';
        });
    </script>
@endpush
