<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <style>
            .w-full {
                width: 100%;
            }
            .p-2 {
                padding: 0.5rem/* 8px */;
            }
            .px-2 {
                padding-left: 0.5rem/* 8px */;
                padding-right: 0.5rem/* 8px */;
            }
            .mb-4 {
                margin-bottom: 1rem/* 16px */;
            }
            .font-semibold {
                font-weight: 600;
            }
            .text-left {
                text-align: left;
            }
            .text-center {
                text-align: center;
            }
            .text-right {
                text-align: right;
            }
            .text-xs {
                font-size: 0.75rem/* 12px */;
                line-height: 1rem/* 16px */;
            }
            .text-lg {
                font-size: 1.125rem/* 18px */;
                line-height: 1.75rem/* 28px */;
            }
            .whitespace-nowrap {
                white-space: nowrap;
            }
        </style>
    </head>

    <body>
        <table class="w-full mb-4">
            <tr>
                <th class="px-2 text-left text-lg">
                    Laporan Transaksi
                </th>
            </tr>
            <tr>
                <td class="px-2 text-xs">
                    <span class="font-semibold">{{ Carbon\Carbon::parse($early_period)->format('d M Y') }}</span>
                    sampai
                    <span class="font-semibold">{{ Carbon\Carbon::parse($end_period)->format('d M Y') }}</span>
                </td>
                <td class="px-2 text-right text-xs">
                    Dibuat tanggal {{ Carbon\Carbon::now()->format('d M Y H:m') }}
                </td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th class="p-2 text-xs">NO</th>
                    <th class="p-2 text-left text-xs">ID TXT</th>
                    <th class="p-2 text-left text-xs">NAMA PRODUK</th>
                    <th class="p-2 text-center text-xs">HARGA</th>
                    <th class="p-2 text-center text-xs">QTY</th>
                    <th class="p-2 text-center text-xs">TOTAL</th>
                    <th class="p-2 text-left text-xs">PEMBELI</th>
                    <th class="p-2 text-left text-xs">ADMIN</th>
                    <th class="p-2 text-left text-xs">DIBUAT</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalQty = 0;
                    $totalIncome = 0;
                @endphp

                @foreach($transactions as $value)
                    <tr>
                        <td class="p-2 text-xs">{{ $loop->iteration }}.</td>
                        <td class="p-2 text-xs">{{ $value->id_unique_tx }}</td>
                        <td class="p-2 text-xs">{{ $value->nama_item }}</td>
                        <td class="p-2 text-center text-xs whitespace-nowrap">Rp. {{ number_format($value->harga, 0, ',', '.') }}</td>
                        <td class="p-2 text-center text-xs whitespace-nowrap">{{ $value->jumlah }}</td>
                        <td class="p-2 text-center text-xs whitespace-nowrap">Rp. {{ number_format($value->total, 0, ',', '.') }}</td>
                        <td class="p-2 text-xs">{{ $value->nama_depan_us }}</td>
                        <td class="p-2 text-xs">{{ $value->nama_depan_ad }}</td>
                        <td class="p-2 text-xs">{{ Carbon\Carbon::parse($value->created_at)->format('d M Y H:m') }}</td>
                    </tr>

                    @php
                        $totalQty += $value->jumlah;
                        $totalIncome += $value->total;
                    @endphp
                @endforeach

                <tr>
                    <td></td>
                    <th colspan="3" class="p-2 text-left text-xs">Jumlah Total Keseluruhan</th>
                    <th class="p-2 text-center text-xs">{{ $totalQty }}</th>
                    <th class="p-2 text-center text-xs whitespace-nowrap">Rp. {{ number_format($totalIncome, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
    </body>
</html>
