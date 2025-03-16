@php
    // Define the absolute file path
    $storageFilePath = $pdfFile ? '/var/www/static_files/fin_statement_attachments/' . basename($pdfFile) : '';

    // Check if the file exists
    $fileExists = $storageFilePath && file_exists($storageFilePath);
    $fileSize = $fileExists ? round(filesize($storageFilePath) / 1024, 2) . ' KB' : 'N/A';

    // Generate a URL for download (create a custom route)
    $downloadUrl = $fileExists ? route('download.attachment', ['filename' => basename($pdfFile)]) : '#';
@endphp

<div class="bg-gray-50 rounded-lg">
    <p class="text-gray-800 font-medium mb-4">{{ $title }}</p>

    @if ($fileExists)
        <div class="flex items-center justify-between rounded-lg p-3 border border-[#6E829F] bg-[#EBEBEB]">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <img src="{{ asset('subscription/assets/icons/fin_pdf.svg') }}" alt="PDF" class="w-18 h-18" />
                </div>
                <div class="flex flex-col">
                    <span class="text-sm text-gray-600">{{ $fileSize }}</span>
                </div>
            </div>
            <a href="{{ $downloadUrl }}" class="text-gray-500 hover:text-gray-700">
                <img src="{{ asset('subscription/assets/icons/fin_pdf_download.svg') }}" alt="download"
                    class="w-12 h-12" />
            </a>
        </div>
    @else
        <div class="flex items-center justify-center rounded-lg p-3 border border-[#6E829F] bg-[#EBEBEB] h-20">
            <span class="text-gray-600">No PDF Available</span>
        </div>
    @endif
</div>
