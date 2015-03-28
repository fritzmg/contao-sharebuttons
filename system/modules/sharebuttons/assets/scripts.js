// share dialogue
function shd() {};
shd.open = function(href,width,height)
{
	window.open(href, '', 'width='+width+',height='+height+',modal=yes,left=100,top=50,location=no,menubar=no,resizable=yes,scrollbars=yes,status=no,toolbar=no');
	return false;
};