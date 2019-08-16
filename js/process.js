// JavaScript Document
searchUser = function(form)
{
	word = form.word.value;
	
	if(word != '')
	{
		EnviaPost('this', 'user.php?case=2', form);
	}
}

verify_search = function(form)
{
	word = form.word.value;
	
	if( word == '')
	{}
	else
	{
		EnviaPost('search', 'user.php?case=2', form);	
	}
}

optionActivo = function(form)
{
	FindBy = form.FindBy.value;
	
	if(FindBy == 'A8')
	{
		document.getElementById('clave').innerHTML = 'Activos <input type="radio" name = "word" value = "1">  Inactivos <input type="radio" name = "word" value = "0">';
	}
	else
	{
		document.getElementById('clave').innerHTML = '<input type = "text" name = "word">';
	}
}

processUser = function(form)
{
	id = form.id.value;
	tipoc = form.tipoc.value;
	id_causales = form.id_causales.value;

	
	if(tipoc == 'none' || id_causales == 'none')
	{
		alert('Por favor seleccione una opcion en cada campo para poder continuar');
	}
	else
	{
		EnviaPost('this', 'user.php?case=3', form);
	}
}

cancelUpdate = function()
{
	EnviaLink('this', 'user.php?case=1');
}

disposiciones = function(form)
{
	tipoc = form.tipoc.value;
	
	switch(tipoc)
	{
		case 'none':
		break;
		
		case '0':
		case '1':
			EnviaLink('causal', 'interfaces/plugins.php/disposiciones.php?tipoc='+tipoc);
		break;
	}
}

checkDataDisp = function(form)
{
	disposicion = form.disposicion.value;
	tipo = form.tipo.value;
	if(disposicion == '')
	{
		alert('Ingrese un nombre para la disposicion');
		form.disposicion.focus();
	}
	else if(tipo == 'sel')
	{
		alert('Seleccione un tipo de disposicion');
		form.sel.focus();
	}
	else
	{
		EnviaLink('this','AdminDisp.php?case=2&disposicion='+disposicion+'&tipo='+tipo);	
	}
}

cleanDataDisp = function(form)
{
	disposicion = form.disposicion.value = '';
	form.tipo.options[0].selected = true
}

SetDisposicion = function(form)
{
	disposicion = form.disposicion.value;
	
	if(disposicion == 'none')
	{
		form.disposicion.options[0].selected = true;
		form.nombre.value = '';
		form.nombre.disabled = true;
		form.tipo.options[0].selected = true;
		form.tipo.disabled = true;
		document.getElementById('estadoEdit').innerHTML = '';
	}
	else
	{
		EnviaLink('nombre', 'AdminDisp.php?case=3&nombre=1&disposicion='+disposicion);
		EnviaLink('tipo', 'AdminDisp.php?case=3&tipo=1&disposicion='+disposicion);
	}
}

editarDisposicion = function(form)
{
	disposicion = form.disposicion.value;
	nombre = form.nombre.value;
	tipo = form.tipo.value;
	
	for(i = 0; i < form.disposicion.options.length; i++)
	{
		if(form.disposicion.options[i].value == disposicion && form.disposicion.options[i].value != 'none')
		{
			form.disposicion.options[i].text = form.disposicion.options[i].value+'. '+nombre;
			document.forms[2].disposicion.options[i].text = form.disposicion.options[i].value+'. '+nombre;
		}
	}
	
	if(disposicion == 'none')
	{
		alert('Seleccione la disposicion a eidtar');
	}
	else if(nombre == '')
	{
		alert('Ingrese un nuevo nobre para la disposicion');
		form.nombre.focus();
	}
	else if(tipo == 'none')
	{
		alert('Seleccione tipo para la disposicion');
		form.tipo.focus();
	}
	else
	{
			//form.disposicion[]
			EnviaLink('estadoEdit', 'AdminDisp.php?case=4&disposicion='+disposicion+'&nombre='+nombre+'&tipo='+tipo);
	}
}

cleanEditDisposicion = function(form)
{
	form.disposicion.options[0].selected = true;
	form.nombre.value = '';
	form.nombre.disabled = true;
	form.tipo.options[0].selected = true;
	form.tipo.disabled = true;
	document.getElementById('estadoEdit').innerHTML = '';
}

eliminarDisp = function(form)
{
	disposicion = form.disposicion.value;
	
	if(disposicion == 'none')
	{
		alert('Seleccione una disposicion');
	}
	else
	{
		for(i = 0; i < form.disposicion.options.length; i++)
		{
			if(form.disposicion.options[i].value == disposicion)
			{
				texto = form.disposicion.options[i].text;
				pos = i;
			}
		}
		
		a = confirm('Esta usted seguro que desea elimiar la disposicion '+texto+' ?');
		
		if(a)
		{
			document.forms[1].disposicion.options[pos] = null;

			EnviaPost('this', 'AdminDisp.php?case=5', form);
		}
	}
	
}