<?php

class Convertidor 
{ 

    function Centenas($VCentena) 
    {
        $Numeros[0] = "cero";
        $Numeros[1] = "uno";
        $Numeros[2] = "dos";
        $Numeros[3] = "tres";
        $Numeros[4] = "cuatro";
        $Numeros[5] = "cinco";
        $Numeros[6] = "seis";
        $Numeros[7] = "siete";
        $Numeros[8] = "ocho";
        $Numeros[9] = "nueve";
        $Numeros[10] = "diez";
        $Numeros[11] = "once";
        $Numeros[12] = "doce";
        $Numeros[13] = "trece";
        $Numeros[14] = "catorce";
        $Numeros[15] = "quince";
        $Numeros[20] = "veinte";
        $Numeros[30] = "treinta";
        $Numeros[40] = "cuarenta";
        $Numeros[50] = "cincuenta";
        $Numeros[60] = "sesenta";
        $Numeros[70] = "setenta";
        $Numeros[80] = "ochenta";
        $Numeros[90] = "noventa";
        $Numeros[100] = "ciento";
        $Numeros[101] = "quinientos";
        $Numeros[102] = "setecientos";
        $Numeros[103] = "novecientos";
        If ($VCentena == 1) { return $Numeros[100]; }
        Else If ($VCentena == 5) { return $Numeros[101];}
        Else If ($VCentena == 7 ) {return ( $Numeros[102]); }
        Else If ($VCentena == 9) {return ($Numeros[103]);}
        Else {return $Numeros[$VCentena];}
    }

    function Unidades($VUnidad) 
    {
        $Numeros[0] = "cero";
        $Numeros[1] = "un";
        $Numeros[2] = "dos";
        $Numeros[3] = "tres";
        $Numeros[4] = "cuatro";
        $Numeros[5] = "cinco";
        $Numeros[6] = "seis";
        $Numeros[7] = "siete";
        $Numeros[8] = "ocho";
        $Numeros[9] = "nueve";
        $Numeros[10] = "diez";
        $Numeros[11] = "once";
        $Numeros[12] = "doce";
        $Numeros[13] = "trece";
        $Numeros[14] = "catorce";
        $Numeros[15] = "quince";
        $Numeros[20] = "veinte";
        $Numeros[30] = "treinta";
        $Numeros[40] = "cuarenta";
        $Numeros[50] = "cincuenta";
        $Numeros[60] = "sesenta";
        $Numeros[70] = "setenta";
        $Numeros[80] = "ochenta";
        $Numeros[90] = "noventa";
        $Numeros[100] = "ciento";
        $Numeros[101] = "quinientos";
        $Numeros[102] = "setecientos";
        $Numeros[103] = "novecientos";

        $tempo=$Numeros[$VUnidad];
        return $tempo;
    }

    function Decenas($VDecena) 
    {
        $Numeros[0] = "cero";
        $Numeros[1] = "uno";
        $Numeros[2] = "dos";
        $Numeros[3] = "tres";
        $Numeros[4] = "cuatro";
        $Numeros[5] = "cinco";
        $Numeros[6] = "seis";
        $Numeros[7] = "siete";
        $Numeros[8] = "ocho";
        $Numeros[9] = "nueve";
        $Numeros[10] = "diez";
        $Numeros[11] = "once";
        $Numeros[12] = "doce";
        $Numeros[13] = "trece";
        $Numeros[14] = "catorce";
        $Numeros[15] = "quince";
        $Numeros[20] = "veinte";
        $Numeros[30] = "treinta";
        $Numeros[40] = "cuarenta";
        $Numeros[50] = "cincuenta";
        $Numeros[60] = "sesenta";
        $Numeros[70] = "setenta";
        $Numeros[80] = "ochenta";
        $Numeros[90] = "noventa";
        $Numeros[100] = "ciento";
        $Numeros[101] = "quinientos";
        $Numeros[102] = "setecientos";
        $Numeros[103] = "novecientos";
        $tempo =    ($Numeros[$VDecena]);
        return $tempo;
    }

