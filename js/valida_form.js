//Idc1 valida q el campo este lleno
//Idc2 Valida q este lleno y sea numerico
//Idc3 y Tcaracteres = 1 -> valida que este lleno y tenga X cantidad de caracteres
//Idc3 y Tcaracteres = 2 -> valida que este lleno, q tenga X cantidad de caracteres y sea numerico
//Idc3 y Tcaracteres = 3 -> valida que este lleno y  q tenga > cantidad de caracteres
//Idc3 y Tcaracteres = 4 -> valida que este lleno y  q tenga < cantidad de caracteres
//Idc4 Formato fecha AAA-MM-DD
//Idc5 q valor sea menor a X
//Idc6 q valor sea mayor a X
//Idc7 q valor este entre X y Y
//Idc8 Que sea Mail
//Idc9 Reemplaza en la cadena las comas por puntos, verifica q sea un decimal o entero 
//Idc10 Si el campo esta lleno verifica que sea numero entero.
//Idc check q este selccionado 

function Valid_Form(TheForm)
	{
	
	var nFocus, i
	var fieldname 
	var Campo
	var elemento
	var pasa
	
	var Campo 		= 0 ; 
	var Ncaracteres = 0	 ;
	var Tcaracteres = 0;
	
	var seleccion = false;
	
	for (i = 0 ;i < TheForm.elements.length;  i++)  
	{
			 
		  elemento  =TheForm.elements[i];
		  tipo      =TheForm.elements[i].type;
	      fieldname =TheForm.elements[i].name ;
		  Idc = elemento.title;
	    
		 
						
	 	if(Idc==1 && tipo!= "hidden")
	  	{
			if(tipo == 'radio')
			{	
				
				for (j = 0; j < fieldname.length; j++) 
				{
					string = "TheForm."+fieldname+"["+ j +"].checked";
					
					if (eval(string)) 
					{
						seleccion = true;
						break;
					}
				}
				
				if(seleccion)
				{ 
					pasa = true; 
				}
				else
				{
					alert('Por favor llene los campos requeridos') ;
					elemento.focus() ;
					return  false ;
				}
				
				i += fieldname.length - 1;
			}
			else
			{
				 if (elemento.value != "")  
					{ 
						pasa = true; 
					}
					else
					{
						alert('Por favor llene los campos requeridos') ;
						elemento.focus() ;
						return  false ;
					}
			}
		}
		else  if(Idc==2 && tipo!= "hidden" ){
			 if (elemento.value != "" && isNaN(elemento.value) == false )  
				{}
				else{
				alert("El campo debe ser numérico") ;
				elemento.style.backgroundColor = "#4AC5FF";
				elemento.focus();
				return  false ;
				
				}
				
			}
			
		else  if(Idc==3 && Tcaracteres==1){
			 if (elemento.value.length == Ncaracteres)  
				{}
				else{
				alert("El campo \" "+ Campo +"  \" debe contener " + Ncaracteres +" caracteres ") ;
				elemento.focus();
				return  false ;
				
				}
				
			}	
	    else  if(Idc==3 && Tcaracteres==2){
			 if (elemento.value.length == Ncaracteres && isNaN(elemento.value) == false)  
				{}
				else{
				alert("El campo \" "+ Campo +" \" debe contener " + Ncaracteres +" caracteres únicamente  numéricos ->" + Hdispo) ;
				elemento.focus();
				return  false ;
				
				}
				
			}	
		
		else  if(Idc==3 && Tcaracteres==3){
			 if (elemento.value.length > Ncaracteres)  
				{}
				else{
				alert("El campo \" "+ Campo +" \" debe ser mayor a " + Ncaracteres +" caracteres ") ;
				elemento.focus();
				return  false ;
				
				}
				
			}
		
		else  if(Idc==3 && Tcaracteres==4){
			 if (elemento.value.length < Ncaracteres)  
				{}
				else{
				alert("El campo \" "+ Campo +" \" debe ser menor a " + Ncaracteres +" caracteres ") ;
				elemento.focus();
				return  false ;
				
				}
				
			}	
		
		else  if(Idc==4 && tipo!= "hidden"){
			 if (Valida_Fecha(elemento.value) == true)  
				{ }
				else{
					elemento.focus();
				return  false ;
				
				}
				
			}
			
		else  if(Idc==5 && tipo!= "hidden"){
			 if (elemento.value < parseFloat(Ncaracteres) && isNaN(elemento.value) == false)  
				{}
				else{
				alert("El valor escrito en \" "+ Campo +" \" debe ser menor a " + Ncaracteres +"") ;
				elemento.focus();
				return  false ;
				
				}
				
			}
			
		else  if(Idc==6 && tipo!= "hidden" ){
			 if (elemento.value > parseFloat(Ncaracteres) && isNaN(elemento.value) == false)  
				{}
				else{
				alert("El valor escrito en \" "+ Campo +" \" debe ser mayor a " + Ncaracteres +"") ;
				elemento.focus();
				return  false ;
				
				}
				
			}	
			
		else  if(Idc==7 && tipo!= "hidden" ){
			 if (elemento.value < Ncaracteres && elemento.value > Tcaracteres || isNaN(elemento.value) == true)  
				{
			alert("El valor escrito en \" "+ Campo +" \" debe estar entre " + Ncaracteres +" y " + Tcaracteres) ;
				elemento.focus();
				return  false ;
				
				}
				
			}	
		else  if(Idc==8 && tipo!= "hidden"){
			 if (validarEmail(elemento.value) == true)  
				{ }
				else{
					elemento.focus();
				return  false ;
				
				}
				
			}
		
		else if(Idc==9 && tipo!= "hidden")
	  	{
	  	    if(elemento.value != "")
	  	    {
	  	        var data = elemento.value.replace(",", ".");
    	  	    
		        if(parseFloat(data))
		        {
		           if(data >= 0 && data <= 10)
		           {
		            //NOTHING ELSE.(THE LOOP CONTINUES)
		           }
		           else
		           {
		                alert("la calificacion esta fuera de rango.");
		                elemento.focus();
		                elemento.style.backgroundColor = "#4AC5FF";
		                return false;
		           }
		        }
		        else if(data == "0")
		        {
		            //SPECIAL CASE. IF THE DATA IS '0' THE parseFolat and parseInt CAN NOT CONVERT IT AND THE EXECUTION WILL THROW AN ERROR
		        }
		        else
		        {
		            alert("Recuerde que las calificaciones no pueden contener caracteres diferentes de numeros.");
		            elemento.focus();
		            elemento.style.backgroundColor = "#4AC5FF";
		            return false;
		        }
		    }		     
		}
		else  if(Idc==10 && tipo!= "hidden" )
		{
			 if (isNaN(elemento.value) == false )  
			 {
			    //NOTHING ELSE.(THE LOOP CONTINUES)
			 }
			 else
			 {
				alert("El campo debe ser numérico") ;
				elemento.style.backgroundColor = "#4AC5FF";
				elemento.focus();
				return  false ;
			 }
		}		
		
		else  if(Idc=='check' && tipo!= "hidden"){
			 if (elemento.checked == false){  
				alert("Por favor elija una opción")
				elemento.focus();
				return  false ;
			 }
		
				
			}			
		 
		 }
	
}//Valid_Form
		
