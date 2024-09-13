<?php

function Gera_WebService($array) {
    $http_origin = $_SERVER['HTTP_ORIGIN'];
    header("Access-Control-Allow-Headers: Content-Type,*");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Origin: $http_origin");
    header("Connection: keep-alive");
    header("Content-Security-Policy: default-src 'self';base-uri 'self';font-src 'self' https: data:;form-action 'self';frame-ancestors 'self';img-src 'self' data:;object-src 'none';script-src 'self';script-src-attr 'none';style-src 'self' https: 'unsafe-inline';upgrade-insecure-requests");
    header('X-Permitted-Cross-Domain-Policies: none');
    header('X-Xss-Protection: 0');
    header('Content-type: application/json');

    $array = utf8_encode_recursive($array);
    $obj = json_encode($array);
    if (json_last_error() == 0) {
        echo $obj;
    } else {
        $erro = 'Erro! :';
        switch (json_last_error()) {
            case JSON_ERROR_DEPTH: $erro .= ' - profundidade maxima excedida';
                break;
            case JSON_ERROR_STATE_MISMATCH: $erro .= ' - state mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR: $erro .= ' - Caracter de controle encontrado';
                break;
            case JSON_ERROR_SYNTAX: $erro .= ' - Erro de sintaxe! String JSON mal-formada!';
                break;
            case JSON_ERROR_UTF8: $erro .= ' - Erro na codificacao UTF-8';
                break;
            default: $erro .= ' ï¿½?? Erro desconhecido';
                break;
        }
        echo $erro;
    }
}

function utf8_encode_recursive($array) {
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result[$key] = utf8_encode_recursive($value);
        } else if (is_string($value)) {
            $result[$key] = utf8_encode($value);
        } else {
            $result[$key] = $value;
        }
    }
    return $result;
}

empty($_REQUEST["fn"]) ? $fn = "" : $fn = strtolower($_REQUEST["fn"]);
empty($_REQUEST["sql"]) ? $sql = "" : $sql = strtolower($_REQUEST["sql"]);

//current_date-15

$data = " '" . date("d/m/Y", mktime(0, 0, 0, date("m"), date("d") - 15, date("Y"))) . "'";
$fn = str_replace("current_date-15", $data, $fn);

$dir = dirname(__FILE__);
$dir = str_replace(array("\\", "/"), "|", $dir);
$array = explode('|', $dir);
array_pop($array);
$dir = strtolower(end($array));

switch ($dir) {
    case 'bumi':
        $usuario = "trovata";
        $senha = "trovata";
        $base = "201.49.73.49/3050:/var/data/BUMI.FDB";
        break;
    case 'cityblue':
    case 'cityblue-teste':
        $usuario = "SYSDBA";
        $senha = "masterkey";
        $base = "201.76.9.101/3050:C:\TI\CITYBLUE.FDB";
        break;

    case 'confiedistribuidora':
        $usuario	= 	"SYSDBA";
        $senha		= 	"masterkey";
        $base		=	"confiemais2017.ddns.net/3050:D:\ONCLICK\ARQUIVOS\ONCLICK.GDB";
        break;

    case 'belles':
        $usuario	= 	"SYSDBA";
        $senha		= 	"masterkey";
        $base		=	"189.90.118.120/3050:C:\ProData\Dados\indsis.fdb";
        break;
    

    case 'puket':
    case 'puket2':
    case 'puket-teste':
    case 'brilliance':
    case 'brilliance-teste':
        include "../../conexao_banco.php";
        $base		=	"localhost/". $porta ."/home/sfa/databases/".$dir."/base.fdb";
        break;

    default:
        echo "Erro não configurado!=>".$dir;
        $usuario = "";
        $senha = "xxx";
        $base = "xxxx";
        break;
}