    function NumerosALetras($Numero)
    {
        $Decimales = 0;
//$Numero = intval($Numero);
        $letras = "";

        while ($Numero != 0)
        {

// '*---> Validación si se pasa de 100 millones

            If ($Numero >= 1000000000) 
            {
                $letras = "Error en Conversión a Letras";
                $Numero = 0;
                $Decimales = 0;
            }

// '*---> $this->Centenas de Millón
            If (($Numero < 1000000000) And ($Numero >= 100000000))
            {
                If ((Intval($Numero / 100000000) == 1) And (($Numero - (Intval($Numero / 100000000) * 100000000)) < 1000000))
                {
                    $letras .= (string) "cien millones ";
                }
                Else 
                { 
                    $letras = $letras & $this->Centenas(Intval($Numero / 100000000));
                    If ((Intval($Numero / 100000000) <> 1) And (Intval($Numero / 100000000) <> 5) And (Intval($Numero / 100000000) <> 7) And (Intval($Numero / 100000000) <> 9)) 
                    {
                        $letras .= (string) "cientos ";
                    }
                    Else 
                    {
                        $letras .= (string) " ";
                    }
                }
                $Numero = $Numero - (Intval($Numero / 100000000) * 100000000);
            }

            // '*---> $this->Decenas de Millón
            If (($Numero < 100000000) And ($Numero >= 10000000)) 
            {
                If (Intval($Numero / 1000000) < 16) 
                {
                    $tempo = $this->Decenas(Intval($Numero / 1000000));
                    $letras .= (string) $tempo;
                    $letras .= (string) " millones ";
                    $Numero = $Numero - (Intval($Numero / 1000000) * 1000000);
                }
                Else 
                {   
                    $letras = $letras & $this->Decenas(Intval($Numero / 10000000) * 10);
                    $Numero = $Numero - (Intval($Numero / 10000000) * 10000000);
                    If ($Numero > 1000000) 
                    {
                        $letras .= $letras & " y ";
                    }
                }
            }

            // '*---> $this->Unidades de Millón
            If (($Numero < 10000000) And ($Numero >= 1000000)) 
            {
                $tempo=(Intval($Numero / 1000000));
                If ($tempo == 1) 
                {   
                  $letras .= (string) " un millón ";
                }   
                Else 
                {
                    $tempo= $this->Unidades(Intval($Numero / 1000000));
                    $letras .= (string) $tempo;
                    $letras .= (string) " millones ";
                }
                $Numero = $Numero - (Intval($Numero / 1000000) * 1000000);
            }

            // '*---> $this->Centenas de Millar
            If (($Numero < 1000000) And ($Numero >= 100000)) 
            {
                $tempo=(Intval($Numero / 100000));
                $tempo2=($Numero - ($tempo * 100000));
                If (($tempo == 1) And ($tempo2 < 1000)) 
                {
                    $letras .= (string) "cien mil ";
                }   
                Else 
                {
                    $tempo=$this->Centenas(Intval($Numero / 100000));
                    $letras .= (string) $tempo;
                    $tempo=(Intval($Numero / 100000));
                    If (($tempo <> 1) And ($tempo <> 5) And ($tempo <> 7) And ($tempo <> 9)) 
                    {
                        $letras .= (string) "cientos ";
                    }   
                    Else 
                    {
                        $letras .= (string) " ";
                    }
                }
                $Numero = $Numero - (Intval($Numero / 100000) * 100000);
            }   

            // '*---> $this->Decenas de Millar
            If (($Numero < 100000) And ($Numero >= 10000)) 
            {
                $tempo= (Intval($Numero / 1000));
                If ($tempo < 16) 
                {
                    $tempo = $this->Decenas(Intval($Numero / 1000));
                    $letras .= (string) $tempo;
                    $letras .= (string) " mil ";
                    $Numero = $Numero - (Intval($Numero / 1000) * 1000);
                }
                Else 
                {
                    $tempo = $this->Decenas(Intval($Numero / 10000) * 10);
                    $letras .= (string) $tempo;
                    $Numero = $Numero - (Intval(($Numero / 10000)) * 10000);
                    If ($Numero > 1000) 
                    {
                        $letras .= (string) " y ";   
                    }
                    Else 
                    {
                        $letras .= (string) " mil ";
                    }
                }
            }

            // '*---> $this->Unidades de Millar
            If (($Numero < 10000) And ($Numero >= 1000)) 
            {
                $tempo=(Intval($Numero / 1000));
                If ($tempo == 1) 
                {
                    $letras .= (string) "un";
                }   
                Else 
                {
                    $tempo = $this->Unidades(Intval($Numero / 1000));
                    $letras .= (string) $tempo;
                }
                $letras .= (string) " mil ";
                $Numero = $Numero - (Intval($Numero / 1000) * 1000);
            }

            // '*---> $this->Centenas
            If (($Numero < 1000) And ($Numero > 99)) 
            {   
                If ((Intval($Numero / 100) == 1) And (($Numero - (Intval($Numero / 100) * 100)) < 1)) 
                {   
                    $letras = $letras & "cien ";
                }   
                Else 
                {   
                    $temp=(Intval($Numero / 100));   
                    $l2=$this->Centenas($temp);   
                    $letras .= (string) $l2;   
                    If ((Intval($Numero / 100) <> 1) And (Intval($Numero / 100) <> 5) And (Intval($Numero / 100) <> 7) And (Intval($Numero / 100) <> 9)) 
                    {
                        $letras .= "cientos ";
                    }   
                    Else 
                    {
                        $letras .= (string) " ";
                    }
                }

                $Numero = $Numero - (Intval($Numero / 100) * 100);
            }

            // '*---> $this->Decenas
            If (($Numero < 100) And ($Numero > 9) ) 
            {
                If ($Numero < 16 ) 
                {
                    $tempo = $this->Decenas(Intval($Numero));
                    $letras .= $tempo;
                    $Numero = $Numero - Intval($Numero);
                }   
                Else 
                {   
                    $tempo= $this->Decenas(Intval(($Numero / 10)) * 10);
                    $letras .= (string) $tempo;   
                    $Numero = $Numero - (Intval(($Numero / 10)) * 10);
                    If ($Numero > 0.99) 
                    {
                        $letras .=(string) " y ";

                    }
                }
            }

            // '*---> $this->Unidades
            If (($Numero < 10) And ($Numero > 0.99)) 
            {
                $tempo=$this->Unidades(Intval($Numero));
                $letras .= (string) $tempo;
                $Numero = $Numero - Intval($Numero);
            }

            // '*---> Decimales
            If ($Decimales > 0) 
            {

                $letras .=(string) " con ";
                $Decimales= $Decimales*100;
                echo ("*");   
                $Decimales = number_format($Decimales, 2);   
                echo ($Decimales);   
                $tempo = $this->Decenas(Intval($Decimales));   
                $letras .= (string) $tempo;
                $letras .= (string) "centavos";
            }   

            Else 
            {
                If (($letras <> "Error en Conversión a Letras") And (strlen(Trim($letras)) > 0)) 
                {
                    $letras .= (string) " ";
                }
            }

            return $letras;
        }
    }

