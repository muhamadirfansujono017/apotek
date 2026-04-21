<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white flex items-center">
            <i class="fas fa-cart-plus text-indigo-600 me-3"></i> Tambah Pembelian
        </h2>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-4">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl p-8 border border-gray-100 dark:border-gray-800">
            <form action="{{ route('pembelian.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2 tracking-widest">Supplier</label>
                        <select name="supplier_id" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500" required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($supplier as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2 tracking-widest">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border-gray-200 rounded-xl" required>
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-gray-800/50 p-6 rounded-2xl mb-6 border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-6 font-black text-indigo-800 uppercase tracking-wider">
                        <span>Rincian Obat Masuk</span>
                        <button type="button" id="addRow" class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-xs shadow-lg hover:bg-indigo-700 transition">+ Item</button>
                    </div>

                    <div id="itemContainer" class="space-y-4">
                        {{-- Row Item Pertama --}}
                        <div class="row-item grid grid-cols-12 gap-4 bg-white dark:bg-gray-900 p-4 rounded-2xl shadow-sm items-center border border-gray-50">
                            <div class="col-span-12 md:col-span-4">
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Obat</label>
                                <select name="obat_id[]" class="obat-select w-full border-gray-100 rounded-lg text-sm" required>
                                    <option value="">-- Pilih Obat --</option>
                                    @foreach ($obat as $o) 
                                        <option value="{{ $o->id }}" data-harga="{{ $o->harga_beli }}">
                                            {{ $o->nama_obat }}
                                        </option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Harga Beli (Rp)</label>
                                <input type="number" name="harga_beli[]" class="harga-input w-full border-gray-100 rounded-lg text-sm" placeholder="0" required>
                            </div>
                            <div class="col-span-12 md:col-span-2">
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Jumlah</label>
                                <input type="number" name="jumlah[]" class="qty-input w-full border-gray-100 rounded-lg text-sm" placeholder="0" min="1" required>
                            </div>
                            <div class="col-span-10 md:col-span-2">
                                <label class="text-[10px] font-bold text-gray-400 uppercase text-right block">Subtotal</label>
                                <input type="text" class="subtotal-display w-full border-none bg-transparent rounded-lg text-sm font-bold text-indigo-700 text-right" value="Rp 0" readonly>
                            </div>
                            <div class="col-span-2 md:col-span-1 text-center pt-4">
                                <button type="button" class="remove-row text-rose-500"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between items-center px-4">
                        <span class="text-sm font-black text-gray-500 uppercase">Total Harga</span>
                        <span id="grandTotal" class="text-2xl font-black text-indigo-600">Rp 0</span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-lg shadow-xl hover:bg-indigo-700 transition transform active:scale-95">
                    SIMPAN TRANSAKSI
                </button>
            </form>
        </div>
    </div>

    {{-- Template untuk baris baru --}}
    <template id="rowTemplate">
        <div class="row-item grid grid-cols-12 gap-4 bg-white dark:bg-gray-900 p-4 rounded-2xl shadow-sm items-center border border-gray-50 mt-4 animate-fade-in">
            <div class="col-span-12 md:col-span-4">
                <select name="obat_id[]" class="obat-select w-full border-gray-100 rounded-lg text-sm" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach ($obat as $o) 
                        <option value="{{ $o->id }}" data-harga="{{ $o->harga_beli }}">
                            {{ $o->nama_obat }}
                        </option> 
                    @endforeach
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

            // Fungsi Hitung Total
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

            // Fungsi Ambil Harga Otomatis Saat Pilih Obat
            container.addEventListener('change', (e) => {
                if (e.target.matches('.obat-select')) {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    const harga = selectedOption.getAttribute('data-harga') || 0;
                    
                    const row = e.target.closest('.row-item');
                    row.querySelector('.harga-input').value = harga;
                    
                    calculateTotals();
                }
            });

            // Tambah Baris
            document.getElementById('addRow').addEventListener('click', () => {
                container.appendChild(template.content.cloneNode(true));
            });

            // Update subtotal saat input harga/jumlah manual
            container.addEventListener('input', (e) => {
                if (e.target.matches('.harga-input, .qty-input')) calculateTotals();
            });

            // Hapus Baris
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

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>