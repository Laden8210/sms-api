<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 14px; /* Smaller base text size */
        }

        h1 {
            text-align: center;
            color: #4f46e5;
            font-size: 1.8em; /* Smaller heading size */
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 0.9em; /* Smaller table text */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px 10px; /* Slightly smaller padding */
            text-align: left;
        }

        th {
            background-color: #4f46e5;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
            font-size: 0.85em; /* Even smaller text for additional notes */
        }

        .remarks {
            word-wrap: break-word;
            max-width: 300px;
        }

        /* Highlight alternate rows */
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1; /* Highlight row on hover */
        }
    </style>
</head>
<body>
    <h1>All Orders</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Jersey Name</th>
                <th>Jersey Number</th>
                <th>Size</th>
                <th>Remarks</th>
                <th>Order Date</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td class="text-center">{{ $order->id }}</td>
                    <td>{{ $order->jersey_name }}</td>
                    <td class="text-center">{{ $order->jersey_number }}</td>
                    <td class="text-center">{{ $order->size }}</td>
                    <td class="remarks">{{ $order->remarks ?? 'N/A' }}</td>
                    <td class="text-center">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        @if ($order->payment)
                            Paid (Ref: {{ $order->payment->reference_number }})
                        @else
                            Pending
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="text-center">Total Orders: <strong>{{ $orders->count() }}</strong></p>
</body>
</html>
