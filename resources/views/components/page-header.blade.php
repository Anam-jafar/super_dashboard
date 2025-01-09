<div class="flex items-center justify-between page-header-breadcrumb flex-wrap gap-2">
    <div>
        <ol class="breadcrumb mb-0">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}"
                    @if ($loop->last) aria-current="page" @endif>
                    @if (!$loop->last)
                        <a href="{{ $breadcrumb['url'] ?? 'javascript:void(0);' }}">
                            {{ $breadcrumb['label'] }}
                        </a>
                    @else
                        {{ $breadcrumb['label'] }}
                    @endif
                </li>
            @endforeach
        </ol>
        <h1 class="page-title font-medium text-lg mb-0">{{ $title }}</h1>
    </div>
</div>
