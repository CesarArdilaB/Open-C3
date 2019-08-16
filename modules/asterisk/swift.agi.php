#!/bin/sh
# Asignar el valor de $texto con lo que se ha mandado por plan de marcado
texto=`echo $*`
# Asignar entrada estándar
stdin="0" 
while [ "$stdin" != "" ]
	do
		read stdin
		if [ "$stdin" != "" ]
	then
		stdin2=`echo $stdin | sed -e 's/: /=/' -e 's/"//g' -e 's/$/"/' -e 's/=/="/'`
		eval `echo $stdin2`
	fi
done

calleridnum=`echo $agi_callerid | cut -f2 -d\< | cut -f1 -d\>`
calleridname=`echo $agi_callerid | cut -f1 -d\< `
 
/usr/local/bin/swift -n Miguel-8kHz -e utf-8 -o /tmp/$agi_uniqueid.wav -p audio/channels=1,audio/sampling-rate=8000 " $texto "

# Hacer que asterisk reproduzca el audio
echo "stream file /tmp/$agi_uniqueid #"

# Leer la respuesta de asterisk al comando
read stream

# Realizar la limpieza, osea borrar el archivo generado.
rm /tmp/$agi_uniqueid.wav

exit 0
