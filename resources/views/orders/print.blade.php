<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - PT Maju Bersama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    window.print();
</script>
</head>
<body class="bg-white antialiased">

    <!-- <div class="max-w-3xl mx-auto my-10 p-10 border border-gray-200" id="invoice">
        
        <div class="flex justify-between items-start border-b border-gray-800 pb-8 mb-8">
            <div>
<img src="{{ asset('images/logo.png') }}" class="h-20 mb-1">

<h1 class="text-2xl font-bold text-gray-900 tracking-tighter leading-none m-0 p-0">
    PT. MAJU BERSAMA
</h1>              <div class="text-xs text-gray-600 mt-2 leading-relaxed">
                    <p>Jl. Jendral Sudirman No. 123, Jakarta</p>
                    <p>Email: finance@majubersama.com | Telp: (021) 555-1234</p>
                </div>
            </div> -->
            <div class="flex justify-between items-center border-b border-gray-800 pb-4 mb-6">

    <!-- KIRI: LOGO -->
    <div class="flex items-center">
        <img src="{{ asset('images/logo.png') }}" class="h-16 w-auto">
    </div>

    <!-- KANAN: INVOICE -->
<div class="text-right">
                <h2 class="text-3xl font-light text-gray-400 uppercase tracking-widest">Invoice</h2>
                <p class="text-sm font-bold text-gray-800 mt-1">#{{ $order->kode_pesanan }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ date('d/m/Y') }}</p>
            </div>

</div>
            
        </div>

        <div class="grid grid-cols-2 gap-4 mb-10 text-sm">
            <div>
                <p class="text-gray-500 font-semibold uppercase text-[10px] tracking-wider mb-1">Kepada Yth:</p>
                <p class="text-base font-bold text-gray-900">{{ $order->customer->nama_customer }}</p>
            </div>
            <div class="text-right">
                </div>
        </div>

        <div class="w-full mb-8">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-y border-gray-800 text-[11px] uppercase tracking-wider text-gray-700">
                        <th class="py-3 px-2 w-12 text-center">No</th>
                        <th class="py-3 px-2">Deskripsi Produk</th>
                        <th class="py-3 px-2 text-center w-24">Kuantitas</th>
                        <th class="py-3 px-2 text-right w-32">Harga Satuan</th>
                        <th class="py-3 px-2 text-right w-32">Total</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach ($order->order_items ?? [] as $item)
                    <tr class="border-b border-gray-100">
                        <td class="py-4 px-2 text-center text-gray-500">{{ $loop->iteration }}</td>
                        <td class="py-4 px-2">
                            <span class="font-medium text-gray-900">{{ $item['nama_produk'] ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-2 text-center text-gray-700">{{ $item['quantity'] ?? 0 }}</td>
                        <td class="py-4 px-2 text-right text-gray-700">
                            {{ number_format($item['price'] ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-2 text-right font-bold text-gray-900">
                            {{ number_format(($item['quantity'] ?? 0) * ($item['price'] ?? 0), 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end uppercase tracking-tight">
            <div class="w-full sm:w-64 space-y-2">
                <div class="flex justify-between text-xs text-gray-600 px-2">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xs text-gray-600 px-2">
                    <span>Pajak (0%)</span>
                    <span>Rp 0</span>
                </div>
                <div class="flex justify-between text-base font-bold text-gray-900 border-t border-gray-800 pt-2 px-2">
                    <span>Total Bayar</span>
                    <span>Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-20 grid grid-cols-2 gap-10 text-xs">
            <div>
                <p class="font-bold text-gray-800 mb-2 underline italic">Informasi Pembayaran:</p>
                <p>Bank Transfer: **BCA 123-456-789**</p>
                <p>Atas Nama: **PT Maju Bersama**</p>
                <p class="mt-4 text-gray-400 italic">* Harap kirimkan bukti transfer untuk mempercepat proses.</p>
            </div>
            <div class="text-center">
                <p class="mb-20 text-gray-800">Hormat Kami,</p>
                <div class="border-t border-gray-400 w-40 mx-auto pt-1">
                    <p class="font-bold text-gray-900 uppercase">PT. Maju Bersama</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { background: white; }
            #invoice { border: none !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; padding: 0 !important; }
            tr { page-break-inside: avoid; }
        }
    </style>

</body>
</html>


<!-- backup -->
<!-- <h3>NOTA</h3>

<p>Kode: {{ $order->kode_pesanan }}</p>
<p>Customer: {{ $order->customer->nama_customer }}</p>


@foreach ($order->order_items ?? [] as $item)
<table>
    <tr>
        <td>No</td>
        <td>Produk</td>
        <td>Quantity</td>
        <td>Harga</td>
    </tr>
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item['nama_produk'] ?? '-' }}</td>
        <td>{{ $item['quantity'] ?? 0 }}</td>
        <td>Rp. {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
    </tr>
</table>
<p>
    Total: Rp. {{ number_format($order->total ?? 0, 0, ',', '.') }}
</p>
@endforeach

<script>
    window.print();
</script> -->