<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Jurnal Umum</h2>
            <a href="{{ route('admin.jurnal.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 transition">Kembali</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="text-lg font-semibold text-white">Form Entry Jurnal</h3>
                </div>

                <form action="{{ route('admin.jurnal.store') }}" method="POST" id="jurnalForm" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal') border-red-500 @enderror" required>
                            @error('tanggal')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">Jenis Jurnal <span class="text-red-500">*</span></label>
                            <select name="jenis" id="jenis" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('jenis') border-red-500 @enderror" required>
                                <option value="umum" {{ old('jenis') == 'umum' ? 'selected' : '' }}>Jurnal Umum</option>
                                <option value="penyesuaian" {{ old('jenis') == 'penyesuaian' ? 'selected' : '' }}>Jurnal Penyesuaian</option>
                                <option value="penutup" {{ old('jenis') == 'penutup' ? 'selected' : '' }}>Jurnal Penutup</option>
                            </select>
                            @error('jenis')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Balance</label>
                            <div class="flex items-center space-x-2">
                                <span id="balance-indicator" class="px-3 py-2 text-sm font-semibold rounded bg-gray-100 text-gray-800">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan <span class="text-red-500">*</span></label>
                        <textarea name="keterangan" id="keterangan" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('keterangan') border-red-500 @enderror" required>{{ old('keterangan') }}</textarea>
                        @error('keterangan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Entries Table -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-3">
                            <label class="block text-sm font-medium text-gray-700">Entry Jurnal <span class="text-red-500">*</span></label>
                            <button type="button" onclick="addRow()" class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-md transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Baris
                            </button>
                        </div>

                        @error('details')<p class="mb-2 text-sm text-red-600">{{ $message }}</p>@enderror

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border" id="entriesTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Akun</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Debit</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Kredit</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase" style="width: 60px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="entriesBody">
                                    <!-- Rows will be added dynamically -->
                                </tbody>
                                <tfoot class="bg-gray-50 font-semibold">
                                    <tr>
                                        <td class="px-4 py-3 text-right">Total:</td>
                                        <td class="px-4 py-3 text-right" id="totalDebit">Rp 0</td>
                                        <td class="px-4 py-3 text-right" id="totalKredit">Rp 0</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                        <a href="{{ route('admin.jurnal.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-xs text-gray-700 uppercase font-semibold hover:bg-gray-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 border border-transparent rounded-md text-xs text-white uppercase font-semibold hover:bg-blue-700 transition">Simpan Jurnal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const akuns = @json($akuns);
        let rowCounter = 0;

        function addRow() {
            const tbody = document.getElementById('entriesBody');
            const row = document.createElement('tr');
            row.id = `row-${rowCounter}`;
            row.className = 'hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-4 py-3">
                    <select name="details[${rowCounter}][akun_id]" onchange="calculateTotal()" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                        <option value="">-- Pilih Akun --</option>
                        ${akuns.map(akun => `<option value="${akun.id}">${akun.kode_akun} - ${akun.nama_akun}</option>`).join('')}
                    </select>
                </td>
                <td class="px-4 py-3">
                    <input type="number" name="details[${rowCounter}][debit]" step="0.01" min="0" value="0" onchange="handleDebitChange(this); calculateTotal()" class="w-full text-right rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                </td>
                <td class="px-4 py-3">
                    <input type="number" name="details[${rowCounter}][kredit]" step="0.01" min="0" value="0" onchange="handleKreditChange(this); calculateTotal()" class="w-full text-right rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                </td>
                <td class="px-4 py-3 text-center">
                    <button type="button" onclick="removeRow(${rowCounter})" class="text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
            rowCounter++;
            calculateTotal();
        }

        function removeRow(id) {
            const row = document.getElementById(`row-${id}`);
            if (row) {
                row.remove();
                calculateTotal();
            }
        }

        function handleDebitChange(input) {
            const row = input.closest('tr');
            const kreditInput = row.querySelector('input[name*="[kredit]"]');
            if (parseFloat(input.value) > 0) {
                kreditInput.value = 0;
            }
        }

        function handleKreditChange(input) {
            const row = input.closest('tr');
            const debitInput = row.querySelector('input[name*="[debit]"]');
            if (parseFloat(input.value) > 0) {
                debitInput.value = 0;
            }
        }

        function calculateTotal() {
            let totalDebit = 0;
            let totalKredit = 0;

            document.querySelectorAll('input[name*="[debit]"]').forEach(input => {
                totalDebit += parseFloat(input.value) || 0;
            });

            document.querySelectorAll('input[name*="[kredit]"]').forEach(input => {
                totalKredit += parseFloat(input.value) || 0;
            });

            document.getElementById('totalDebit').textContent = 'Rp ' + totalDebit.toLocaleString('id-ID');
            document.getElementById('totalKredit').textContent = 'Rp ' + totalKredit.toLocaleString('id-ID');

            const balance = totalDebit - totalKredit;
            const indicator = document.getElementById('balance-indicator');
            
            if (balance === 0 && totalDebit > 0) {
                indicator.textContent = 'Balance ✓';
                indicator.className = 'px-3 py-2 text-sm font-semibold rounded bg-green-100 text-green-800';
            } else if (balance !== 0) {
                indicator.textContent = 'Not Balanced';
                indicator.className = 'px-3 py-2 text-sm font-semibold rounded bg-red-100 text-red-800';
            } else {
                indicator.textContent = '-';
                indicator.className = 'px-3 py-2 text-sm font-semibold rounded bg-gray-100 text-gray-800';
            }
        }

        // Add initial rows
        addRow();
        addRow();
    </script>
    @endpush
</x-app-layout>
