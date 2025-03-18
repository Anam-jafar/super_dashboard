@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Semakan Penghantaran Laporan Kewangan'" :breadcrumbs="[
                ['label' => 'Laporan Kewangan', 'url' => 'javascript:void(0);'],
                [
                    'label' => 'Penghantaran Baru
                                                                                                                                    ',
                ],
            ]" />
            <x-alert />
            <div class="mt-8 sm:p-4">
                <div class="grid grid-cols-1 gap-x-16 gap-y-2 max-w-3xl">
                    <x-show-key-value :key="'No Rujukan'" :value="$financialStatement->submission_refno" />
                    <x-show-key-value :key="'Tarikh Penghantaran'" :value="$financialStatement->SUBMISSION_DATE" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="grid grid-cols-1 gap-x-16 gap-y-2 max-w-3xl mt-8">
                        <x-show-key-value :key="'Institusi'" :value="$financialStatement->Institute->Type->prm" />
                        <x-show-key-value :key="'Jenis Institusi'" :value="$financialStatement->Institute->Category->prm" />
                        <x-show-key-value :key="'Nama Institusi'" :value="$financialStatement->Institute->name" />
                        <x-show-key-value :key="'Daerah'" :value="$financialStatement->Institute->District->prm" />
                        <x-show-key-value :key="'Mukim'" :value="$financialStatement->Institute->Subdistrict->prm" />
                        <x-show-key-value :key="'Bandar'" :value="$financialStatement->Institute->City->prm" />
                        <x-show-key-value :key="'Nombor Telefon (Rasmi)'" :value="$financialStatement->Institute->hp" />
                        <x-show-key-value :key="'Emel (Rasmi)'" :value="$financialStatement->Institute->mel" />
                    </div>
                    <div class=" max-w-3xl mt-8 space-y-2">
                        <x-show-key-value :key="'Nama Pengawai / Waki Institusi'" :value="$financialStatement->Institute->con1" />
                        <x-show-key-value :key="'Jawatan'" :value="$financialStatement->Institute->UserPosition->prm" />
                        <x-show-key-value :key="'Nombor Telefon'" :value="$financialStatement->Institute->tel1" />
                    </div>
                </div>
                <div class="bg-white text-xs p-4 md:p-4">
                    <x-alert />

                    @if ($instituteType == 2)
                        <div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-input-field level="Bagi Tahun" id="ye" disabled="true" name=""
                                        type="text" placeholder="Year" value="{{ $financialStatement->fin_year }}" />

                                    <x-input-field level="Kategori Penyata" id="statment" name="fin_category"
                                        type="text" disabled="true" placeholder="Pilih"
                                        value="{{ $financialStatement->Category->prm }}" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-input-field level="Peratus Kemajuan Pembinaan Terkini (%)" id="p1"
                                        name="latest_construction_progress" type="text" placeholder="00"
                                        value="{{ $financialStatement->latest_construction_progress }}" disabled="true" />
                                </div>
                            </div>
                            <p class="text-gray-800 font-medium mt-4">Butiran Penyata :</p>
                            <div class="grid grid-cols-3 gap-6">

                            </div>
                            <div class="grid grid-cols-2 gap-6 mt-4">
                                <p class="text-gray-700">A. Maklumat Pembinaan</p>
                                <p class="text-gray-700">B. Jumlah Kutipan</p>

                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-input-field level="(i) Kos Pembinaan (Asal, RM)" id="i1"
                                        name="ori_construction_cost" type="text" placeholder="00.00" :rightAlign="true"
                                        :required="true" value="{{ $financialStatement->ori_construction_cost }}"
                                        disabled="true" />
                                    <x-input-field level="(ii) Variation Order (Tambah Kurang, RM)" id="i2"
                                        name="variation_order" type="text" placeholder="00.00" :rightAlign="true"
                                        :required="true" value="{{ $financialStatement->variation_order }}"
                                        disabled="true" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-input-field level="(i) Kutipan Semasa (RM)" id="i3" name="current_collection"
                                        type="text" placeholder="00.00" :rightAlign="true" :required="true"
                                        value="{{ $financialStatement->current_collection }}" disabled="true" />
                                    <x-input-field level="(ii) Kutipan Terkumpul (RM)" id="i04" name="total_expenses"
                                        type="text" placeholder="00.00" :rightAlign="true" :required="true"
                                        value="{{ $financialStatement->total_expenses }}" disabled="true" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-6 mt-4">
                                <p class="text-gray-700 ">C. Jumlah Perbelanjaan</p>
                                <p class="text-gray-700 ">D. Jumlah Lebihan</p>

                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    <x-input-field level="(i) Pindahan Kepada PWS (RM)" id="i4" name="transfer_pws"
                                        type="text" placeholder="00.00" :rightAlign="true" :required="true"
                                        value="{{ $financialStatement->transfer_pws }}" disabled="true" />
                                    <x-input-field level="(ii) Belanja Pembinaan Masjid/Surau (RM)" id="i5"
                                        name="construction_expenses" type="text" placeholder="00.00" :rightAlign="true"
                                        :required="true" value="{{ $financialStatement->construction_expenses }}"
                                        disabled="true" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-input-field level="(i) Lebihan Masjid/Surau (RM)" id="i4" name="inst_surplus"
                                        type="text" placeholder="00.00" :rightAlign="true" :required="true"
                                        value="{{ $financialStatement->inst_surplus }}" disabled="true" />
                                    <x-input-field level="(ii) Lebihan PWS (RM)" id="i5" name="pws_surplus"
                                        type="text" placeholder="00.00" :rightAlign="true" :required="true"
                                        value="{{ $financialStatement->pws_surplus }}" disabled="true" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-input-field level="(iii) Belanja Pembinaan PWS (RM)" id="i6"
                                        name="pws_expenses" type="text" placeholder="00.00" :rightAlign="true"
                                        :required="true" value="{{ $financialStatement->pws_expenses }}"
                                        disabled="true" />
                                </div>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-pdf-download title="Penyata Kewangan"
                                        pdfFile="{{ $financialStatement->attachment1 ?? '' }}" />
                                    <x-pdf-download title="Penyata Bank"
                                        pdfFile="{{ $financialStatement->attachment2 ?? '' }}" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-pdf-download title="Certificate Completion & Compliance(CCC)"
                                        pdfFile="{{ $financialStatement->attachment3 ?? '' }}" />
                                </div>
                            </div>
                        </div>
                    @else
                        <div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-input-field level="Bagi Tahun" id="ye" disabled="true" name=""
                                        type="text" placeholder="Year" value="{{ $financialStatement->fin_year }}" />

                                    <x-input-field level="Kategori Penyata" id="statment" name="fin_category"
                                        type="text" disabled="true" placeholder="Pilih"
                                        value="{{ $financialStatement->Category->prm }}" />
                                </div>

                            </div>
                            <p class="text-gray-800 font-medium mt-4">Butiran Penyata :</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-input-field level="(a) Baki Bawa Ke Hadapan (RM)" id="i1"
                                        spanText="Baki bawa ke hadapan tahun sebelumnya bank dan tunai"
                                        name="balance_forward" type="text" placeholder="00.00" :rightAlign="true"
                                        disabled="true" value="{{ $financialStatement->balance_forward }}" />
                                    <x-input-field level="(b) Jumlah Kutipan (RM)" id="i2" name="total_collection"
                                        type="text" placeholder="00.00" :rightAlign="true" disabled="true"
                                        spanText="Jumlah Kutipan Tahun Semasa"
                                        value="{{ $financialStatement->total_collection }}" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-input-field level="(c) Jumlah Perbelanjaan (RM)" id="i3"
                                        name="total_expenses" type="text" placeholder="00.00" :rightAlign="true"
                                        disabled="true" value="{{ $financialStatement->total_expenses }}" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    <x-input-field level="Jumlah Pendapatan (Auto Calculate, RM)" id="i4"
                                        name="total_statement" type="text" placeholder="00.00" :rightAlign="true"
                                        :required="true" value="{{ $financialStatement->total_income }}"
                                        disabled="true" />
                                    <x-input-field level="Jumlah Lebihan (Auto Calculate, RM)" id="i5"
                                        name="total_surplus" type="text" placeholder="00.00" :rightAlign="true"
                                        :required="true" value="{{ $financialStatement->total_surplus }}"
                                        disabled="true" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-input-field level="Maklumat Baki Bank Dan Tunai (RM)" id="i6"
                                        name="bank_cash_balance" type="text" placeholder="00.00" :rightAlign="true"
                                        value="{{ $financialStatement->bank_cash_balance }}" disabled="true" />
                                </div>

                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    <x-input-field level="Jenis Pengauditan " id="i4" name=""
                                        type="text" placeholder="" value="{{ $financialStatement->AuditType->prm }}"
                                        disabled="true" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    <x-pdf-download title="Penyata Kewangan Dan Nota Kewangan"
                                        pdfFile="{{ $financialStatement->attachment1 ?? '' }}" />
                                    <x-pdf-download title="Penyata Bank"
                                        pdfFile="{{ $financialStatement->attachment2 ?? '' }}" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    <x-pdf-download title="Penyata Penyesuaian Bank"
                                        pdfFile="{{ $financialStatement->attachment3 ?? '' }}" />
                                </div>

                            </div>
                        </div>
                    @endif
                    <div class="mt-4 mb-4">

                        <br><br>
                        <div class="">
                            <h5 class="text-start">Status Penghantaran / Status Semakan Audit </h5>
                        </div>
                        <form action="" method="POST">

                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-input-field level="Status" id="audit" name="status" type="select"
                                        placeholder="Pilih" :valueList="$parameters['financial_statement_statuses']"
                                        onchange="toggleCancellationFields(this.value)" />
                                </div>
                            </div>

                            <div id="cancellation_fields" style="display: none;">
                                <div class="gap-6 mt-4 mb-4">
                                    <label class="text-gray-800 font-medium col-span-3" for="cancel_reason_adm">
                                        Alasan Pembatalan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="cancel_reason_adm" id="cancellation_reason" cols="30" rows="4"
                                        class="block w-full border !border-[#6E829F] focus:shadow-sm dark:focus:shadow-white/10 
                                        rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-[#6E829F] 
                                        dark:focus:border-white/10 text-black resize-none col-span-3 mt-2"></textarea>
                                </div>
                                <div class="gap-6 mt-4 mb-4">
                                    <label class="text-gray-800 font-medium col-span-3" for="correction_proposal_byadmin">
                                        Cadangan Pembetulan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="suggestion_adm" id="correction_proposal" cols="30" rows="4"
                                        class="block w-full border !border-[#6E829F] focus:shadow-sm dark:focus:shadow-white/10 
                                        rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-[#6E829F] 
                                        dark:focus:border-white/10 text-black resize-none col-span-3 mt-2"></textarea>
                                </div>
                            </div>



                            <div class="flex justify-between mt-8">
                                <a href="{{ route('statementList') }}"
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-medium ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg inline-flex items-center justify-center">
                                    Kembali
                                </a>

                                <button
                                    class="bg-[#5C67F7] ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                                    type="submit">
                                    Simpan
                                </button>
                            </div>
                        </form>
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