  function ConvertirALetras($num, $fem = false, $dec = true) { 
       $matuni[2]  = "dos"; 
       $matuni[3]  = "tres"; 
       $matuni[4]  = "cuatro"; 
       $matuni[5]  = "cinco"; 
       $matuni[6]  = "seis"; 
       $matuni[7]  = "siete"; 
       $matuni[8]  = "ocho"; 
       $matuni[9]  = "nueve"; 
       $matuni[10] = "diez"; 
       $matuni[11] = "once"; 
       $matuni[12] = "doce"; 
       $matuni[13] = "trece"; 
       $matuni[14] = "catorce"; 
       $matuni[15] = "quince"; 
       $matuni[16] = "dieciseis"; 
       $matuni[17] = "diecisiete"; 
       $matuni[18] = "dieciocho"; 
       $matuni[19] = "diecinueve"; 
       $matuni[20] = "veinte"; 
       $matunisub[2] = "dos"; 
       $matunisub[3] = "tres"; 
       $matunisub[4] = "cuatro"; 
       $matunisub[5] = "quin"; 
       $matunisub[6] = "seis"; 
       $matunisub[7] = "sete"; 
       $matunisub[8] = "ocho"; 
       $matunisub[9] = "nove"; 
       $matdec[2] = "veint"; 
       $matdec[3] = "treinta"; 
       $matdec[4] = "cuarenta"; 
       $matdec[5] = "cincuenta"; 
       $matdec[6] = "sesenta"; 
       $matdec[7] = "setenta"; 
       $matdec[8] = "ochenta"; 
       $matdec[9] = "noventa"; 
       $matsub[3]  = 'mill'; 
       $matsub[5]  = 'bill'; 
       $matsub[7]  = 'mill'; 
       $matsub[9]  = 'trill'; 
       $matsub[11] = 'mill'; 
       $matsub[13] = 'bill'; 
       $matsub[15] = 'mill'; 
       $matmil[4]  = 'millones'; 
       $matmil[6]  = 'billones'; 
       $matmil[7]  = 'de billones'; 
       $matmil[8]  = 'millones de billones'; 
       $matmil[10] = 'trillones'; 
       $matmil[11] = 'de trillones'; 
       $matmil[12] = 'millones de trillones'; 
       $matmil[13] = 'de trillones'; 
       $matmil[14] = 'billones de trillones'; 
       $matmil[15] = 'de billones de trillones'; 
       $matmil[16] = 'millones de billones de trillones'; 
       
       //Zi hack
       $float= explode('.', $num);
       $num=$float[0];
       $num = trim((string)@$num); 
       if ($num[0] == '-') { 
          $neg = 'menos '; 
          $num = substr($num, 1); 
       }else 
          $neg = ''; 
       while ($num[0] == '0') $num = substr($num, 1); 
       if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
       $zeros = true; 
       $punt = false; 
       $ent = ''; 
       $fra = ''; 
       for ($c = 0; $c < strlen($num); $c++) { 
          $n = $num[$c]; 
          if (! (strpos(".,'''", $n) === false)) { 
             if ($punt) break; 
             else{ 
                $punt = true; 
                continue; 
             } 
          }elseif (! (strpos('0123456789', $n) === false)) { 
             if ($punt) { 
                if ($n != '0') $zeros = false; 
                $fra .= $n; 
             }else 
                $ent .= $n; 
          }else 
             break; 
       } 
       $ent = '     ' . $ent; 
       if ($dec and $fra and ! $zeros) { 
          $fin = ' coma'; 
          for ($n = 0; $n < strlen($fra); $n++) { 
             if (($s = $fra[$n]) == '0') 
                $fin .= ' cero'; 
             elseif ($s == '1') 
                $fin .= $fem ? ' una' : ' un'; 
             else 
                $fin .= ' ' . $matuni[$s]; 
          } 
       }else 
          $fin = ''; 
       if ((int)$ent === 0) return 'Cero ' . $fin; 
       $tex = ''; 
       $sub = 0; 
       $mils = 0; 
       $neutro = false; 
       while ( ($num = substr($ent, -3)) != '   ') { 
          $ent = substr($ent, 0, -3); 
          if (++$sub < 3 and $fem) { 
             $matuni[1] = 'una'; 
             $subcent = 'as'; 
          }else{ 
             $matuni[1] = $neutro ? 'un' : 'uno'; 
             $subcent = 'os'; 
          } 
          $t = ''; 
          $n2 = substr($num, 1); 
          if ($n2 == '00') { 
          }elseif ($n2 < 21) 
             $t = ' ' . $matuni[(int)$n2]; 
          elseif ($n2 < 30) { 
             $n3 = $num[2]; 
             if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
             $n2 = $num[1]; 
             $t = ' ' . $matdec[$n2] . $t; 
          }else{ 
             $n3 = $num[2]; 
             if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
             $n2 = $num[1]; 
             $t = ' ' . $matdec[$n2] . $t; 
          } 
          $n = $num[0]; 
          if ($n == 1) { 
             $t = ' ciento' . $t; 
          }elseif ($n == 5){ 
             $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
          }elseif ($n != 0){ 
             $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
          } 
          if ($sub == 1) { 
          }elseif (! isset($matsub[$sub])) { 
             if ($num == 1) { 
                $t = ' mil'; 
             }elseif ($num > 1){ 
                $t .= ' mil'; 
             } 
          }elseif ($num == 1) { 
             $t .= ' ' . $matsub[$sub] . '?n'; 
          }elseif ($num > 1){ 
             $t .= ' ' . $matsub[$sub] . 'ones'; 
          }   
          if ($num == '000') $mils ++; 
          elseif ($mils != 0) { 
             if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
             $mils = 0; 
          } 
          $neutro = true; 
          $tex = $t . $tex; 
       } 
       $tex = $neg . substr($tex, 1) . $fin; 
       //Zi hack --> return ucfirst($tex);
       @$ff = @$float[1] == '' ? '00':@$float[1] ;
       $end_num=ucfirst($tex).' quetzales con '.$ff.'/100 centavos';
       return $end_num; 
    } 
}


