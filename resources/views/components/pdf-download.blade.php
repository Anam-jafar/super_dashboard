@php
  use Illuminate\Support\Facades\Storage;

  $fileExists = false;
  $fileSize = 'N/A';
  $downloadUrl = '#';

  if ($pdfFile) {
      try {
          // Check if file exists in S3
          $fileExists = Storage::disk('s3')->exists($pdfFile);

          if ($fileExists) {
              // Get file size from S3
              $fileSizeBytes = Storage::disk('s3')->size($pdfFile);
              $fileSize = round($fileSizeBytes / 1024, 2) . ' KB';

              // Create download URL
              $downloadUrl = route('download.s3.attachment', ['filepath' => base64_encode($pdfFile)]);
          }
      } catch (\Exception $e) {
          \Log::error('Error checking S3 file: ' . $e->getMessage(), ['file' => $pdfFile]);
          $fileExists = false;
      }
  }
@endphp

<div class="mt-2 rounded-lg bg-gray-50">
  <p class="mb-4 text-gray-800">{{ $title }}</p>

  @if ($fileExists)
    <div class="flex h-12 items-center justify-between rounded-md border border-[#6E829F] bg-[#EBEBEB] p-3">
      <div class="flex items-center space-x-3">
        <div class="flex-shrink-0">
          <img src="{{ asset('subscription/assets/icons/fin_pdf.svg') }}" alt="PDF" class="h-8 w-8" />
        </div>
        <div class="flex flex-col">
          <span class="text-sm text-gray-600">{{ $fileSize }}</span>
        </div>
      </div>
      <a href="{{ $downloadUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-gray-700">
        <img src="{{ asset('subscription/assets/icons/fin_pdf_download.svg') }}" alt="download" class="h-10 w-10" />
      </a>
    </div>
  @else
    <div class="flex h-12 items-center justify-center rounded-md border border-[#6E829F] bg-[#EBEBEB] p-3">
      <span class="text-gray-600">No PDF Available</span>
    </div>
  @endif
</div>