if (($fn > '' or $sql> '') and ($usuario > '')) {
    $arrayRetorno = array();
    
    try {
        $conecta_ext = @ibase_connect($base,$usuario,$senha);
        
        if (!$conecta_ext) {
            throw new Exception("Falha ao conectar na base de dados!");
        }
  
        if ($fn == 'vws_blink_produtos') {
            $sql = "
                select p.*, unid_varejo||'-'||cast(quantidade_embalagem as integer) as unidade 
                from vws_blink_produtos p where inativo = 'F'";
        } elseif ($fn == 'vws_blink_tabpreco') {
            $sql = '
                SELECT 
                    PK_TABPRECO, PK_CODPRODUTO, DTINICIOPROMO, DTFIMPROMO, PRECO, PRECOPROMOCAO, 
                    IIF(CURRENT_DATE BETWEEN DTINICIOPROMO AND DTFIMPROMO, PRECOPROMOCAO, PRECO) AS PRECO_2 
                FROM vws_blink_tabpreco';
        } elseif ($fn == 'seller') {
            $sql = '
                select
                pessoa as seller , cpf_cnpj , RAZAO_SOCIAL as corporate_name , NOME_FANTASIA as nickname ,e_mail as email , telefone as phone   , cidade
            from vendedor where empresa=1
            ';
        } elseif ($fn == 'customer') {
            $sql = 'select
            cliente.pessoa AS customer,
            cliente.cpf_cnpj,
            cliente.RAZAO_SOCIAL AS corporate_name,
            cliente.NOME_FANTASIA AS nickname,
            cliente.e_mail AS email,
            cliente.telefone AS phone,
            cliente.cidade,
            CASE
                WHEN (
                    SELECT COUNT(*)

                    FROM titulo_financeiro
                    WHERE titulo_financeiro.empresa = 1
                    AND titulo_financeiro.pessoa = cliente.pessoa
                    AND titulo_financeiro.data_vencimento < CURRENT_DATE
                ) > 0 THEN \'T\'
                ELSE \'F\'
            END AS expired_financial_title
        FROM
            cliente
        WHERE empresa=1
            ';
        } elseif ($fn == 'carriers') {
            $sql = '
                select
                pessoa as carrier , cpf_cnpj , RAZAO_SOCIAL as corporate_name , NOME_FANTASIA as nickname ,e_mail as email , telefone as phone   , cidade
            from transportador   where empresa=1
            ';
        } elseif ($fn == 'payment_term' or $fn == 'paymentterm'  ) {
            $sql = '
                select
                    prazo.prazo as payment_term , prazo.descricao_prazo as payment_term_description  
                from prazo where prazo.empresa=1  
                and exists(
                    select 1 from tipo_venda_prazo
                     where tipo_venda_prazo.empresa = prazo.empresa  
                       and tipo_venda_prazo.prazo = prazo.prazo
                )
            ';
        } elseif ($fn == 'payment_term2' or $fn == 'paymentterm2'  ) {
            $sql = '
                select
                    prazo.prazo as payment_term , prazo.descricao_prazo as payment_term_description , prazo.prazo_medio as payment_term_medium 
                from prazo where prazo.empresa=1  
                and exists(
                    select 1 from tipo_venda_prazo
                     where tipo_venda_prazo.empresa = prazo.empresa  
                       and tipo_venda_prazo.prazo = prazo.prazo
                )
            ';
        } elseif ($fn == 'price_table' or $fn == 'pricetable' ) {
            $sql = '
                select
                      tabela_preco.tabela_preco as price_table 
                    , tabela_preco.tabela_preco_ext as price_table_code 
                    ,  tabela_preco.descricao_tabela_preco as price_table_description 
                from tabela_preco  
                where tabela_preco.empresa=1
                and exists(
                        select 1 from tipo_venda_tabela_preco
                        where tipo_venda_tabela_preco.empresa = tabela_preco.empresa  
                            and tipo_venda_tabela_preco.tabela_preco = tabela_preco.tabela_preco
                    )
            ';
        } elseif ($fn == 'price_table_product' or $fn == 'pricetableproduct') {
            $sql = '
                select tabela_preco as price_table , produto as product , preco as price 
                from item_tabela_preco  where empresa=1
            ';
        } elseif ($fn == 'type_sale' or $fn == 'typesale' ) {
            $sql = '
                select
                tipo_venda as type_sale, descricao_tipo_venda as type_sale_description
            from tipo_venda   where empresa=1
            ';
        } elseif ($fn == 'color') {
            $sql = '
                select
                complemento_1 as color , descricao_complemento_1 as color_description 
            from complemento_1   where empresa=1
            ';
        } elseif ($fn == 'size') {
            $sql = '
                select
                complemento_2 as size , descricao_complemento_2 as size_description 
            from complemento_2   where empresa=1
            ';
        } elseif ($fn == 'stock') {
            $sql = '
                select produto as product, complemento_1 as color,complemento_2 as size, reserva_online as reserved_amount,
                saldo_final as original_amount, data_base_saldo_estoque
                from sp_saldo_estoque_aux(1)
            ';
        } elseif ($fn == 'brand') {
            $sql = '
                select colecao as brand , DESCRICAO_colecao as brand_description 
                from colecao where empresa=1
            ';
        } elseif ($fn == 'sale_delivery_periods') {
            $sql = '
                select  
                periodo_entrega_venda as sale_delivery_period,
                descricao_periodo as description_period,
                DATA_INICIAL as initial_date,
                DATA_FINAL as final_date,
                DATA_ALTERACAO as date_change,
                DATA_REFERENCIA as data_reference
                from periodo_entrega_venda
                where empresa=1
                and coalesce(periodo_entrega_venda.periodo, 1) > 0 
                ';
        } elseif ($fn == 'asset') {
            $sql = "
            SELECT 
                    cr.md5_arquivo as md5
                , cr.nome_arquivo as   filename
                , SUBSTRING(cr.nome_arquivo FROM POSITION('.' IN cr.nome_arquivo) + 1)as filetype 
                , p.produto as product 
                , cr.complemento_1 as color
            FROM 
                produto p
            INNER JOIN 
                (
                    SELECT 
                        cr.empresa,
                        cr.produto,
                        cr.md5_arquivo,
                        cr.nome_arquivo,
                        cr.complemento_1,
                        ROW_NUMBER() OVER (PARTITION BY cr.produto ORDER BY cr.recurso_principal_produto ASC) AS rn
                    FROM 
                        catalogo_recurso cr
                    WHERE 
                        cr.empresa = 1 
                        AND cr.tipo_recurso = 'image'     
                ) cr ON p.empresa = cr.empresa AND p.produto = cr.produto
            WHERE 
                cr.rn = 1; 
            ";
        } elseif ($fn == 'asset2') {
            $sql = "
            SELECT 
                    cr.md5_arquivo as md5
                , cr.nome_arquivo as   filename
                , SUBSTRING(cr.nome_arquivo FROM POSITION('.' IN cr.nome_arquivo) + 1)as filetype 
                , p.produto as product 
                , cr.complemento_1 as color
                , cr.catalogo_recurso  as asset
            FROM 
                produto p
            INNER JOIN 
                (
                    SELECT 
                        cr.empresa,
                        cr.produto,
                        cr.md5_arquivo,
                        cr.nome_arquivo,
                        cr.complemento_1,
                        cr.catalogo_recurso,
                        ROW_NUMBER() OVER (PARTITION BY cr.produto ORDER BY cr.recurso_principal_produto ASC) AS rn
                    FROM 
                        catalogo_recurso cr
                    WHERE 
                        cr.empresa = 1 
                        AND cr.tipo_recurso = 'image'     
                ) cr ON p.empresa = cr.empresa AND p.produto = cr.produto
            WHERE 
                cr.rn = 1; 
            ";
        } elseif ($fn == 'arquivo2') {
            $diretorio_download = str_replace("public_html", "__download__", dirname(__FILE__)) . "/";
            $diretorio_download = str_replace("\\", "/", $diretorio_download);
            $diretorio_download = str_replace('/download', '', $diretorio_download); //estou na pasta download
            $diretorio_download = str_replace('/__download__', '/download', $diretorio_download); //voltar a pasta

            $diretorio_download_catalogo = $diretorio_download . "catalogo/1/";
            empty($_REQUEST["nome_arquivo"]) ? $nome_arquivo = "" : $nome_arquivo = strtolower($_REQUEST["nome_arquivo"]);
            $arquivo_path_completo = $diretorio_download_catalogo . $nome_arquivo;

            if (!is_file("$arquivo_path_completo")) {
                echo "Arquivo nï¿½o encontrado !!! $arquivo_path_completo ";
                exit;
            }

            header('Content-Description: File Transfer');
            $p        = explode('.', $nome_arquivo);
            $fim      = end($p);
            $extensao = strtolower($fim);
            $http_origin = $_SERVER['HTTP_ORIGIN'];
            header("Access-Control-Allow-Headers: Content-Type,*");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Allow-Origin: $http_origin");
            header("Connection: keep-alive");
            header("Content-Security-Policy: default-src 'self';base-uri 'self';font-src 'self' https: data:;form-action 'self';frame-ancestors 'self';img-src 'self' data:;object-src 'none';script-src 'self';script-src-attr 'none';style-src 'self' https: 'unsafe-inline';upgrade-insecure-requests");
            header('X-Permitted-Cross-Domain-Policies: none');
            header('X-Xss-Protection: 0');
            header('Content-Type: image/' . $extensao);
            header('Content-Disposition: inline; filename=' . basename($nome_arquivo));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($arquivo_path_completo));
            ob_clean();
            flush();
            echo file_get_contents($arquivo_path_completo);

            exit;
        } elseif ($fn == 'arquivo') {
            $diretorio_download = str_replace("public_html", "__download__", dirname(__FILE__)) . "/";
            $diretorio_download = str_replace("\\", "/", $diretorio_download);
            $diretorio_download = str_replace('/download', '', $diretorio_download); //estou na pasta download
            $diretorio_download = str_replace('/__download__', '/download', $diretorio_download); //voltar a pasta

            $diretorio_download_catalogo = $diretorio_download . "catalogo/1/";
            empty($_REQUEST["nome_arquivo"]) ? $nome_arquivo = "" : $nome_arquivo = strtolower($_REQUEST["nome_arquivo"]);
            $arquivo_path_completo = $diretorio_download_catalogo . $nome_arquivo;

            if (!is_file("$arquivo_path_completo")) {
                echo "Arquivo nï¿½o encontrado !!! $arquivo_path_completo ";
                exit;
            }
            $http_origin = $_SERVER['HTTP_ORIGIN'];
            header("Access-Control-Allow-Headers: Content-Type,*");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Allow-Origin: $http_origin");
            header("Connection: keep-alive");
            header("Content-Security-Policy: default-src 'self';base-uri 'self';font-src 'self' https: data:;form-action 'self';frame-ancestors 'self';img-src 'self' data:;object-src 'none';script-src 'self';script-src-attr 'none';style-src 'self' https: 'unsafe-inline';upgrade-insecure-requests");
            header('X-Permitted-Cross-Domain-Policies: none');
            header('X-Xss-Protection: 0');
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($arquivo_path_completo).'"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($arquivo_path_completo));
            ob_clean();
            flush();
            readfile($arquivo_path_completo);

            exit;
        } elseif ($fn == 'business_rules_item') {
            $sql = '
            select 
            regra_desc_adicional.produto
            , regra_desc_adicional.complemento_1
            , regra_desc_adicional.lista_desconto
            , (select  min(cast(osplit as integer )) from   p_split(regra_desc_adicional.lista_desconto,\';\')) as minimum_discount_percentage
            , (select  max(cast(osplit as integer )) from   p_split(regra_desc_adicional.lista_desconto,\';\')) as maximum_discount_percentage
            , regra_desc_adicional.tipo_perc_desconto
            , regra_desc_adicional.faixa_valor_venda
            , regra_desc_adicional.faixa_quantidade_venda
            , regra_desc_adicional_tab_preco.tabela_preco
            from regra_desc_adicional
            inner join regra_desc_adicional_tab_preco on (
            regra_desc_adicional.empresa = regra_desc_adicional_tab_preco.empresa
            and regra_desc_adicional.regra_desc_adicional = regra_desc_adicional_tab_preco.regra_desc_adicional
            )
            where regra_desc_adicional.empresa=1
            ';
        } elseif ($fn == 'product_discount_rule') {
            $sql = '
            select 
            regra_desc_adicional.produto as product
            , regra_desc_adicional.complemento_1 as color
            , (select  min(cast(osplit as integer )) from   p_split(regra_desc_adicional.lista_desconto,\';\')) as minimum_discount_percentage
            , (select  max(cast(osplit as integer )) from   p_split(regra_desc_adicional.lista_desconto,\';\')) as maximum_discount_percentage
            , regra_desc_adicional.tipo_perc_desconto as discount_perc_type
            , regra_desc_adicional.faixa_valor_venda as range_sale_value
            , regra_desc_adicional.faixa_quantidade_venda as range_sale_quantity 
            , regra_desc_adicional_tab_preco.tabela_preco  as price_table
            from regra_desc_adicional
            inner join regra_desc_adicional_tab_preco on (
            regra_desc_adicional.empresa = regra_desc_adicional_tab_preco.empresa
            and regra_desc_adicional.regra_desc_adicional = regra_desc_adicional_tab_preco.regra_desc_adicional
            )
            where regra_desc_adicional.empresa=1
            ';
        } elseif ($fn == 'discount_rule') {
            $sql = "select 
                          regra_desconto.regra_desconto as discount_rule
                        , regra_desconto.descricao_regra_desconto as discount_rule_description 
                        , (select  min(cast(osplit as integer )) from   p_split(regra_desconto.LISTA_DESC_4,';')) as minimum_discount_percentage
                        , (select  max(cast(osplit as integer )) from   p_split(regra_desconto.LISTA_DESC_4,';')) as maximum_discount_percentage
                        , regra_desconto.faixa_valor_venda as range_sale_value
                        , regra_desconto.faixa_quantidade_venda as range_sale_quantity
                        , REGRA_DESCONTO_TAB_PRECO.TABELA_PRECO as price_table
                        , REGRA_DESCONTO_TIPO_VENDA.TIPO_VENDA as type_sale
                    from regra_desconto
                    inner join REGRA_DESCONTO_TAB_PRECO on (
                            regra_desconto.empresa = REGRA_DESCONTO_TAB_PRECO.empresa
                        and regra_desconto.regra_desconto = REGRA_DESCONTO_TAB_PRECO.regra_desconto
                    )
                    inner join REGRA_DESCONTO_TIPO_VENDA on (
                            regra_desconto.empresa = REGRA_DESCONTO_TIPO_VENDA.empresa
                        and regra_desconto.regra_desconto = REGRA_DESCONTO_TIPO_VENDA.regra_desconto
                    )
                    where regra_desconto.empresa=1  
                    and LISTA_DESC_4 is not null";
        } elseif ($fn == 'payment_term_medium') {
            $sql = "select 
                    prazo_medio.prazo_medio as  payment_term_medium 
                    , 0 as minimum_discount_percentage
                    , prazo_medio.perc_desconto as maximum_discount_percentage
                from prazo_medio
                where empresa=1";
        }
        elseif ($fn == 'product') {
            $sql = "
                select produto.produto as product 
                    , produto.descricao_produto as product_description 
                    , produto.apelido_produto as product_code 
                    , produto_complemento.complemento_1 as color
                    , produto_complemento.complemento_2 as size 
                    , PRODUTO_COMERCIAL.LISTA_MULTIPLO_VENDA as list_multiples
                    , produto_complemento.codigo_barras as bar_code
                    , produto.colecao as brand 
                    , null as type_sale
                from produto
                inner join produto_complemento on (
                    produto.empresa = produto_complemento.empresa
                and produto.produto = produto_complemento.produto
                ) 
                inner join PRODUTO_COMERCIAL on (
                    produto.empresa = PRODUTO_COMERCIAL.empresa
                and produto.produto = PRODUTO_COMERCIAL.produto 
                )
                where produto.empresa=1
            ";
        }
        elseif ($fn == 'user') {
            $sql = "
                select 
                    usuario.usuario AS username , 
                    (select first 1 p_senha from P_DESCRIPTOGRAFIA(   usuario.senha)) as password  
                    ,usuario_empresa.edita_perc_DESCONTO_ITEM_VENDA AS edit_perc_discount_item_sale
                    , usuario_empresa.edita_perc_DESCONTO_104 AS edit_perc_discount
                from usuario
                inner join usuario_empresa on ( usuario.usuario = usuario_empresa.usuario)
                where  usuario_empresa.empresa=1
                and usuario.situacao='A' and usuario.tipo_usuario <> 'C'
            ";
        }
        elseif ($fn == 'user2') {
            $sql = 'select 
            usuario.usuario AS name , 
            usuario.E_MAIL AS 	email , 
            (select first 1 p_senha from P_DESCRIPTOGRAFIA(   usuario.senha)) as password  
            ,usuario_empresa.edita_perc_DESCONTO_ITEM_VENDA AS edit_perc_discount_item_sale
            , usuario_empresa.edita_perc_DESCONTO_104 AS edit_perc_discount
        from usuario
        inner join usuario_empresa on ( usuario.usuario = usuario_empresa.usuario)
        where  usuario_empresa.empresa=1
        and usuario.situacao=\'A\' and usuario.tipo_usuario <> \'C\'  ';
        }else {
            if(!empty($fn)){
                $sql = "select * from ".$fn;
            }
        }

        $result = @ibase_query($conecta_ext, $sql);
        
        if (!$result) {
            @ibase_close($conecta_ext);
            throw new Exception("Falha ao executar a query!".$sql);
        }
        
        $int = 0;
        $arrayItem = array();
        while ($row = @ibase_fetch_assoc($result)) {
            //foreach ($row as $i => $value) { $arrayRetorno[$int][$i]=$value; }
            $row = (array) $row;
            $row = array_change_key_case($row, CASE_LOWER);
            $arrayItem[]=$row;
            $int ++;
        }
        
        @ibase_close($conecta_ext);
        $arrayRetorno['code'] = 200;
        $arrayRetorno['data'] = $arrayItem;
    } catch (Exception $ex) {
        $arrayRetorno[0] = "ERROR_DB";
        $arrayRetorno[1] = $ex->getMessage();
    }
    
    Gera_WebService($arrayRetorno);
    unset($arrayRetorno);
}

?>