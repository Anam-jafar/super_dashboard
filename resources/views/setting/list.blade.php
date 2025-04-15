@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Senarai'" :breadcrumbs="[['label' => 'Settings', 'url' => 'javascript:void(0);'], ['label' => 'Settings']]" />
      <x-alert />
      <div class="mb-4 rounded-lg bg-white px-4 py-8 shadow">
        <div class="2xl:justify-start flex w-full flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
          <!-- Filters Form -->
          <form method="GET" action="{{ route('settingsList') }}"
            class="order-2 flex flex-col gap-4 md:flex-row lg:order-1 lg:flex-1">

            <!-- Group Dropdown -->
            <div class="w-full lg:max-w-[14rem]">
              <label for="grp" class="mb-1 block text-sm font-medium text-gray-700">Group</label>
              <select id="grp" name="grp" class="ti-form-select w-full text-ellipsis rounded-sm py-2 pr-1"
                onchange="this.form.submit()">
                <option value="" {{ request('grp') ? '' : 'selected' }}>Semua</option>
                @foreach ($groups as $key => $value)
                  <option value="{{ $key }}" {{ request('grp') == $key ? 'selected' : '' }}>
                    {{ $value }}
                  </option>
                @endforeach
              </select>
            </div>

            @if (count($parentGroup) > 0)
              <!-- Parent Group Dropdown -->
              <div class="w-full lg:max-w-[14rem]">
                <label for="etc" class="mb-1 block text-sm font-medium text-gray-700">Parent Group</label>
                <select id="etc" name="etc" class="ti-form-select w-full text-ellipsis rounded-sm py-2 pr-1"
                  onchange="this.form.submit()">
                  <option value="" {{ request('etc') ? '' : 'selected' }}>Semua</option>
                  @foreach ($parentGroup as $key => $value)
                    <option value="{{ $key }}" {{ request('etc') == $key ? 'selected' : '' }}>
                      {{ $value }}
                    </option>
                  @endforeach
                </select>
              </div>
            @endif

          </form>
          @if ($selectedGroup)
            <!-- New Page Link -->
            <a href="{{ route('settingsCreate', ['group' => $selectedGroup, 'parent' => $selectedParent]) }}"
              class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-lg order-1 flex w-full items-center justify-center lg:order-2 lg:w-auto">
              Daftar Baru
              <i class="fe fe-plus ml-2"></i>
            </a>
          @endif
        </div>

      </div>

      <div class="rounded-lg bg-white px-4 py-8 shadow">
        @if (count($parentGroup) > 0)
          <x-table :headers="[$levelParameter, $levelParentParameter, 'Kod', 'Index', 'Keterangan']" :columns="['prm', 'etc', 'code', 'idx', 'des']" :id="'id'" :rows="$items" route="settingsEdit" />
        @else
          <x-table :headers="[$levelParameter, 'Kod', 'Index', 'Keterangan']" :columns="['prm', 'code', 'idx', 'des']" :id="'id'" :rows="$items" route="settingsEdit" />
        @endif
        <x-pagination :items="$items" label="jumlah rekod" />
      </div>
    </div>
  </div>
@endsection
