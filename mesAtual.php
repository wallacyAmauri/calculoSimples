<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>calculo do simples</title>
</head>
<body>
    <form method="POST">
        <label for="RBT12">RBT12:</label>
        <input type="text" name="RBT12" id="RBT12">

        <label for="RTM">RTM:</label>
        <input type="text" name="RTM" id="RTM">

        <label for="nota_sem">nota sem ISS:</label>
        <input type="text" name="nota_sem" id="nota_sem">

        <label for="nota_com">nota com ISS:</label>
        <input type="text" name="nota_com" id="nota_com">

        <label for="ALIQ">aliquota:</label>
        <input type="text" name="ALIQ" id="ALIQ">

        <label for="PD">oarcela a deduzir:</label>
        <input type="text" name="PD" id="PD">

        <label for="ANX">Anexo:</label>
        <input type="text" name="ANX" id="ANX">

        <button type="submit">Enviar</button>
        <br>
        <br>
    </form>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $RBT12_input = $_POST["RBT12"];
            $RTM_input = $_POST["RTM"];
            $nota_sem_input = $_POST["nota_sem"];
            $nota_com_input = $_POST["nota_com"];
            $ALIQ_input = $_POST["ALIQ"];
            $PD_input = $_POST["PD"];
            $ANX_input = $_POST["ANX"];
            // $RBT12_input = $_POST["RBT12"];
            // $RBT12_input = $_POST["RBT12"];
            
        }
