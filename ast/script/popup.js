/**
 * PHP Master Page Architecture Example Website
 * Designed and Developed by Daniel Brannon
 * Copyright (c) 2011 OSoSLO
 * http://ososlo.com/
 */
 
function changeStyle(id, newValue)
{
	document.getElementById(id).style.display = newValue;
}

function openPopup()
{
	if (document.getElementById)
	{
		changeStyle('popupDiv', 'inline');
		return false;
	}
	else
	{
		return true;
	}
}

function closePopup()
{
	changeStyle('popupDiv', 'none');
	return false;
}
