<?php

namespace App\Utils;

class DiscountHelper
{
    public static function calcularValorLiquido($itemData, $headerDiscount1, $headerDiscount2)
    {
        // Verificar se os descontos são maiores que 0
        $headerDiscount1 = (float)$headerDiscount1;
        $headerDiscount2 = (float)$headerDiscount2;
        if ($headerDiscount1 > 0 || $headerDiscount2 > 0 || (float)$itemData['discount_percentage'] > 0) {
            $unitary_price = (float)$itemData['unitary_price'];
            // Aplicar desconto do item
            $itemDiscountPercentage = (float)$itemData['discount_percentage']; // desconto do item em %
            if ($itemDiscountPercentage > 0) {
                $itemDiscountAmount = ($unitary_price * $itemDiscountPercentage) / 100;
                $unitary_price = $unitary_price - $itemDiscountAmount;
                $unitary_price = round($unitary_price, 2);
            }

            // Aplicar o primeiro desconto do cabeçalho da venda
            if ($headerDiscount1 > 0) {
                $headerDiscountAmount1 = ($unitary_price * $headerDiscount1) / 100;
                $unitary_price = $unitary_price - $headerDiscountAmount1;
                $unitary_price = round($unitary_price, 2);
            }

            // Aplicar o segundo desconto do cabeçalho da venda
            if ($headerDiscount2 > 0) {
                $headerDiscountAmount2 = ($unitary_price * $headerDiscount2) / 100;
                $unitary_price = $unitary_price - $headerDiscountAmount2;
                $unitary_price = round($unitary_price, 2);
            }

            return number_format($unitary_price, 3, '.', '');
        } else {
            // Nenhum desconto a ser aplicado, retorna o valor bruto
            return number_format((float)$itemData['unitary_price'], 3, '.', '');
        }
    }
}