?>
<?php


    // [(RBT12 x ALIQ) – PD] / RBT12
    // RBT12 =  receita bruta total dos ultimos 12 meses
    // ALIQ = aliquota
    // FX = faixa
    // ANX = anexo
    // PD = parcela dedutível 


  echo "<i>dados com valores para o calculo sera</i>:<br><br>";
    
    //receita bruta total dos ultimos 12 meses do calculo do simples
    $RBT12 = $RBT12_input;
    echo "<b>receita bruta total dos ultimos 12 meses</b>: " . number_format($RBT12, 2, ",", "."). "<br>";
    
    //valor gasto no mes
    $RTM = $RTM_input;
    echo "<b>receita mensal a calcular</b>: " . number_format($RTM, 2, ",", "."). "<br>";

    //nota emitida sem reteção
    $nota_sem = $nota_sem_input;
    echo "<b>nota sem retenção</b>: " . number_format($nota_sem, 2, ",", "."). "<br>";

    //nota emitida com reteção
    $nota_com = $nota_com_input;
    echo "<b>nota com retenção</b>: " . number_format($nota_com, 2, ",", "."). "<br>";

    //aliquota da fai
    $ALIQ  = $ALIQ_input;
    echo "<b>aliquota</b>: $ALIQ <br>";

    //parcela dedutível da faixa
    $PD    = $PD_input;
    echo "<b>parcela a deduzir</b>: ". number_format($PD, 2, ",", "."). "<br>";

    //Anexo que tras onde esta a faixa 
    $ANX   = $ANX_input;
    echo "<b>anexo</b>: $ANX <br><br>";
    
    //fazendo o calculo
    if( $RBT12 <= 180000){
        switch ($ANX) {
            case 1:
                echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.055;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1274;
                        $Recebe_PIS = 0.0276;
                        $Recebe_CPP = 0.415;
                        $Recebe_ICMS = 0.34;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $resultado_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($resultado_ICMS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_ICMS;
                        echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";
                        
                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $resultado_ICMS;
                        echo "<b>valor total de recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                
                                
                                $calculo_nota_sem = $nota_sem * $total ;
                                // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                
                                
                                $multiplicar_aliquota = $total *100;
                                //echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                // echo "(tem que da o valor da aliquota efetiva)";
                                
                                $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                //echo "Somatorio Impostos(menos o ISS):" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                
                                $calculo_nota_com = $nota_com * $total;
                                echo "valor da nota que estar retida:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                               
                                $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
        
                                $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                echo "valor da soma das notas:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                
                                $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                echo "valor da subtração das notas:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                
                                $total_notas = $subtracao_notas + $soma_notas; 
                                echo "valor total das notas somadas:". number_format($total_notas, 2, ",", "."). "<br><br>";
        
        
                            }
                            }
                    }

                break;
            case 2:
             echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.055;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1151;
                        $Recebe_PIS = 0.0249;
                        $Recebe_CPP = 0.375;
                        $Recebe_IPI = 0.075;
                        $Recebe_ICMS = 0.32;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_IPI'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_IPI, 4, ",", "."). "<br>";

                            $resultado_IPI = $total * 100 * $Recebe_IPI;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_IPI, 9, ",", "."). "<br><br>";

                            $calculo_IPI = $RTM * $resultado_IPI /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_IPI, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $calculo_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_ICMS, 2, ",", "."). "<br><br>";

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_IPI + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";

                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_IPI + $resultado_ICMS;
                         echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $calculo_IPI + $calculo_ICMS;
                        echo "valor total a recolher:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                    }

                            
                            }

                break;
            case 3:
             echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.04;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1282;
                        $Recebe_PIS = 0.0278;
                        $Recebe_CPP = 0.434;
                        $Recebe_ISS = 0.335;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            case 4:
               echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.188;
                        $Recebe_CSLL = 0.152;
                        $Recebe_CONFINS = 0.1767;
                        $Recebe_PIS = 0.0382;
                        $Recebe_ISS = 0.445;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }

                break;
            case 5:
           echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.25;
                        $Recebe_CSLL = 0.15;
                        $Recebe_CONFINS = 0.141;
                        $Recebe_PIS = 0.0305;
                        $Recebe_CPP = 0.2885;
                        $Recebe_ISS = 0.14;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            
            default:
                echo "dados incorretos";
                break;
        }
    } 
    if($RBT12  >  180000  && $RBT12 <= 360000){
        switch ($ANX) {
            case 1:
             echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.055;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1247;
                        $Recebe_PIS = 0.0276;
                        $Recebe_CPP = 0.415;
                        $Recebe_ICMS = 0.34;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $resultado_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($resultado_ICMS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_ICMS;
                        echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";
                        
                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $resultado_ICMS;
                        echo "<b>valor total de recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                
                                
                                $calculo_nota_sem = $nota_sem * $total ;
                                // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                
                                
                                $multiplicar_aliquota = $total *100;
                                //echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                // echo "(tem que da o valor da aliquota efetiva)";
                                
                                $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                //echo "Somatorio Impostos(menos o ISS):" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                
                                $calculo_nota_com = $nota_com * $total;
                                echo "valor da nota que estar retida:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                               
                                $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
        
                                $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                echo "valor da soma das notas:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                
                                $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                echo "valor da subtração das notas:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                
                                $total_notas = $subtracao_notas + $soma_notas; 
                                echo "valor total das notas somadas:". number_format($total_notas, 2, ",", "."). "<br><br>";
        
        
                            }
                            }
                    }


                break;
            case 2:
                echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.055;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1151;
                        $Recebe_PIS = 0.0249;
                        $Recebe_CPP = 0.375;
                        $Recebe_IPI = 0.075;
                        $Recebe_ICMS = 0.32;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_IPI'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_IPI, 4, ",", "."). "<br>";

                            $resultado_IPI = $total * 100 * $Recebe_IPI;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_IPI, 9, ",", "."). "<br><br>";

                            $calculo_IPI = $RTM * $resultado_IPI /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_IPI, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $calculo_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_ICMS, 2, ",", "."). "<br><br>";

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_IPI + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";

                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_IPI + $resultado_ICMS;
                         echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $calculo_IPI + $calculo_ICMS;
                        echo "valor total a recolher:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                    }

                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "valor da nota que estar retida:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "valor da soma das notas:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "valor da subtração das notas:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "valor total das notas somadas:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }


                break;
            case 3:
             echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.04;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1405;
                        $Recebe_PIS = 0.0305;
                        $Recebe_CPP = 0.434;
                        $Recebe_ISS = 0.32;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }

        

                break;
            case 4:
            echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.198;
                        $Recebe_CSLL = 0.152;
                        $Recebe_CONFINS = 0.2055;
                        $Recebe_PIS = 0.0445;
                        $Recebe_ISS = 0.4;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }

                break;
            case 5:
                echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.23;
                        $Recebe_CSLL = 0.15;
                        $Recebe_CONFINS = 0.141;
                        $Recebe_PIS = 0.0305;
                        $Recebe_CPP = 0.2785;
                        $Recebe_ISS = 0.17;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            
            default:
                echo "dados incorretos";
                break;
        }
    } 
    if( $RBT12 >  360000  && $RBT12 <= 720000){
        switch ($ANX) {
            case 1:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.055;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1274;
                        $Recebe_PIS = 0.0276;
                        $Recebe_CPP = 0.42;
                        $Recebe_ICMS = 0.335;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $resultado_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($resultado_ICMS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_ICMS;
                        echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";
                        
                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $resultado_ICMS;
                        echo "<b>valor total de recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                
                                
                                $calculo_nota_sem = $nota_sem * $total ;
                                // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                
                                
                                $multiplicar_aliquota = $total *100;
                                //echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                // echo "(tem que da o valor da aliquota efetiva)";
                                
                                $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                //echo "Somatorio Impostos(menos o ISS):" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                
                                $calculo_nota_com = $nota_com * $total;
                                echo "valor da nota que estar retida:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                               
                                $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
        
                                $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                echo "valor da soma das notas:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                
                                $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                echo "valor da subtração das notas:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                
                                $total_notas = $subtracao_notas + $soma_notas; 
                                echo "valor total das notas somadas:". number_format($total_notas, 2, ",", "."). "<br><br>";
        
        
                            }
                            }
                    }


                break;
            case 2:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.055;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1151;
                        $Recebe_PIS = 0.0249;
                        $Recebe_CPP = 0.375;
                        $Recebe_IPI = 0.075;
                        $Recebe_ICMS = 0.32;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_IPI'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_IPI, 4, ",", "."). "<br>";

                            $resultado_IPI = $total * 100 * $Recebe_IPI;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_IPI, 9, ",", "."). "<br><br>";

                            $calculo_IPI = $RTM * $resultado_IPI /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_IPI, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $calculo_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_ICMS, 2, ",", "."). "<br><br>";

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_IPI + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";

                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_IPI + $resultado_ICMS;
                         echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $calculo_IPI + $calculo_ICMS;
                        echo "valor total a recolher:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                    }

                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "valor da nota que estar retida:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "valor da soma das notas:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "valor da subtração das notas:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "valor total das notas somadas:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }


                break;
            case 3:
                echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.04;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1364;
                        $Recebe_PIS = 0.0296;
                        $Recebe_CPP = 0.434;
                        $Recebe_ISS = 0.325;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            case 4:
                echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.208;
                        $Recebe_CSLL = 0.152;
                        $Recebe_CONFINS = 0.1973;
                        $Recebe_PIS = 0.0427;
                        $Recebe_ISS = 0.4;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            case 5:
                echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.24;
                        $Recebe_CSLL = 0.15;
                        $Recebe_CONFINS = 0.1492;
                        $Recebe_PIS = 0.0323;
                        $Recebe_CPP = 0.2385;
                        $Recebe_ISS = 0.19;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            
            default:
                echo "dados incorretos";
                break;
        }
    } 
    if( $RBT12 >  720000  && $RBT12 <= 1800000){
        switch ($ANX) {
            case 1:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.055;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1274;
                        $Recebe_PIS = 0.0276;
                        $Recebe_CPP = 0.42;
                        $Recebe_ICMS = 0.335;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $resultado_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($resultado_ICMS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_ICMS;
                        echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";
                        
                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $resultado_ICMS;
                        echo "<b>valor total de recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                
                                
                                $calculo_nota_sem = $nota_sem * $total ;
                                // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                
                                
                                $multiplicar_aliquota = $total *100;
                                //echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                // echo "(tem que da o valor da aliquota efetiva)";
                                
                                $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                //echo "Somatorio Impostos(menos o ISS):" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                
                                $calculo_nota_com = $nota_com * $total;
                                echo "valor da nota que estar retida:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                               
                                $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
        
                                $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                echo "valor da soma das notas:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                
                                $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                echo "valor da subtração das notas:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                
                                $total_notas = $subtracao_notas + $soma_notas; 
                                echo "valor total das notas somadas:". number_format($total_notas, 2, ",", "."). "<br><br>";
        
        
                            }
                            }
                    }


                break;
            case 2:
              echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.055;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1151;
                        $Recebe_PIS = 0.0249;
                        $Recebe_CPP = 0.375;
                        $Recebe_IPI = 0.075;
                        $Recebe_ICMS = 0.32;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_IPI'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_IPI, 4, ",", "."). "<br>";

                            $resultado_IPI = $total * 100 * $Recebe_IPI;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_IPI, 9, ",", "."). "<br><br>";

                            $calculo_IPI = $RTM * $resultado_IPI /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_IPI, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $calculo_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_ICMS, 2, ",", "."). "<br><br>";

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_IPI + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";

                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_IPI + $resultado_ICMS;
                         echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $calculo_IPI + $calculo_ICMS;
                        echo "valor total a recolher:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                    }

                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "valor da nota que estar retida:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "valor da soma das notas:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "valor da subtração das notas:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "valor total das notas somadas:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }


                break;
            case 3:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.04;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1364;
                        $Recebe_PIS = 0.0296;
                        $Recebe_CPP = 0.434;
                        $Recebe_ISS = 0.325;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            case 4:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.178;
                        $Recebe_CSLL = 0.192;
                        $Recebe_CONFINS = 0.189;
                        $Recebe_PIS = 0.041;
                        $Recebe_ISS = 0.4;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            case 5:
                echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.21;
                        $Recebe_CSLL = 0.15;
                        $Recebe_CONFINS = 0.1574;
                        $Recebe_PIS = 0.0341;
                        $Recebe_CPP = 0.2385;
                        $Recebe_ISS = 0.21;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            
            default:
                echo "dados incorretos";
                break;
        }
    } 
    if( $RBT12 >  1800000 && $RBT12 <= 3600000){
        switch ($ANX) {
            case 1:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.055;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1274;
                        $Recebe_PIS = 0.0276;
                        $Recebe_CPP = 0.42;
                        $Recebe_ICMS = 0.335;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $resultado_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($resultado_ICMS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_ICMS;
                        echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";
                        
                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $resultado_ICMS;
                        echo "<b>valor total de recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                
                                
                                $calculo_nota_sem = $nota_sem * $total ;
                                // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                
                                
                                $multiplicar_aliquota = $total *100;
                                //echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                // echo "(tem que da o valor da aliquota efetiva)";
                                
                                $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                //echo "Somatorio Impostos(menos o ISS):" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                
                                $calculo_nota_com = $nota_com * $total;
                                echo "valor da nota que estar retida:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                               
                                $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
        
                                $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                echo "valor da soma das notas:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                
                                $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                echo "valor da subtração das notas:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                
                                $total_notas = $subtracao_notas + $soma_notas; 
                                echo "valor total das notas somadas:". number_format($total_notas, 2, ",", "."). "<br><br>";
        
        
                            }
                            }
                    }



                break;
            case 2:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.055;
                        $Recebe_CSLL = 0.035;
                        $Recebe_CONFINS = 0.1151;
                        $Recebe_PIS = 0.0249;
                        $Recebe_CPP = 0.375;
                        $Recebe_IPI = 0.075;
                        $Recebe_ICMS = 0.32;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_IPI'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_IPI, 4, ",", "."). "<br>";

                            $resultado_IPI = $total * 100 * $Recebe_IPI;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_IPI, 9, ",", "."). "<br><br>";

                            $calculo_IPI = $RTM * $resultado_IPI /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_IPI, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $calculo_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_ICMS, 2, ",", "."). "<br><br>";

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_IPI + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";

                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_IPI + $resultado_ICMS;
                         echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $calculo_IPI + $calculo_ICMS;
                        echo "valor total a recolher:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                    }

                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "valor da nota que estar retida:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "valor da soma das notas:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "valor da subtração das notas:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "valor total das notas somadas:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }


                break;
            case 3:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.23;
                        $Recebe_CSLL = 0.15;
                        $Recebe_CONFINS = 0.141;
                        $Recebe_PIS = 0.0305;
                        $Recebe_CPP = 0.2785;
                        $Recebe_ISS = 0.17;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            case 4:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.188;
                        $Recebe_CSLL = 0.192;
                        $Recebe_CONFINS = 0.1808;
                        $Recebe_PIS = 0.0392;
                        $Recebe_ISS = 0.4;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }

                break;
            case 5:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.23;
                        $Recebe_CSLL = 0.125;
                        $Recebe_CONFINS = 0.141;
                        $Recebe_PIS = 0.0305;
                        $Recebe_CPP = 0.2385;
                        $Recebe_ISS = 0.235;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            
            default:
                echo "dados incorretos";
                break;
        }
    } 
    if( $RBT12 >  3600000 && $RBT12 <= 4800000){
        switch ($ANX) {
            case 1:
                echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                   if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.135;
                        $Recebe_CSLL = 0.1;
                        $Recebe_CONFINS = 0.2827;
                        $Recebe_PIS = 0.0276;
                        $Recebe_CPP = 0.42;
                        $Recebe_ICMS = 0.335;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $resultado_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($resultado_ICMS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_ICMS;
                        echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";
                        
                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $resultado_ICMS;
                        echo "<b>valor total de recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                
                                
                                $calculo_nota_sem = $nota_sem * $total ;
                                // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                
                                
                                $multiplicar_aliquota = $total *100;
                                //echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                // echo "(tem que da o valor da aliquota efetiva)";
                                
                                $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                //echo "Somatorio Impostos(menos o ISS):" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                
                                $calculo_nota_com = $nota_com * $total;
                                echo "valor da nota que estar retida:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                               
                                $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
        
                                $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                echo "valor da soma das notas:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                
                                $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                echo "valor da subtração das notas:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                
                                $total_notas = $subtracao_notas + $soma_notas; 
                                echo "valor total das notas somadas:". number_format($total_notas, 2, ",", "."). "<br><br>";
        
        
                            }
                            }
                    }


                break;
            case 2:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.085;
                        $Recebe_CSLL = 0.075;
                        $Recebe_CONFINS = 0.2096;
                        $Recebe_PIS = 0.0454;
                        $Recebe_CPP = 0.235;
                        $Recebe_IPI = 0.35;
                        $Recebe_ICMS = 0;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CPP'])){

                            echo "<b>aliquota de repetição do CPP</b>:". number_format($Recebe_CPP, 4, ",", "."). "<br>";

                            $resultado_CPP = $total * 100 * $Recebe_CPP;
                            echo "<b>aliquota efetiva do imposto CPP</b>:". number_format($resultado_CPP, 9, ",", "."). "<br><br>";

                            $calculo_CPP = $RTM * $resultado_CPP /100 ;
                            echo "<b>valor do CPP</b>:". number_format($calculo_CPP, 2, ",", "."). "<br><br>";
                            
                        }
                        if(!empty(['$Recebe_IPI'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_IPI, 4, ",", "."). "<br>";

                            $resultado_IPI = $total * 100 * $Recebe_IPI;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_IPI, 9, ",", "."). "<br><br>";

                            $calculo_IPI = $RTM * $resultado_IPI /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_IPI, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ICMS'])){

                            echo "<b>aliquota de repetição do ICMS</b>:". number_format($Recebe_ICMS, 4, ",", "."). "<br>";

                            $resultado_ICMS = $total * 100 * $Recebe_ICMS;
                            echo "<b>aliquota efetiva do imposto ICMS</b>:". number_format($resultado_ICMS, 9, ",", "."). "<br><br>";

                            $calculo_ICMS = $RTM * $resultado_ICMS /100 ;
                            echo "<b>valor do ICMS</b>:". number_format($calculo_ICMS, 2, ",", "."). "<br><br>";

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_CPP + $Recebe_IPI + $Recebe_ICMS;
                            echo "<b>soma da repatição da aliquota</b>:". number_format($valores_recebidos, 0, ",", "."). "<br>";
                            echo "(tem que da 1)";

                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_CPP + $resultado_IPI + $resultado_ICMS;
                         echo "<b>soma da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";
                        echo "(tem que da o valor da aliquota efetiva)";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_CPP + $calculo_IPI + $calculo_ICMS;
                        echo "valor total a recolher:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                    }

                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "valor da nota que estar retida:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "valor da soma das notas:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "valor da subtração das notas:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "valor total das notas somadas:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }


                break;
            case 3:
                echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";

                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.35;
                        $Recebe_CSLL = 0.15;
                        $Recebe_CONFINS = 0.1603;
                        $Recebe_PIS = 0.0347;
                        $Recebe_CPP = 0.305;
                        $Recebe_ISS = 0;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            case 4:
                 echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.535;
                        $Recebe_CSLL = 0.215;
                        $Recebe_CONFINS = 0.2055;
                        $Recebe_PIS = 0.0445;
                        $Recebe_ISS = 0;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            case 5:
                echo "<i>calculo para achar a faixa, anexo e a aliquota efetiva:</i><br><br>"; 
                $Calculo_Aliquota_Efetiva =  (($RBT12 * $ALIQ) - $PD) / $RBT12;
                $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);

                if(!empty(['$total'])){
                    echo "<b>valor da aliquota efetiva</b>:". number_format($total, 4, ",", "."). "<br>";
                    $ALIQEfetiva = (float)$total * 100;
                    echo "<b>valor percentoal da aliquota efetiva</b>:". number_format($ALIQEfetiva, 2, ",", "."). "%<br>";
                    $Calculo_Aliquota_Total = $RTM * $total; 
                    echo "<b>qual valor total do calculo</b>:". number_format($Calculo_Aliquota_Total, 2, ",", "."). "<br><br>";


                    if(!empty(['$ALIQEfetiva'])){
                        $Recebe_IRPJ = 0.35;
                        $Recebe_CSLL = 0.155;
                        $Recebe_CONFINS = 0.1644;
                        $Recebe_PIS = 0.0356;
                        $Recebe_CPP = 0.295;
                        $Recebe_ISS = 0;
                        if(!empty(['$Recebe_IRPJ'])){

                            echo "<b>aliquota de repetição do IRPJ</b>:". number_format($Recebe_IRPJ, 4, ",", "."). "<br>";

                            $resultado_IRPJ = $total * 100 * $Recebe_IRPJ;
                            echo "<b>aliquota efetiva do imposto IRPJ</b>:". number_format($resultado_IRPJ, 9, ",", "."). "<br>";

                            $calculo_IRPJ = $RTM * $resultado_IRPJ /100 ;
                            echo "<b>valor do IRPJ</b>:". number_format($calculo_IRPJ, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_CSLL'])){

                            echo "<b>aliquota de repetição do CSLL</b>:". number_format($Recebe_CSLL, 4, ",", "."). "<br>";

                            $resultado_CSLL = $total * 100 * $Recebe_CSLL;
                            echo "<b>aliquota efetiva do imposto CSLL</b>:". number_format($resultado_CSLL, 9, ",", "."). "<br>";

                            $calculo_CSLL  = $RTM * $resultado_CSLL /100 ;
                            echo "<b>valor do CSLL</b>:". number_format($calculo_CSLL, 2, ",", "."). "<br><br>";
                        }
                        if(!empty(['$Recebe_CONFINS'])){

                            echo "<b>aliquota de repetição do CONFINS</b>:". number_format($Recebe_CONFINS, 4, ",", "."). "<br>";

                            $resultado_CONFINS = $total * 100 * $Recebe_CONFINS;
                            echo "<b>aliquota efetiva do imposto CONFINS</b>:". number_format($resultado_CONFINS, 9, ",", "."). "<br>";

                            $calculo_CONFINS = $RTM * $resultado_CONFINS /100 ;
                            echo "<b>valor do CONFINS</b>:". number_format($calculo_CONFINS, 2, ",", "."). "<br><br>";
                                                        
                        }
                        if(!empty(['$Recebe_PIS'])){

                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_PIS, 4, ",", "."). "<br>";

                            $resultado_PIS = $total * 100 * $Recebe_PIS;
                            echo "<b>aliquota efetiva do imposto PIS</b>:". number_format($resultado_PIS, 9, ",", "."). "<br><br>";

                            $calculo_PIS = $RTM * $resultado_PIS /100 ;
                            echo "<b>valor do PIS</b>:". number_format($calculo_PIS, 2, ",", "."). "<br><br>";

                        }
                        if(!empty(['$Recebe_ISS'])){

                            
                                
                            echo "<b>aliquota de repetição do PIS</b>:". number_format($Recebe_ISS, 4, ",", "."). "<br>";

                            $resultado_ISS = $total * 100 * $Recebe_ISS;
                            echo "<b>aliquota efetiva do imposto ISS</b>:". number_format($resultado_ISS, 9, ",", "."). "<br><br>";

                            $calculo_ISS = $RTM * $resultado_ISS /100 ;
                            echo "<b>valor do ISS</b>:". number_format($calculo_ISS, 2, ",", "."). "<br><br>";
                            

                        }

                        $valores_recebidos = $Recebe_IRPJ + $Recebe_CSLL + $Recebe_CONFINS +
                            $Recebe_PIS + $Recebe_ISS;
                            echo "<b>valor total da aliquota dos tributos</b>:". number_format($valores_recebidos, 0, ",", ".");
                            echo "(tem que dar igual a 1 para estar certo <br>";
                            
                        $valor_total_aliquota = $resultado_IRPJ + $resultado_CSLL +
                            $resultado_CONFINS + $resultado_PIS + $resultado_ISS;
                        echo "<b>valor total da aliquota</b>:". number_format($valor_total_aliquota, 2, ",", "."). "%<br>";

                        $valor_total_calculo = $calculo_IRPJ + $calculo_CSLL +
                        $calculo_CONFINS + $calculo_PIS + $calculo_ISS;
                        echo "<b>valor total a recolher</b>:". number_format($valor_total_calculo, 2, ",", "."). "<br><br>";
                            
                            if(!empty(['nota_com'])){
                                    
                                    
                                    $calculo_nota_sem = $nota_sem * $total ;
                                    // echo "valor da nota sem estar retida:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
                                    
                                    
                                    $multiplicar_aliquota = $total *100;
                                    // echo "valor da multiplicação:" . number_format($multiplicar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $juntar_aliquota = $multiplicar_aliquota * ($valores_recebidos - $Recebe_ISS);
                                    // echo "valor do calculo de juntar:" . number_format($juntar_aliquota, 6, ",", "."). "<br><br>";
                                    
                                    $calculo_nota_com = $nota_com * $total;
                                    echo "<b>valor da nota que estar retida</b>:". number_format($calculo_nota_com, 2, ",", "."). "<br><br>";
                                   
                                    $calculo_nota_sem = $nota_sem *($juntar_aliquota / 100) ;
                                    echo "<b>valor da nota sem estar retida</b>:". number_format($calculo_nota_sem, 2, ",", "."). "<br><br>";
            
                                    $soma_notas = $calculo_nota_com + $calculo_nota_sem; 
                                    echo "<b>valor da soma das notas</b>:". number_format($soma_notas, 2, ",", "."). "<br><br>";
                                    
                                    $subtracao_notas = $calculo_nota_com - $calculo_nota_sem; 
                                    echo "<b>valor da diferença das notas</b>:". number_format($subtracao_notas, 2, ",", "."). "<br><br>";
                                    
                                    $total_notas = $subtracao_notas + $soma_notas; 
                                    echo "<b>valor total das notas somadas</b>:". number_format($total_notas, 2, ",", "."). "<br><br>";
            
            
                                }
                            }
                    }


                break;
            
            default:
                echo "dados incorretos";
                break;
        }
    }
    else{
        echo "precisa preencher os campos";
    }
?>
 </body>
 </html>