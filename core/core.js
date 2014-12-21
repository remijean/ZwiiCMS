/*
	Cacher la popup après 5 secondes
*/

window.onload = function()
{
	var element = document.getElementById('popup');
	if(element)
	{
		setTimeout(function()
		{
			element.style.display = 'none';
		}, 5000);
	}
}

/*
	Afficher/cacher un élément
*/

function showHide(id)
{
	var element = document.getElementById(id);
	if (element.style.display == 'inline')
	{
		element.style.display = 'none';
	}
	else
	{
		element.style.display = 'inline';
	}
}