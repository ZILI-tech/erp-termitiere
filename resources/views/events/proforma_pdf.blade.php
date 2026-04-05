<style>
    body { font-family: sans-serif; text-transform: uppercase; }
    .header { border-bottom: 2px solid #000; padding-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    .total { font-weight: bold; font-size: 1.2em; color: #b91c1c; }
</style>

<div class="header">
    <h1>Facture Proforma</h1>
    <p>Événement : <strong>{{ $event->title }}</strong></p>
    <p>Client : {{ $event->client_name }}</p>
    <p>Date : {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</p>
</div>

<table>
    <thead>
        <tr style="background: #eee;">
            <th>Matériel</th>
            <th>Qté</th>
            <th>Prix Unit</th>
            <th>Jours</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($event->items as $item)
        <tr>
            <td>{{ $item->category }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->unit_price, 0) }} F</td>
            <td>{{ $item->days }}</td>
            <td>{{ number_format($item->total, 0) }} F CFA</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p class="total text-right">TOTAL À PAYER : {{ number_format($event->items->sum('total'), 0, ',', ' ') }} F CFA</p>