function validarEmail(valor) {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(valor)){
 //  alert("La dirección de email " + valor    + " es correcta.") 
   return (true)
  } else {
   alert("La dirección de email es incorrecta.");
   return (false);
  }
 }
 
function Valida_Fecha(Cadena){

	var Fecha= new String(Cadena)	// Crea un string
	// Cadena Año
	var Dia= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))
	// Cadena Mes
	var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))
	// Cadena Día
	var Ano= new String(Fecha.substring(0,Fecha.indexOf("-")))

	// Valido el año
	if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){
        	alert('El formato de fecha debe ser Ej: \" AAA-MM-DD\" \n Año inválido')
		return false
	}
	// Valido el Mes
	if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){
		alert('El formato de fecha debe ser Ej: \" AAA-MM-DD\" \n Mes inválido')
		return false
	}
	// Valido el Dia
	if (isNaN(Dia) || parseInt(Dia)>31){
		alert('El formato de fecha debe ser Ej: \" AAA-MM-DD\" \n  Día inválido')
		return false
	}
	if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {
		if (Mes==2 && Dia > 28 || Dia>30) {
			alert('El formato de fecha debe ser \" AAA-MM-DD\" \n  Día inválido')
			return false
		}
	}

  return true	
}		

function Result_Call(){
	
    var v = document.form1.t_visto.value;
	var h = document.form1.hora.value;
	var f = document.form1.fecha.value;
		
	if(v=="----"){
	alert("Debe seleccionar un resultado de llamada");
	return false;
	}
	if(v==1 && f=="" || v==1 && h==""){
	alert('Debe llenar los campos: \n fecha y hora para este resultado');
	return false;
	}
}

