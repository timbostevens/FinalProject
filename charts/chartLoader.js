
// value for default histogram option
var DEFAULT_HISTRO = 'Speed (mph)';

// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

function drawAllCharts(){
	drawDashboard();
	//drawHistoChart(DEFAULT_HISTRO);
	//drawBubbleChart();
	//drawCalendarChart();
}