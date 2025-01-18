<div id="{{ $id }}"
    class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50 z-[90]"
        onclick="closeModal('{{ $id }}')"></div>
    <div class="modal-container bg-white w-8/12 md:max-w-3xl mx-auto rounded shadow-lg z-[100] overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold text-gray-900">{{ $title }}</p>
                <div class="modal-close cursor-pointer z-50" onclick="closeModal('{{ $id }}')">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                        height="18" viewBox="0 0 18 18">
                        <path
                            d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="space-y-4">
                {!! $content !!}
            </div>

            <div class="mt-4 flex justify-end">
                {!! $footer !!}
                <button class="px-4 py-2 bg-gray-500 text-white rounded-lg ml-2"
                    onclick="closeModal('{{ $id }}')">Close</button>
            </div>
        </div>
    </div>
</div>
