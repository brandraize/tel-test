<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Sales Data</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #2d3748;
            margin-bottom: 30px;
            font-size: 32px;
        }
        .category-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        .category-title {
            font-size: 24px;
            font-weight: bold;
            color: #2b6cb0;
            text-transform: uppercase;
        }
        .category-title span {
            background: #2b6cb0;
            color: white;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 14px;
            margin-left: 10px;
        }
        .category-summary {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .summary-item {
            background: #f7fafc;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
        }
        .summary-item strong {
            color: #2d3748;
        }
        .summary-item .amount {
            color: #2b6cb0;
            font-weight: bold;
        }
        .summary-item .profit {
            color: #38a169;
            font-weight: bold;
        }
        .summary-item .pending {
            color: #e53e3e;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        thead {
            background: #edf2f7;
        }
        th {
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            color: #2d3748;
            border-bottom: 2px solid #e2e8f0;
        }
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        tr:hover {
            background: #f7fafc;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .badge-paid {
            background: #c6f6d5;
            color: #22543d;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-pending {
            background: #fed7d7;
            color: #9b2c2c;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-partial {
            background: #fefcbf;
            color: #975a16;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .no-data {
            text-align: center;
            color: #718096;
            padding: 20px;
        }
        .grand-total {
            background: #2d3748;
            color: white;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .grand-total .item {
            text-align: center;
        }
        .grand-total .label {
            font-size: 14px;
            opacity: 0.8;
        }
        .grand-total .value {
            font-size: 24px;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .category-summary {
                flex-direction: column;
                gap: 5px;
            }
            table {
                font-size: 12px;
            }
            th, td {
                padding: 6px 4px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 All Sales Data</h1>

        @foreach($categories as $category => $sales)
            @if($sales->count() > 0)
                <div class="category-section">
                    <div class="category-header">
                        <div class="category-title">
                            {{ ucfirst(str_replace('_', ' ', $category)) }}
                            <span>{{ $sales->count() }} records</span>
                        </div>
                        <div class="category-summary">
                            <div class="summary-item">
                                <strong>Total:</strong>
                                <span class="amount">${{ number_format($totals[$category]['total_amount'], 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <strong>Profit:</strong>
                                <span class="profit">${{ number_format($totals[$category]['total_profit'], 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <strong>Received:</strong>
                                <span class="amount">${{ number_format($totals[$category]['total_wasool'], 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <strong>Pending:</strong>
                                <span class="pending">${{ number_format($totals[$category]['total_baqii'], 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">Profit</th>
                                <th class="text-right">Wasool</th>
                                <th class="text-right">Baqii</th>
                                <th>Status</th>
                                <th>Extra</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $index => $sale)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $sale->name }}</strong></td>
                                    <td>{{ $sale->date ? $sale->date->format('d/m/Y') : '-' }}</td>
                                    <td class="text-center">{{ $sale->total_items ?? '-' }}</td>
                                    <td class="text-right">${{ number_format($sale->total_amount, 2) }}</td>
                                    <td class="text-right">${{ number_format($sale->net_profit, 2) }}</td>
                                    <td class="text-right">${{ number_format($sale->wasool, 2) }}</td>
                                    <td class="text-right">
                                        @if($sale->baqii > 0)
                                            <strong style="color: #e53e3e;">${{ number_format($sale->baqii, 2) }}</strong>
                                        @else
                                            $0.00
                                        @endif
                                    </td>
                                    <td>
                                        @if($sale->isFullyPaid())
                                            <span class="badge-paid">✅ Paid</span>
                                        @elseif($sale->wasool > 0)
                                            <span class="badge-partial">⚠️ Partial</span>
                                        @else
                                            <span class="badge-pending">❌ Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($sale->extra_fields)
                                            @foreach($sale->extra_fields as $key => $value)
                                                <span style="font-size:11px; background:#edf2f7; padding:2px 6px; border-radius:4px; margin:2px; display:inline-block;">
                                                    {{ $key }}: {{ $value }}
                                                </span>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach

        <!-- Grand Total -->
        @php
            $grandTotal = 0;
            $grandProfit = 0;
            $grandWasool = 0;
            $grandBaqii = 0;
            $totalRecords = 0;

            foreach($totals as $category => $data) {
                $grandTotal += $data['total_amount'];
                $grandProfit += $data['total_profit'];
                $grandWasool += $data['total_wasool'];
                $grandBaqii += $data['total_baqii'];
                $totalRecords += $data['count'];
            }
        @endphp

        <div class="grand-total">
            <div class="item">
                <div class="label">📋 Total Records</div>
                <div class="value">{{ $totalRecords }}</div>
            </div>
            <div class="item">
                <div class="label">💰 Total Amount</div>
                <div class="value">${{ number_format($grandTotal, 2) }}</div>
            </div>
            <div class="item">
                <div class="label">📈 Total Profit</div>
                <div class="value">${{ number_format($grandProfit, 2) }}</div>
            </div>
            <div class="item">
                <div class="label">💵 Total Received</div>
                <div class="value">${{ number_format($grandWasool, 2) }}</div>
            </div>
            <div class="item">
                <div class="label">⏳ Total Pending</div>
                <div class="value">${{ number_format($grandBaqii, 2) }}</div>
            </div>
        </div>
    </div>
</body>
</html>
