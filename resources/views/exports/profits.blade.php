<div class="title" style="padding-bottom: 13px">
    <div style="text-align: center;text-transform: uppercase;font-size: 15px">
        Cashier Application
    </div>
    <div style="text-align: center">
        Address: Baubau City, Southeast Sulawesi
    </div>
    <div style="text-align: center">
        Telp: 0823-4917-9616
    </div>
</div>
<table style="width: 100%">
    <thead>
        <tr style="background-color: #e6e6e7;">
            <th scope="col">Date</th>
            <th scope="col">Invoice</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($profits as $profit)
        <tr>
            <td>{{ $profit->created_at }}</td>
            <td>{{ $profit->transaction->invoice }}</td>
            <td class="text-end">{{ number_format($profit->total) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" class="text-end fw-bold" style="background-color: #e6e6e7;">TOTAL</td>
            <td class="text-end fw-bold" style="background-color: #e6e6e7;">{{ number_format($total) }}</td>
        </tr>
    </tbody>
</table>