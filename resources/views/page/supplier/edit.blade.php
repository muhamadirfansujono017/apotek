<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white flex items-center">
            <i class="fas fa-edit text-amber-500 me-3"></i> Edit Transaksi Pembelian
        </h2>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl p-8 border border-gray-100">
            <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Supplier</label>
                        <select name="supplier_id" class="w-full border-gray-200 rounded-xl" required>
                            @foreach ($supplier as $s)
                                <option value="{{ $s->id }}" {{ $pembelian->supplier_id == $s->id ? 'selected' : '' }}>{{ $s->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ $pembelian->tanggal }}" class="w-full border-gray-200 rounded-xl" required>
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-gray-800/50 p-6 rounded-2xl mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-sm font-black text-indigo-800 uppercase">Detail Item</span>
                        <button type="button" id="addRow" class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-xs shadow-lg">+ Item</button>
                    </div>

                    <div id="itemContainer" class="space-y-4">
                        @foreach($pembelian->detail as $detail)
                        <div class="row-item grid grid-cols-12 gap-4 bg-white dark:bg-gray-900 p-4 rounded-2xl shadow-sm items-center border border-gray-50">
                            <div class="col-span-12 md:col-span-4">
                                <select name="obat_id[]" class="w-full border-gray-100 rounded-lg text-sm" required>
                                    @foreach ($obat as $o)
                                        <option value="{{ $o->id }}" {{ $detail->obat_id == $o->id ? 'selected' : '' }}>{{ $o->nama_obat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <input type="number" name="harga_beli[]" value="{{ $detail->harga }}" class="harga-input w-full border-gray-100 rounded-lg text-sm" required>
                            </div>
                            <div class="col-span-12 md:col-span-2">
                                <input type="number" name="jumlah[]" value="{{ $detail->jumlah }}" class="qty-input w-full border-gray-100 rounded-lg text-sm" required>
                            </div>
                            <div class="col-span-10 md:col-span-2">
                                <input type="text" class="subtotal-display w-full border-none bg-transparent rounded-lg text-sm font-bold text-indigo-700 text-right" value="Rp {{ number_format($detail->subtotal, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="col-span-2 md:col-span-1 text-center">
                                <button type="button" class="remove-row text-rose-500"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between items-center px-4">
                        <span class="text-sm font-black text-gray-500 uppercase">Grand Total</span>
                        <span id="grandTotal" class="text-2xl font-black text-indigo-600">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-amber-500 text-white py-4 rounded-2xl font-black text-lg shadow-xl hover:bg-amber-600 transition">
                    UPDATE TRANSAKSI
                </button>
            </form>
        </div>
    </div>

    {{-- Template & Script (Gunakan template row yang ada di create.blade.php) --}}
    <template id="rowTemplate">
        <div class="row-item grid grid-cols-12 gap-4 bg-white dark:bg-gray-900 p-4 rounded-2xl shadow-sm items-center border border-gray-50 mt-4">
            <div class="col-span-12 md:col-span-4">
                <select name="obat_id[]" class="w-full border-gray-100 rounded-lg text-sm" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach ($obat as $o) <option value="{{ $o->id }}">{{ $o->nama_obat }}</option> @endforeach
                </select>
            </div>
            <div class="col-span-12 md:col-span-3">
                <input type="number" name="harga_beli[]" class="harga-input w-full border-gray-100 rounded-lg text-sm" placeholder="0" required>
            </div>
            <div class="col-span-12 md:col-span-2">
                <input type="number" name="jumlah[]" class="qty-input w-full border-gray-100 rounded-lg text-sm" placeholder="0" min="1" required>
            </div>
            <div class="col-span-10 md:col-span-2">
                <input type="text" class="subtotal-display w-full border-none bg-transparent rounded-lg text-sm font-bold text-indigo-700 text-right" value="Rp 0" readonly>
            </div>
            <div class="col-span-2 md:col-span-1 text-center">
                <button type="button" class="remove-row text-rose-500"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('itemContainer');
            const template = document.getElementById('rowTemplate');
            const grandTotalDisplay = document.getElementById('grandTotal');

            function calculateTotals() {
                let total = 0;
                document.querySelectorAll('.row-item').forEach(row => {
                    const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
                    const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                    const subtotal = harga * qty;
                    row.querySelector('.subtotal-display').value = 'Rp ' + subtotal.toLocaleString('id-ID');
                    total += subtotal;
                });
                grandTotalDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
            }

            document.getElementById('addRow').addEventListener('click', () => {
                container.appendChild(template.content.cloneNode(true));
            });

            container.addEventListener('input', (e) => {
                if (e.target.matches('.harga-input, .qty-input')) calculateTotals();
            });

            container.addEventListener('click', (e) => {
                if (e.target.closest('.remove-row')) {
                    if (container.querySelectorAll('.row-item').length > 1) {
                        e.target.closest('.row-item').remove();
                        calculateTotals();
                    }
                }
            });
        });
    </script>
</x-app-layout>