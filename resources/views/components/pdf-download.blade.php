@php
  // Extract year and filename from the given $pdfFile path
  $year = $pdfFile ? explode('/', $pdfFile)[1] : null;
  $filename = $pdfFile ? basename($pdfFile) : null;

  // Construct remote URL from .env base URL
  $downloadBaseUrl = config('app.pdf_download_base_url'); // or config('files.pdf_download_base_url') if using a custom file
  $downloadUrl = $pdfFile && $year && $filename ? rtrim($downloadBaseUrl, '/') . "/$year/$filename" : '#';

  // File size not available since file is remote, use placeholder or N/A
  $fileSize = $pdfFile ? substr(basename($pdfFile), 0, 7) . '...pdf' : 'N/A';
@endphp

<div class="mt-2 rounded-lg">
  <p class="mb-4 text-gray-900">{{ $title }}</p>

  @if ($pdfFile)
    <div class="flex h-14 items-center justify-between rounded-md border !border-[#6E829F] bg-gray-100 p-3">
      <div class="flex items-center space-x-3">
        <div class="flex-shrink-0">
          <img src="{{ asset('subscription/assets/icons/fin_pdf.svg') }}" alt="PDF" class="h-8 w-8" />
        </div>
        <div class="flex flex-col">
          <span class="text-sm text-gray-800">{{ $fileSize }}</span>
        </div>
      </div>
      <a href="{{ $downloadUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-700 hover:text-gray-900">
        <img src="{{ asset('subscription/assets/icons/fin_pdf_download.svg') }}" alt="download" class="h-10 w-10" />
      </a>
    </div>
  @else
    <div class="flex h-14 items-center justify-center rounded-md border !border-[#6E829F] bg-gray-100 p-3">
      <span class="text-gray-800">No PDF Available</span>
    </div>
  @endif
</div>
