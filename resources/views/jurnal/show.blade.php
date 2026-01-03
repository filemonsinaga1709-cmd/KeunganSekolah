<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Jurnal</h2>
            <a href="{{ route('admin.jurnal.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 transition">Kembali</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Header Info -->
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold">Jurnal {{ ucfirst($jurnal->jenis) }}</h3>
                            <p class="text-sm opacity-90 mt-1">{{ $jurnal->tanggal->format('d F Y') }}</p>
                        </div>
                        <div class="text-right">
                            @if($jurnal->ref_tipe)
                                <span class="px-3 py-1 bg-white/20 rounded-full text-xs">Auto-Generated</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="px-6 py-4 border-b">
                    <p class="text-sm font-medium text-gray-700 mb-1">Keterangan:</p>
                    <p class="text-gray-900">{{ $jurnal->keterangan }}</p>
                </div>

                <!-- Entry Details -->
                <div class="px-6 py-4">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-300">
                                <th class="py-3 text-left text-sm font-semibold text-gray-700">Akun</th>
                                <th class="py-3 text-right text-sm font-semibold text-gray-700">Debit</th>
                                <th class="py-3 text-right text-sm font-semibold text-gray-700">Kredit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($jurnal->details as $detail)
                            <tr>
                                <td class="py-3">
                                    <div class="flex items-start">
                                        @if($detail->debit > 0)
                                            <span class="text-gray-900 font-medium">{{ $detail->akun->nama_akun }}</span>
                                        @else
                                            <span class="ml-8 text-gray-900 font-medium">{{ $detail->akun->nama_akun }}</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $detail->akun->kode_akun }}</div>
                                </td>
                                <td class="py-3 text-right">
                                    @if($detail->debit > 0)
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($detail->debit, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right">
                                    @if($detail->kredit > 0)
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($detail->kredit, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t-2 border-gray-300">
                            <tr class="bg-gray-50">
                                <td class="py-3 font-bold text-gray-900">Total</td>
                                <td class="py-3 text-right font-bold text-gray-900">Rp {{ number_format($jurnal->details->sum('debit'), 0, ',', '.') }}</td>
                                <td class="py-3 text-right font-bold text-gray-900">Rp {{ number_format($jurnal->details->sum('kredit'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Footer Info -->
                <div class="px-6 py-4 bg-gray-50 border-t text-xs text-gray-500">
                    <div class="flex justify-between">
                        <span>Dibuat oleh: {{ $jurnal->user->name }}</span>
                        <span>{{ $jurnal->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
