<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>@lang('app.receipt') #{{ $booking->id }}</title>
    <style>

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 100%;
            height: auto;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-size: 14px;
            font-family: Verdana, Arial, Helvetica, sans-serif;
        }

        h2 {
            font-weight:normal;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: left;
            margin-top: 11px;
        }

        #logo img {
            height: 55px;
            margin-bottom: 15px;
        }

        #company {

        }

        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.2em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {

        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100% !important;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 5px 10px 7px 10px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td.desc h3, table td.qty h3 {
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
            width: 10%;
        }

        table .desc {
            text-align: left;
        }

        table .itemDesc {
            text-align: left;
            padding-top: 25px;
        }

        table .unit {
            background: #DDDDDD;
        }


        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total
        {
            font-size: 1.2em;
            text-align: center;
        }

        table td.unit{
            width: 35%;
        }

        table td.desc{
            width: 45%;
        }

        table td.qty{
            width: 5%;
        }

        .status {
            margin-top: 15px;
            padding: 1px 8px 5px;
            font-size: 1.3em;
            width: 80px;
            color: #fff;
            float: right;
            text-align: center;
            display: inline-block;
        }

        .status.unpaid {
            background-color: #E7505A;
        }
        .status.paid {
            background-color: #26C281;
        }
        .status.cancelled {
            background-color: #95A5A6;
        }
        .status.error {
            background-color: #F4D03F;
        }

        table tr.tax .desc {
            text-align: right;
            color: #1BA39C;
        }
        table tr.discount .desc {
            text-align: right;
            color: #E43A45;
        }
        table tr.subtotal .desc {
            text-align: right;
            color: #1d0707;
        }
        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 10px 20px 10px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-bottom: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }

        table.billing td {
            background-color: #fff;
        }

        table td div#invoiced_to {
            text-align: left;
        }

        #notes{
            color: #767676;
            font-size: 11px;
        }

        .pgi {
            page-break-inside: avoid;
        }

    </style>
</head>
<body>
<header class="clearfix">

    <table cellpadding="0" cellspacing="0" class="billing">
        <tr>
            <td>
                <div id="invoiced_to">
                    <small>@lang("modules.booking.billedTo"):</small>
                    <h3 class="name">{{ ucwords($booking->user->name) }}</h3>
                </div>
            </td>
            <td>
                <div id="company">
                    <small>@lang("modules.booking.generatedBy"):</small>
                    <h3 class="name">{{ ucwords($settings->company_name) }}</h3>
                    <div>{!! nl2br($settings->address) !!}</div>
                    <div>{{ $settings->company_phone }}</div>
                </div>
            </td>
        </tr>
    </table>
