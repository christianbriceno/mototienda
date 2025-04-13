<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <style>
        div {
            text-align: center;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 0px;
        }

        th {
            background: #000;
            color: #fff;
            text-transform: uppercase;
        }

        .end {
            text-align: right;
        }

        .start start {
            text-align: left;
        }

        p {
            padding: 0%;
            padding-left: 0%;
            padding-right: 0%;
            padding-bottom: 10px;
            padding-top: 0%;
            margin: 0%;
            font-size: 2rem;
            font-weight: bold;
        }

        p.presentations {
            font-size: 1.7rem;
        }

        .subtotal {
            text-align: right;
        }

    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="text-center">
            {{-- <p class="mb-1 text-uppercase"><strong>SENIAT</strong></p> --}}
            <p class="mb-1 text-uppercase text-center"><strong>***TIENDA***</strong></p>
            <p class="mb-1 text-uppercase">{{ $invoice->issuer_rif }}</p>
            <p class="mb-1 text-uppercase">{{ $invoice->issuer_name }}</p>
            <p class="mb-1 text-uppercase">{{ $invoice->issuer_address }}</p>
            <p class="mb-1 text-uppercase">{{ $invoice->issuer_phone_number }}</p>
            <p class="mb-1 text-uppercase">{{ $invoice->issuer_email }}</p>
        </div>
        <br>
        <br>

        <p class="mb-1 text-uppercase">***CLIENTE***</p>
        @if ($invoice->receiver_name)
            <p class="mb-1 text-uppercase">{{ $invoice->receiver_name }}</p>
        @endif
        @if ($invoice->receiver_email)
            <p class="mb-1 text-uppercase">{{ $invoice->receiver_email }}</p>
        @endif
        @if ($invoice->receiver_rif)
            <p class="mb-1 text-uppercase">{{ $invoice->receiver_rif }}</p>
        @endif
        @if ($invoice->receiver_identification_card)
            <p class="mb-1 text-uppercase">{{ $invoice->receiver_identification_card }}</p>
        @endif
        @if ($invoice->receiver_address)
            <p class="mb-1 text-uppercase">{{ $invoice->receiver_address }}</p>
        @endif
        @if ($invoice->receiver_phone_number)
            <p class="mb-1 text-uppercase">{{ $invoice->receiver_phone_number }}</p>
        @endif
        <br>
        <br>

        <p class="mb-1 text-uppercase text-center"><strong>***FACTURA***</strong></p>
        <table class="table table-borderless">
            <tbody class="">
                <tr>
                    <td class="text-start start"><p class="mb-1 text-uppercase">FACTURA: </p></th>
                    <td class="text-end end"><p class="mb-1 text-uppercase">COD-{{ $invoice->id }}</p></td>
                </tr>
                <tr>
                    <td class="text-start start"><p class="mb-1 text-uppercase">FECHA: {{$invoice->created_at->format('d-m-y')}}</p></th>
                    <td class="text-end end"><p class="mb-1 text-uppercase">HORA: {{$invoice->created_at->format('H:m')}}</p></td>
                </tr>
                <tr>
                    <td class="text-start start"><p class="mb-1 text-uppercase">TASA DE CAMBIO VES: </p></td>
                    <td class="text-end end"><p class="mb-1 text-uppercase">BS {{number_format($invoice->order->exchange_rate, 2) }}</p></td>
                </tr>
            </tbody>
        </table>

        <hr>

        <table class="table table-borderless">
            <thead class="">
                <tr">
                    <td><p class="mb-1 text-uppercase">CANT</p></th>
                    <td><p class="mb-1 text-uppercase" style="text-align: center">DESCRIPCIÓN</p></th>
                    <td class="text-end"><p class="mb-1 text-uppercase">P.U</p></th>
                    <td class="text-end subtotal"><p class="mb-1 text-uppercase">SUBTOTAL</p></th>
                </tr>
            </thead>
            <tbody class="">
                @foreach ($invoice->order->orderPresentations as $orderPresentation)
                    <tr>
                        <td><p class="mb-1 text-uppercase">{{ $orderPresentation->quantity }}</p></th>
                        <td><p class="mb-1 text-uppercase presentations">{{ $orderPresentation->presentation->name }}</p></td>
                        <td class="text-end"><p class="mb-1 text-uppercase">${{ number_format($orderPresentation->unit_price_without_iva, 2) }}</p></td>
                        <td class="text-end subtotal"><p class="mb-1 text-uppercase">${{ number_format($orderPresentation->sub_total_unit_price_without_iva, 2) }}</p></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>

        <table class="table table-borderless">
            <tbody class="">
                <tr>
                    <td class="text-start start"><p class="mb-1 text-uppercase">SUBTOTAL: </p></th>
                    <td class="text-end end"><p class="mb-1 text-uppercase">${{number_format($invoice->total_without_iva, 2)}}</p></td>
                </tr>

                <tr>
                    <td class="text-start start"><p class="mb-1 text-uppercase">IVA 16%: </p></th>
                    <td class="text-end end"><p class="mb-1 text-uppercase">${{number_format($invoice->amount_iva, 2)}}</p></td>
                </tr>

                <tr>
                    <td class="text-start start"><p class="mb-1 text-uppercase">TOTAL: </p></th>
                    {{-- <td class="text-end end"><p class="mb-1 text-uppercase">${{number_format($invoice->total_with_iva, 2)}}</p></td> --}}
                    <td class="text-end end"><p class="mb-1 text-uppercase">${{number_format($invoice->total_without_iva + $invoice->amount_iva, 2)}}</p></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>




