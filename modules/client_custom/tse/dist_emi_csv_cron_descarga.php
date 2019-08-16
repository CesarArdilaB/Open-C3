<? 

$unirfecha= str_ireplace("-","",date('Y-m-d'));

$new_report=fopen("../../../tmp/emision_distribucion_autogenerado".$unirfecha.".csv","w");
 
fwrite($new_report, $htm);
 
fclose($new_report);
 
?> 
<br />
<br />
<center>
  de click secundario y luego la opcion guardar enlace como
</center>
<br />
<br />
<br />
 <center> <a href="tmp/emision_distribucion_autogenerado_dia_p1.csv" ><strong>Descargar Reporte Parte 1 </strong></a> <br>
 </center>
 <center> <a href="tmp/emision_distribucion_autogenerado_dia_p2.csv" ><strong>Descargar Reporte Parte 2</strong></a> <br>
</center> 

 <center> <a href="tmp/emision_distribucion_autogenerado_dia_p3.csv" ><strong>Descargar Reporte Parte 3</strong></a><br>
</center> 

 <center> <a href="tmp/emision_distribucion_autogenerado_dia_p4.csv" ><strong>Descargar Reporte Parte 4</strong></a> <br>
</center> 

 <center> <a href="tmp/emision_distribucion_autogenerado_dia_p5.csv" ><strong>Descargar Reporte Parte 5</strong></a> <br>
</center> 

 <center> <a href="tmp/emision_distribucion_autogenerado_dia_p6.csv" ><strong>Descargar Reporte Parte 6</strong></a> <br>
</center> 

 <center> <a href="tmp/emision_distribucion_autogenerado_dia_p7.csv" ><strong>Descargar Reporte Parte 7</strong></a> <br>
</center> 

 <center> <a href="tmp/emision_distribucion_autogenerado_dia_p8.csv" ><strong>Descargar Reporte Parte 8</strong></a> <br>
</center> 

<!-- <center> <a href="tmp/emision_distribucion_autogenerado-JUNIO.csv" ><strong>Descargar Junio</strong></a> <br>
</center> -->