</header>
<main>
    <div id="details" class="clearfix">

        <div id="invoice">
            <h1>@lang('app.receipt') #{{ ($booking->id < 10) ? "0".$booking->id : $booking->id }}</h1>
            @if ($booking->date_time!='')
                <div class="date">@lang('app.booking') @lang('app.date'): {{ $booking->date_time }}</div>
            @endif
        </div>

    </div>
    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="no">#</th>
            <th class="desc"><b>@lang("app.item")</b></th>
            <th class="qty"><b>@lang("app.quantity")</b></th>
            <th class="qty"><b>@lang("app.unitPrice")</b></th>
            <th class="unit"><b>@lang("app.amount")</b></th>
        </tr>
        </thead>
        <tbody>
        <?php $count = 0; ?>
        @foreach($booking->items as $key=>$item)
            <tr style="page-break-inside: avoid;">
                <td class="no">{{ ++$count }}</td>
                <td class="desc itemDesc pt-3"><h3>{{ ucwords(is_null($item->business_service_id) ? $item->product->name : $item->businessService->name) }}</h3><br>
                </td>
                <td class="qty"><h3>{{ $item->quantity }}</h3></td>
                <td class="price" style="text-align: center">{{globalSetting()->currency->currency_code}} {{ number_format((float)$item->unit_price, 2, '.', '') }}</td>
                @if (!is_null($booking->deal_id))
                    <td class="unit"><span style="font-family: DejaVu Sans; sans-serif;"></span>{{globalSetting()->currency->currency_code}} {!!(number_format((float)($item->unit_price * $item->unit_quantity), 2, '.', '')) !!}</td>
                @else
                    <td class="unit"><span style="font-family: DejaVu Sans; sans-serif;"></span>{{globalSetting()->currency->currency_code}} {!!(number_format((float)(is_null($item->business_service_id) ? $item->product->discounted_price * $item->quantity : $item->businessService->discounted_price * $item->quantity), 2, '.', '')) !!}</td>
                @endif
            </tr>
        @endforeach

        <tr style="page-break-inside: avoid;" class="subtotal">
            <td class="no">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="desc">@lang("app.subTotal")</td>
            <td class="unit"><span style="font-family: DejaVu Sans; sans-serif;"></span>{{globalSetting()->currency->currency_code}} {{ number_format((float)$booking->original_amount+$booking->product_amount, 2, '.', '') }}</td>
        </tr>

        @if($booking->discount > 0)
        <tr style="page-break-inside: avoid;" class="discount">
            <td class="no">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="desc">@lang("app.discount")</td>
            <td class="unit">- <span style="font-family: DejaVu Sans; sans-serif;"></span>{{globalSetting()->currency->currency_code}} {{ number_format((float)$booking->discount, 2, '.', '') }}</td>
        </tr>
        @endif

        @if($booking->tax_amount > 0)
        <tr style="page-break-inside: avoid;" class="tax">
            <td class="no">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="desc">@lang('app.totalTax')</td>
            <td class="unit"> <span style="font-family: DejaVu Sans; sans-serif;"></span>{{globalSetting()->currency->currency_code}} {{ number_format((float)$booking->tax_amount, 2, '.', '') }}</td>
        </tr>
        @endif

        <tr style="page-break-inside: avoid;" class="tax">
            <td class="no">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="desc">@lang("app.total") @lang("app.paid")</td>
            <td class="unit"> <span style="font-family: DejaVu Sans; sans-serif;"></span>{{globalSetting()->currency->currency_code}} {{ number_format((float)$booking->amountPaid(), 2, '.', '') }}</td>
        </tr>

        <tr style="page-break-inside: avoid;" class="tax">
            <td class="no">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="desc">@lang("app.total")</td>
            <td class="unit"> <span style="font-family: DejaVu Sans; sans-serif;"></span>{{globalSetting()->currency->currency_code}} {{ number_format((float)$booking->amount_to_pay, 2, '.', '') }}</td>
        </tr>

        <tr style="page-break-inside: avoid;" class="tax">
            <td class="no">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="qty">&nbsp;</td>
            <td class="desc">@lang("app.payment") @lang("app.status")</td>
            <td class="unit"> <span style="font-family: DejaVu Sans; sans-serif;"></span>{{$booking->payment_status}}</td>
        </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>

    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="no">#</th>
            <th class="desc"><b>@lang("app.date")</b></th>
            <th class="qty"><b>@lang("app.paymentmethod")</b></th>
            <th class="unit"><b>@lang("app.amount")</b></th>
        </tr>
        </thead>
        <tbody>
            @php
            $count = 0;
            @endphp
        @foreach($booking->bookingPayments as $key => $payment)
            <tr class="pgi">
                <td class="no">{{ ++$count }}</td>
                <td  class="date" style="text-align: center"><h3>{{ \Carbon\Carbon::parse($payment->paid_on)->translatedFormat($settings->date_format) }}</h3></td>
                <td style="text-align: center"><h3>{{ $payment->gateway }}</h3></td>
                <td class="price" style="text-align: center">{{globalSetting()->currency->currency_code}} {{ number_format((float)$payment->amount_paid, 2, '.', '') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr dontbreak="true">
            <td colspan="4">@lang('app.amountRemaining')</td>
            <td style="text-align: center"> <span style="font-family: DejaVu Sans; sans-serif;"></span>{{globalSetting()->currency->currency_code}} {{ number_format((float)$booking->amountDue(), 2, '.', '') }}</td>
        </tr>
        </tfoot>
    </table>


</main>
</body>
</html>
