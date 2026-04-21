<x-app-layout>
    <div class="py-12 max-w-5xl mx-auto px-4">
        <form action="{{ route('penjualan.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-[2.5rem] p-10 border border-gray-100 dark:border-gray-800">
                <h2 class="text-3xl font-black text-gray-800 dark:text-white mb-8 italic">Transaksi Baru</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Tanggal Transaksi</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 dark:bg-gray-800 dark:border-gray-700 text-gray-800 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Cari Obat</label>
                        <select id="select_obat" class="w-full rounded-xl border-gray-200 dark:bg-gray-800">
                            <option value="">-- Pilih Obat --</option>
                            @foreach($obat as $o)
                                <option value="{{ $o->id }}" data-nama="{{ $o->nama_obat }}" data-harga="{{ $o->harga_jual }}" data-stok="{{ $o->stok }}">
                                    {{ $o->nama_obat }} (Stok: {{ $o->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <table class="w-full mb-8" id="tabel_item">
                    <thead>
                        <tr class="text-left text-xs font-black text-gray-400 uppercase border-b-2">
                            <th class="pb-4">Nama Obat</th>
                            <th class="pb-4 text-center">Qty</th>
                            <th class="pb-4 text-right">Harga</th>
                            <th class="pb-4 text-right">Subtotal</th>
                            <th class="pb-4"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-8 rounded-[2rem] space-y-4 text-right">
                    <h3 class="text-gray-400 font-bold uppercase text-xs">Total Pembayaran</h3>
                    <h1 class="text-5xl font-black text-indigo-600" id="display_total">Rp 0</h1>
                    <input type="hidden" name="total_akhir" id="input_total_akhir" value="0">
                    
                    <div class="flex flex-col items-end gap-4 mt-6 pt-6 border-t border-indigo-100 dark:border-indigo-800">
                        <div class="w-64">
                            <label class="block text-xs font-black uppercase text-indigo-400 mb-2">Bayar (Cash)</label>
                            <input type="number" name="bayar" id="input_bayar" class="w-full text-right text-2xl font-black rounded-xl border-indigo-200" placeholder="0" required>
                        </div>
                        <div class="w-64">
                            <label class="block text-xs font-black uppercase text-gray-400 mb-1">Kembalian</label>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white" id="display_kembalian">Rp 0</h2>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-xl hover:bg-indigo-700 transition">Simpan Transaksi</button>
                    <a href="{{ route('penjualan.index') }}" class="px-8 py-4 bg-gray-100 dark:bg-gray-800 text-gray-400 rounded-2xl font-bold">Batal</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        const selectObat = document.getElementById('select_obat');
        const tabelItem = document.querySelector('#tabel_item tbody');
        const displayTotal = document.getElementById('display_total');
        const inputTotalAkhir = document.getElementById('input_total_akhir');
        const inputBayar = document.getElementById('input_bayar');
        const displayKembalian = document.getElementById('display_kembalian');

        selectObat.addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            if(!opt.value) return;

            const row = `
                <tr class="border-b border-gray-50 item-row">
                    <td class="py-4">
                        <span class="font-bold text-gray-800 dark:text-white uppercase">${opt.dataset.nama}</span>
                        <input type="hidden" name="obat_id[]" value="${opt.value}">
                    </td>
                    <td class="py-4 text-center">
                        <input type="number" name="jumlah[]" value="1" min="1" max="${opt.dataset.stok}" class="w-20 rounded-lg border-gray-200 input-qty text-center font-bold">
                    </td>
                    <td class="py-4 text-right">
                        <span class="font-medium">Rp ${parseInt(opt.dataset.harga).toLocaleString('id-ID')}</span>
                        <input type="hidden" class="input-harga" value="${opt.dataset.harga}">
                    </td>
                    <td class="py-4 text-right font-black text-indigo-600">
                        <span class="subtotal-text">Rp ${parseInt(opt.dataset.harga).toLocaleString('id-ID')}</span>
                    </td>
                    <td class="py-4 text-right">
                        <button type="button" class="text-red-400 hover:text-red-600 btn-hapus"><i class="fas fa-times-circle"></i></button>
                    </td>
                </tr>
            `;
            tabelItem.insertAdjacentHTML('beforeend', row);
            this.value = "";
            hitungSemua();
        });

        document.addEventListener('input', function(e) {
            if(e.target.classList.contains('input-qty') || e.target.id === 'input_bayar') hitungSemua();
        });

        document.addEventListener('click', function(e) {
            if(e.target.closest('.btn-hapus')) { e.target.closest('tr').remove(); hitungSemua(); }
        });

        function hitungSemua() {
            let grandTotal = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const qty = row.querySelector('.input-qty').value;
                const harga = row.querySelector('.input-harga').value;
                const sub = qty * harga;
                row.querySelector('.subtotal-text').innerText = 'Rp ' + sub.toLocaleString('id-ID');
                grandTotal += sub;
            });
            displayTotal.innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
            inputTotalAkhir.value = grandTotal;

            const bayar = inputBayar.value || 0;
            const kembalian = bayar - grandTotal;
            displayKembalian.innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
            displayKembalian.className = kembalian < 0 ? 'text-2xl font-bold text-red-500' : 'text-2xl font-bold text-emerald-500';
        }
    </script>
</x-app-layout>