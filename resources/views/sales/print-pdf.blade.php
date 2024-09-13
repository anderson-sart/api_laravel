<!-- resources/views/sales/print-pdf.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Detalhes do Pedido</title>
    <style>
        @page {
            margin: 10px;
            margin-top: 30px;
        }
        body {
            margin: 10px;
            margin-top: 30px;

            font-family: Arial, sans-serif;
        }
        header {
            position: fixed;
            top: -25px;
            left: 0px;
            right: 0px;
            height: 80px;
            text-align: center;
        }
        .logo {
            float: left;
            width: 140px;
        }
        .description {
            float: left;
            font-size: 9px;
            text-align: left;
            margin-left: 10px;
            margin-top: 0px;
        }
        .description p{
            margin: 5px;
        }
        .subdescription {
            float: right;
            font-size: 11px;
            text-align: right;
            margin-right: 10px;
            margin-top: 5px;
        }
        .header {
            text-align: center;
            width: 100%;
            border-collapse: collapse;
        }
        .header td {
            vertical-align: middle;
        }
        
        .content {
            margin: 5px;
        }
        .titulo {
            font-size:22px;
            text-align:center;
            vertical-align: middle;
            font-weight: bold; /* Adiciona negrito aos cabeçalhos */


        }
        .subtitulo {
            font-size:15px;
            text-align:left;
            font-weight: bold; /* Adiciona negrito aos cabeçalhos */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th , td {
            padding: 3px;
            font-size:10px;
            text-align: left;
        }
        .ListaItem th {
            padding-left: 5px;
            border: 1px solid #a69f9f;
            background-color: #d1d1d1;
        }
        .ListaItem td {
            padding-left: 5px;
            border: 1px solid #a69f9f;
            font-size:10px;
            text-align: left;
        }
        .ListaItem tr:nth-child(even) {
            background-color: #e0e0e0;
        }
        .ListaTotal td{
            border: 1px solid #a69f9f;
            padding-left: 5px;
            font-size:12px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #000;
        }
        .no-border {
            border: none !important;
        }
        .first-uppercase::first-letter {
            text-transform: uppercase;
        }
        .lowercase {
            text-transform: lowercase;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('img/logo.png') }}"  alt="Logo" class="logo">
        <div class="description">
            @if(isset($company))
                <p><strong>{{ $company->company_name }}</strong></p>
                <p>{{ $company->email }}</p>
                <p>{{ $company->phone }}</p>
            @else
                <p>Informações da empresa não disponíveis</p>
            @endif
        </div>
        <div class="subdescription">
            @if(isset($company))
                {{ $company->event_description }}
            @else
                Informações do evento não disponíveis
            @endif
        </div>
    </header>    
    <div class="content">
        <div class="subtitulo">Informações do Pedido</div>
        <table border="0">
            <tr>
                <td width="15%" style="text-align: right;"><strong>Pedido :</strong></td>
                <td width="20%" style="text-align: left;" >
                    {{ $sale->id }} <strong>/ On-line:</strong> {{ $sale->sale_code }}
                </td>
                <td style="text-align: right;"><strong>Data do Pedido :</strong></td>
                <td style="text-align: left;" >
                    @php
                        $created_at = $sale->created_at;
                        $formattedMaxDate = \Carbon\Carbon::parse($created_at)->format('d/m/Y');
                    @endphp
                    {{ $formattedMaxDate }}
                </td>
                <td width="33%" rowspan="6" style=" padding: 0px; text-align: right; vertical-align: top;">
                    <table border="0">
                        <tr>
                            <td style="text-align: left;">
                                @if(isset($sale->customer->id))
                                    <strong>Cliente : </strong><span class="first-uppercase">{{ $sale->customer->corporate_name }}</span>
                                @elseif(isset($sale->customer_corporate_name) && !empty($sale->customer_corporate_name))
                                    <strong>Cliente : </strong><span class="first-uppercase"></span>{{ $sale->customer_corporate_name }}</span>
                                @endif
                            </td>
                        </tr>
                        @if(isset($sale->customer) && !empty($sale->customer->contact))
                            <tr>
                                <td style="text-align: left;">
                                    <strong>Contato : </strong><span class="first-uppercase">{{ $sale->customer->contact }}</span>
                                </td>
                            </tr>
                        @elseif(isset($sale->customer_contact) && !empty($sale->customer_contact))
                            <tr>    
                                <td style="text-align: left;">
                                    <strong>Contato : </strong><span class="first-uppercase"></span>{{ $sale->customer_contact }}</span>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td style="text-align: left;">
                                @if(isset($sale->customer->id))
                                    <strong>CNPJ : </strong><span class="first-uppercase">{{ $sale->customer->cpf_cnpj }}</span>
                                @elseif(isset($sale->customer_cnpj) && !empty($sale->customer_cnpj))
                                    <strong>CNPJ : </strong><span class="first-uppercase"></span>{{ $sale->customer_cnpj }}</span>
                                @endif
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: left;">
                                @if(isset($sale->customer->id))
                                    <strong>E-mail : </strong><span class="lowercase">{{ $sale->customer->email }}</span>
                                @elseif(isset($sale->customer_email) && !empty($sale->customer_email))
                                <strong>E-mail : </strong><span class="lowercase">{{ $sale->customer_email }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">
                                @if(isset($sale->customer->id))
                                    <strong>Telefone : </strong>{{ $sale->customer->phone }}
                                @elseif(isset($sale->customer_phone) && !empty($sale->customer_phone))
                                    <strong>Telefone : </strong>{{ $sale->customer_phone }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">
                                <strong>Observação : </strong>{{ $sale->observation }}
                            </td>
                        </tr>
                    </table>                
                </td>
            </tr>
            <tr>
                <td width="14%" style="text-align: right;"><strong>Usuário :</strong></td>
                <td width="18%" style="text-align: left;">
                    @if(isset($sale->user->name))
                        {{ $sale->user->name }}
                    @else
                        Nome do usuário não disponível
                    @endif                
                </td>
                <td style="text-align: right;"><strong>Tipo de venda :</strong></td>
                <td style="text-align: left;" >
                    @if(isset($sale->typeSale->type_sale))
                        {{ $sale->typeSale->type_sale }} - {{ $sale->typeSale->type_sale_description }}
                    @else
                        indisponível
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align: right;"><strong>Tabela de preço :</strong></td>
                <td style="text-align: left;" colspan="3" >
                    @if(isset($sale->priceTable->price_table))
                        {{ $sale->priceTable->price_table_description }}
                    @else
                        indisponível
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align: right;"><strong>Prazo :</strong></td>
                <td style="text-align: left;" colspan="3"  >
                    @if(isset($sale->paymentTerm->payment_term))
                        {{ $sale->paymentTerm->payment_term_description }}
                    @else
                        indisponível
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align: right;"><strong>Vendedor :</strong></td>
                <td style="text-align: left;" colspan="3">
                    @if(isset($sale->seller->corporate_name))
                        {{ $sale->seller->corporate_name }}
                    @else
                        Nome do usuário não disponível
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align: right;"><strong>Tipo preço :</strong></td>
                <td style="text-align: left;" colspan="3">
                    @if(isset($sale->billingType->billing_type_description))
                        {{ $sale->billingType->billing_type_description }}
                    @else
                        indisponível
                    @endif
                </td>
            </tr>

            <tr>
                <td style="text-align: right;"><strong>Transportador :</strong></td>
                <td style="text-align: left;" colspan="4" >
                    @if(isset($sale->carrier->corporate_name))
                        {{ $sale->carrier->corporate_name }}
                    @else
                        indisponível
                    @endif
                </td>
            </tr>
        </table>
        @php
            $totalItem = 0;
            $totalQuantity = 0;
            $totalGrossAmount = 0;
            $totalNetAmount = 0;
        @endphp
        @foreach($item_group as $periodo)
        <table class="ListaItem" style=" margin-top: 5px;">
            <thead >
                <tr >
                    <td colspan="8" class="no-border">
                        <div class="subtitulo" style="text-align: center; margin: 5px;">
                            {{ $periodo['period']->sale_delivery_period}} - {{ $periodo['period']->description_period}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <th width="10%">Código</th>
                    <th width="25%">Descrição</th>
                    <th width="10%">Cód. Barras</th>
                    <th width="10%">Vlr. Bruto</th>
                    <th width="5%">%Desc.</th>
                    <th width="10%">Vlr. Líquido</th>
                    <th width="10%">Quant.</th>
                    <th width="20%">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalQuantityP = 0;
                    $totalNetAmountP = 0;
                    $totalItemP = 0
                @endphp
                @foreach($periodo['items'] as $item)
                    @php
                        $totalItem     += 1;
                        $totalQuantity += $item->total_quantity;
                        $totalGrossAmount += round($item->unitary_price * $item->total_quantity,2);
                        $totalNetAmount += round($item->preco_liquido * $item->total_quantity,2);
                        $totalItemP     += 1;
                        $totalQuantityP += $item->total_quantity;
                        $totalNetAmountP += round($item->preco_liquido * $item->total_quantity,2);
                        $totaliquido   = round($item->preco_liquido * $item->total_quantity,2);

                    @endphp
                    <tr>
                        <td>
                            {{ $item->product->product_code }}
                        </td>
                        <td>
                            {{ $item->product->product_description }}
                        </td>
                        <td>
                            {{ $item->product->bar_code }}
                        </td>
                        <td>
                            R$ {{ number_format($item->unitary_price, 2, ',', '.') }}
                        </td>
                        <td>
                            {{ number_format($item->discount_percentage, 2, ',', '.') }}
                        </td>
                        <td>
                            R$ {{ number_format($item->preco_liquido, 2, ',', '.')}}
                        </td>
                        <td>
                            {{ number_format($item->total_quantity, 0, ',', '.') }}
                        </td>
                        <td width="15%">
                            R$ {{ number_format($totaliquido, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                <tr style="border: none;">
                    <td colspan="2" style="text-align: left;"><strong>{{ number_format($totalItemP, 0, ',', '.') }} Item(s)</strong></td>
                    <td colspan="4" style="text-align: right;"><strong>Parcial</strong></td>
                    <td><strong>{{ number_format($totalQuantityP, 0, ',', '.') }}</strong></td>
                    <td><strong>{{ number_format($totalNetAmountP, 2, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
        @endforeach
    </div>
    <div class="content" style="margin-top: 20px;">

        <table class="ListaTotal">
                <tbody>
                <tr>
                    <td width="15%" style="text-align: right;"><strong>Peças:</strong></td>
                    <td width="16%" style="text-align: left;" >
                        {{ number_format($totalQuantity, 0, ',', '.') }}
                    </td>
                    <td width="25%" style="text-align: right;"><strong>Desconto Quantidade:</strong></td>
                    <td width="17%" style="text-align: left;" >
                        % {{ number_format($sale->perc_desconto_1, 2, ',', '.') }}
                    </td>
                    <td width="20%" style="text-align: right;"><strong>Desconto a vista :</strong></td>
                    <td width="17%" style="text-align: left;" >
                        % {{ number_format($sale->perc_desconto_2, 2, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;"><strong>itens:</strong></td>
                    <td style="text-align: left;" >
                        {{ $totalItem }}
                    </td>
                    <td style="text-align: right;"><strong>Valor Bruto:</strong></td>
                    <td style="text-align: left;" >
                        R$ {{ number_format($totalGrossAmount, 2, ',', '.') }}
                    </td>

                    <td style="text-align: right;"><strong>Valor Líquido:</strong></td>
                    <td style="text-align: left;" >
                        R$ {{ number_format($totalNetAmount, 2, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="ListaTotal"  class="no-border" width="100%">
            <tr class="simples">
                <td class="tdc">&nbsp;</td>
            </tr>
            <tr class="simples">
                <td class="tdc">ASSINATURA: __________________________________________________________________________________________</td>
            </tr>
            <tr class="simples">
                <td class="tdc">&nbsp;</td>
            </tr>
            <tr class="simples">
                <td class="tdc">SUJEITO A APROVACAO DE CRÉDITO</td>
            </tr>
            <tr class="simples">
                <td class="tdc">CANCELAMENTO E/OU ALTERAÇÃO DE PEDIDO SOMENTE ATÉ 3 DIAS APÓS O TERMINO DA FEIRA</td>
            </tr>
            <tr class="simples">
                <td class="tdc">FATURAMENTO COM PRAZO MÍNIMO DE 15 DIAS APÓS O TERMINO DA FEIRA</td>
            </tr>
        </table>

    </div>
    <div class="footer">
        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $size = 10;
                    $pageText = "Página " . $PAGE_NUM . " de " . $PAGE_COUNT;
                    $y = 570;
                    $x = 540;
                    $pdf->text($x, $y, $pageText, $font, $size);
                ');
            }
        </script>
    </div>
</body>
</html>
