@extends('layouts.base')

@section('styles')
@endsection

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Penghantaran Laporan Kewangan'" :breadcrumbs="[['label' => 'Laporan Kewangan', 'url' => 'javascript:void(0);'], ['label' => 'Penyata Baharu']]" />
      <x-alert />
      <div class="mt-8 sm:p-4">
        <div class="grid max-w-3xl grid-cols-1 gap-x-16 gap-y-2">

          <x-show-key-value :key="'No Rujukan'" :value="$financialStatement->submission_refno" />
          <x-show-key-value :key="'Tarikh Penghantaran'" :value="$financialStatement->SUBMISSION_DATE" />

        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

          <div class="mt-8 grid max-w-3xl grid-cols-1 gap-x-16 gap-y-2">
            <x-show-key-value :key="'Institusi'" :value="$financialStatement->INSTITUTE" />
            <x-show-key-value :key="'Jenis Institusi'" :value="$financialStatement->INSTITUTE_TYPE" />
            <x-show-key-value :key="'Nama Institusi'" :value="$financialStatement->Institute->name" />
            <x-show-key-value :key="'Daerah'" :value="$financialStatement->Institute->District->prm" />
            <x-show-key-value :key="'Mukim'" :value="$financialStatement->Institute->Subdistrict->prm" />
            <x-show-key-value :key="'Bandar'" :value="$financialStatement->Institute->city ? $financialStatement->Institute->City->prm : ''" />
            <x-show-key-value :key="'Nombor Telefon (Rasmi)'" :value="$financialStatement->Institute->hp" />
            <x-show-key-value :key="'Emel (Rasmi)'" :value="$financialStatement->Institute->mel" />
          </div>
          <div class="mt-8 max-w-3xl space-y-2">
            <x-show-key-value :key="'Nama Pengawal / Wakil Institusi'" :value="$financialStatement->created_by['name']" />
            <x-show-key-value :key="'Jawatan'" :value="$financialStatement->created_by['position']" />
            <x-show-key-value :key="'No. H/P'" :value="$financialStatement->created_by['phone']" />
            <div style="display: flex; margin-bottom: 12px; align-items: baseline;">
              <div style="font-weight: 500; width: 250px; text-align: left; color: black;">
                Status Penghantaran </div>
              <div style="font-weight: 500; margin: 0 25px; color: black;">:</div>
              <div style="font-weight: 500; color: black;">
                <x-status-badge :column="'FIN_STATUS'" :value="$financialStatement->FIN_STATUS['val'] ?? ''" :text="$financialStatement->FIN_STATUS['prm'] ?? 'Unknown'" />
              </div>
            </div>
          </div>
        </div>
        <div class="rounded-lg bg-white px-4 py-8 shadow lg:px-6">
          <x-alert />

          @if ($instituteType == 2)
            <div>
              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-input-field level="Bagi Tahun" id="ye" disabled="true" name="" type="text"
                    placeholder="Year" value="{{ $financialStatement->fin_year }}" />

                  <x-input-field level="Kategori Penyata" id="statment" name="fin_category" type="text"
                    disabled="true" placeholder="Pilih" value="{{ $financialStatement->Category->prm }}" />
                </div>
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">
                  <x-input-field level="Peratus Kemajuan Pembinaan Terkini (%)" id="p1"
                    name="latest_contruction_progress" type="text" placeholder="00"
                    value="{{ $financialStatement->latest_contruction_progress }}" disabled="true" />
                </div>
              </div>
              <p class="mt-4 font-medium text-gray-800">Butiran Penyata :</p>
              <div class="grid grid-cols-3 gap-6">

              </div>
              <div class="mt-4 grid grid-cols-2 gap-6">
                <p class="text-gray-700">A. Maklumat Pembinaan</p>
              </div>
              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-input-field level="(i) Kos Pembinaan (Asal, RM)" id="i1" name="ori_contruction_cost"
                    type="money" placeholder="00.00" :rightAlign="true"
                    value="{{ $financialStatement->ori_contruction_cost }}" disabled="true" />

                  <x-input-field level="(ii) Variation Order (Tambah Kurang, RM)" id="i2" name="variation_order"
                    type="money" placeholder="00.00" :rightAlign="true"
                    value="{{ $financialStatement->variation_order }}" disabled="true" />
                </div>
              </div>
              <div class="mt-4 grid grid-cols-2 gap-6">
                <p class="text-gray-700">B. Jumlah Kutipan</p>
              </div>
              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-input-field level="(i) Kutipan Semasa (RM)" id="i3" name="current_collection" type="money"
                    placeholder="00.00" :rightAlign="true" value="{{ $financialStatement->current_collection }}"
                    disabled="true" />
                  <x-input-field level="(ii) Kutipan Terkumpul (RM)" id="i04" name="total_expenses" type="money"
                    placeholder="00.00" :rightAlign="true" value="{{ $financialStatement->total_expenses }}"
                    disabled="true" />
                </div>
              </div>
              <div class="mt-4 grid grid-cols-2 gap-6">
                <p class="text-gray-700">C. Jumlah Perbelanjaan</p>
              </div>
              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-input-field level="(i) Pindahan Kepada PWS (RM)" id="i4" name="transfer_pws" type="money"
                    placeholder="00.00" :rightAlign="true" value="{{ $financialStatement->transfer_pws }}"
                    disabled="true" />
                  <x-input-field level="(ii) Belanja Pembinaan Masjid/Surau (RM)" id="i5"
                    name="contruction_expenses" type="money" placeholder="00.00" :rightAlign="true"
                    value="{{ $financialStatement->contruction_expenses }}" disabled="true" />
                </div>
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-input-field level="(iii) Belanja Pembinaan PWS (RM)" id="i6" name="pws_expenses"
                    type="money" placeholder="00.00" :rightAlign="true" value="{{ $financialStatement->pws_expenses }}"
                    disabled="true" />
                </div>
              </div>
              <div class="mt-4 grid grid-cols-2 gap-6">
                <p class="text-gray-700">D. Jumlah Lebihan</p>
              </div>
              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-input-field level="(i) Lebihan Masjid/Surau (RM)" id="i4" name="inst_surplus"
                    type="money" placeholder="00.00" :rightAlign="true"
                    value="{{ $financialStatement->inst_surplus }}" disabled="true" />
                  <x-input-field level="(ii) Lebihan PWS (RM)" id="i5" name="pws_surplus" type="money"
                    placeholder="00.00" :rightAlign="true" value="{{ $financialStatement->pws_surplus }}"
                    disabled="true" />
                </div>
              </div>

              <p class="mb-2 mt-4 font-medium text-gray-800">Sila Lampirkan Salinan Dokumen Seperti Di
                Bawah :</p>
              <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-pdf-download title="Penyata Kewangan" pdfFile="{{ $financialStatement->attachment1 ?? '' }}" />
                  <x-pdf-download title="Penyata Bank" pdfFile="{{ $financialStatement->attachment2 ?? '' }}" />
                </div>
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">
                  <x-pdf-download title="Certificate Completion & Compliance(CCC)"
                    pdfFile="{{ $financialStatement->attachment3 ?? '' }}" />
                </div>
              </div>
            </div>
          @else
            <div>
              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-input-field level="Bagi Tahun" id="ye" disabled="true" name="" type="text"
                    placeholder="Year" value="{{ $financialStatement->fin_year }}" />

                  <x-input-field level="Kategori Penyata" id="statment" name="fin_category" type="text"
                    disabled="true" placeholder="Pilih" value="{{ $financialStatement->Category->prm }}" />
                </div>
              </div>
              <p class="mt-4 font-medium text-gray-800">Butiran Penyata :</p>
              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-input-field level="(a) Baki Bawa Ke Hadapan 1 Januari (RM)" id="i1"
                    spanText="Baki bawa ke hadapan tahun sebelumnya bank dan tunai" name="balance_forward"
                    type="money" placeholder="00.00" :rightAlign="true" disabled="true"
                    value="{{ $financialStatement->balance_forward }}" />
                  <x-input-field level="(b) Jumlah Kutipan (RM)" id="i2" name="total_collection" type="money"
                    placeholder="00.00" :rightAlign="true" disabled="true" spanText="Jumlah Kutipan Tahun Semasa"
                    value="{{ $financialStatement->total_collection }}" />
                </div>
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-input-field level="(c) Jumlah Perbelanjaan (RM)" id="i3" name="total_expenses"
                    type="money" placeholder="00.00" :rightAlign="true" disabled="true"
                    value="{{ $financialStatement->total_expenses }}" />
                </div>
              </div>

              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-input-field level="(d) Jumlah Pendapatan (RM)" id="i4" name="total_statement"
                    type="money" placeholder="00.00" :rightAlign="true"
                    value="{{ $financialStatement->total_income }}" disabled="true" />
                  <x-input-field level="(e) Jumlah Lebihan/Kurangan Tahun Semasa (RM)" id="i5"
                    name="total_surplus" type="money" placeholder="00.00" :rightAlign="true"
                    value="{{ $financialStatement->total_surplus }}" disabled="true" />
                </div>
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">
                  <x-input-field level="(f) Maklumat Baki Bank Dan Tunai (RM)" id="i6" name="bank_cash_balance"
                    type="money" placeholder="00.00" :rightAlign="true"
                    value="{{ $financialStatement->bank_cash_balance }}" disabled="true" />
                </div>
              </div>
              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-input-field level="Jenis Pengauditan " id="i4" name="" type="text"
                    placeholder="" value="{{ $financialStatement->AuditType->prm }}" disabled="true" />
                </div>
              </div>
              <p class="mb-2 mt-4 font-medium text-gray-800">Sila Lampirkan Salinan Dokumen Seperti Di
                Bawah :</p>
              <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">

                  <x-pdf-download title="Penyata Kewangan Dan Nota Kewangan"
                    pdfFile="{{ $financialStatement->attachment1 ?? '' }}" />
                  <x-pdf-download title="Penyata Bank" pdfFile="{{ $financialStatement->attachment2 ?? '' }}" />
                </div>
                <div class="grid grid-cols-1 items-end gap-6 md:grid-cols-2">
                  <x-pdf-download title="Penyata Penyesuaian Bank"
                    pdfFile="{{ $financialStatement->attachment3 ?? '' }}" />
                </div>

              </div>
            </div>
          @endif
          <div class="mb-4 mt-4">
            <br><br>
            <div class="">
              <h5 class="text-start">Status Penghantaran / Status Semakan Audit </h5>
            </div>
            <div class="mt-4 grid max-w-3xl grid-cols-1 gap-x-16 gap-y-2">
              <div style="display: flex; margin-bottom: 12px; align-items: baseline;">
                <div style="font-weight: 500; width: 250px; text-align: left; color: black;">
                  Status </div>
                <div style="font-weight: 500; margin: 0 25px; color: black;">:</div>
                <div style="font-weight: 500; color: black;">
                  <x-status-badge :column="'FIN_STATUS'" :value="$financialStatement->FIN_STATUS['val'] ?? ''" :text="$financialStatement->FIN_STATUS['prm'] ?? 'Unknown'" />
                </div>
              </div>
              @if ($financialStatement->status == 3)
                @if ($financialStatement->cancel_reason_adm != null)
                  <x-show-key-value :key="'Sebab Pembatalan'" :value="$financialStatement->cancel_reason_adm" />
                @endif
                @if ($financialStatement->suggestion_adm != null)
                  <x-show-key-value :key="'Sebab Pembatalan'" :value="$financialStatement->suggestion_adm" />
                @endif
              @endif
              <x-show-key-value :key="'Disahkan Oleh'" :value="optional($financialStatement->VerifiedBy)->name ?? null" />
              <x-show-key-value :key="'Disahkan Pada'" :value="$financialStatement->verified_at ?? null" />

            </div>

            <div class="mt-8 flex justify-between">
              <a href="{{ route('reviwedStatementList') }}"
                class="ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg inline-flex items-center justify-center bg-gray-500 font-medium text-white hover:bg-gray-600">
                Kembali
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Find the actual select element - it might be wrapped or have a different ID
      const statusSelect = document.querySelector('select[name="status"]');

      if (statusSelect) {
        // Initial check
        checkStatus(statusSelect.value);

        // Add event listener
        statusSelect.addEventListener('change', function() {
          checkStatus(this.value);
        });
      } else {
        console.error('Status select element not found');
      }

      function checkStatus(status) {
        const cancellationFields = document.getElementById('cancellation_fields');
        if (cancellationFields) {
          if (status === '3') {
            cancellationFields.style.display = 'block';
          } else {
            cancellationFields.style.display = 'none';
          }
        } else {
          console.error('Cancellation fields container not found');
        }
      }
    });
  </script>
@endsection
