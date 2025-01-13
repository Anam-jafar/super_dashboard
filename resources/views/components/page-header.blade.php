<div class="flex items-center justify-between page-header-breadcrumb flex-wrap gap-2">
    <div>
        <ol class="breadcrumb mb-0 text-[1rem]">
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
        <h1 class="page-title font-medium text-[1.25rem] mb-0 ">{{ $title }}</h1>
    </div>
</div>
