<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 42px 52px 36px; }
        body {
            color: #56616d;
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            line-height: 1.45;
        }
        .top {
            color: #000;
            font-size: 9px;
            margin-bottom: 46px;
            text-align: center;
        }
        .top .date { float: left; }
        h1 {
            color: #5e6873;
            font-size: 16px;
            margin: 0 0 38px;
            text-transform: uppercase;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th {
            color: #aaa;
            font-size: 13px;
            font-weight: bold;
            padding: 0 14px 16px;
            text-align: left;
        }
        td {
            border-top: 1.2px solid #4e5965;
            padding: 16px 14px;
            vertical-align: top;
        }
        .product {
            color: #56616d;
            font-size: 13px;
            text-transform: uppercase;
        }
        .desc {
            color: #56616d;
            font-size: 10.5px;
            margin-top: 6px;
            text-transform: uppercase;
        }
        .family {
            color: #56616d;
            text-transform: uppercase;
            width: 118px;
        }
        .qty {
            width: 76px;
        }
        .price {
            width: 74px;
        }
        .section {
            page-break-after: always;
        }
        .section:last-child {
            page-break-after: auto;
        }
        .empty {
            border-top: 1.2px solid #4e5965;
            padding: 18px 14px;
        }
    </style>
</head>
<body>
    @foreach ($groups as $group)
        <section class="section">
            <div class="top">
                <span class="date">{{ $generatedAt }}</span>
                Compras - Sistema
            </div>

            <h1>{{ $group['label'] }} ({{ $group['products']->flatten(1)->count() }})</h1>

            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Família</th>
                        <th>Quantidade</th>
                        <th>Preço<br>R$</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($group['products'] as $family => $items)
                    @foreach ($items as $product)
                        <tr>
                            <td>
                                <div class="product">{{ $product->prod_name }}</div>
                                @if ($product->prod_desc)
                                    <div class="desc">{{ $product->prod_desc }}</div>
                                @endif
                            </td>
                            <td class="family">{{ $family }}</td>
                            <td class="qty">{{ $product->prod_qtde }}</td>
                            <td class="price">R$ {{ number_format((float) ($product->prod_price ?? 0), 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td class="empty" colspan="4">Nenhum produto nesta criticidade.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </section>
    @endforeach
</body>
</html>
