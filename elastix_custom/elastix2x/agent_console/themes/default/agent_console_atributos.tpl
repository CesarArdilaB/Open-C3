<table border="0">
    <theader>
	    <tr>
	        <th colspan="2">{$LBL_INFORMACION_LLAMADA|escape:"html"}</th>
	    </tr>
    </theader>
    <tbody>
    {foreach from=$ATRIBUTOS_LLAMADA item=ATRIBUTO }
     {if $ATRIBUTO.label neq  "1" and $ATRIBUTO.label neq "2"}
	    <tr>
	       <!--<td><label>{$ATRIBUTO.label|escape:"html"}: </label></td>-->
           <td colspan="2">{$ATRIBUTO.value}</td>
	    </tr>
     {/if}
	{foreachelse}
	   <tr><td colspan="2">{$MSG_NO_ATTRIBUTES}</td></tr>
    {/foreach}
    <tr>
	       <td colspan="2"><a href="/openc3/?sec=gestion&mod=agent_console&regediting={$ATRIBUTOS_LLAMADA[0].value}&camediting={$ATRIBUTOS_LLAMADA[1].value}" target="_blank" >Gestionar en Openc3</a> </td>
	    </tr>
    </tbody>
</table>