//favor de teclear a mano la cantidad numerica a convertir y asignarla a $tt
/*$tt = $total_en_letras;

$tt = $tt+0.009;
$Numero = intval($tt);
$Decimales = $tt - Intval($tt);
$Decimales= $Decimales*100;
$Decimales= Intval($Decimales);
$x=NumerosALetras($Numero);
if ($Decimales > 0)
{
    $y=NumerosALetras($Decimales);
    $total_letras = $x . " con " . $y . " centavos";
}
else 
{
    $total_letras = $x . ("con cero centavos");
}

$deuda = 0;

echo  "<table>";
while($row = mysql_fetch_array($result))

{
 $deuda  = $deuda + $row['total'];
 $total  = number_format($row['total'],2,'.',',');
 $precio = number_format($row['precio'],2,'.',',');
 print '<tr>
 <td id="fact_cantidad"><div style="height:18px; width:50px; text-align:right; margin-right:10px; overflow:hidden"> ' . $row['cantidad'] . '</div></td>
 <td><div style="height:18px; width:600px; overflow:hidden">' . $row['marca'] . ' ' . $row['descripcion'] . ' ' . $row['serie'] . '</div></td>
 <td class="fact_precio">' . $precio . '</td>
 <td class="fact_totales">' . $total . '</td>
</tr>';
}
$total_en_letras = $deuda;
$deuda = number_format($deuda,2,'.',',');
print '<tr class="hide">
<td></td>
<td id="total_en_ltr">' . $total_letras . '</td>
<td></td>
<td id="total_num" > ' . $deuda . ' </td>
</tr>';
print '</table>';

*/
