@props([
    'title' => '',
    'button' => 'تعديل',
    'buttonCloseModal' => true,
])

<div x-data="modalHandler()">

    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[5000] flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
        <!-- Modal -->
        <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 transform translate-y-1/2" @click.away="closeModal"
            @keydown.escape="closeModal"
            class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
            role="dialog" id="modal">
            <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
            <header class="flex justify-start">
                <button type="button"
                    class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700"
                    aria-label="close" @click="closeModal">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                        <path
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </header>
            <!-- Modal body -->
            <div class="mt-2 mb-6">
                <!-- Modal title -->
                <p class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">
                    {{ $title }}
                </p>
                <!-- Modal description -->
                {{ $slot }}
            </div>
            <footer
                class="flex flex-col items-center justify-center px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:flex-row bg-gray-50 dark:bg-gray-800">
                @if (isset($button))
                    <button
                        class="w-full me-1 px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        {{ $button }}
                    </button>
                @endif

                @if (isset($buttonCloseModal))
                    <button @click="closeModal" type="button"
                        class="w-full ms-1 px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                        إلغاء
                    </button>
                @endif
            </footer>
        </div>
    </div>
</div>

<script>
    function modalHandler() {
        return {
            isModalOpen: {{ $errors->has('name') || $errors->has('current_password') || $errors->has('phone') || $errors->has('new_password') ? true : false }},
            modalId: '',
            modalValue: '',
            openModal(event) {
                this.modalId = event.target.id;
                this.modalValue = event.target.value;
                this.isModalOpen = true;
            },
            closeModal() {
                this.isModalOpen = false;
            }
        }
    }
</script>
