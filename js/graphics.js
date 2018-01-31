function oPlotGraphic (data,data1,data2){
// window.onload = function () {
	var options = {
		animationEnabled: true,
		theme: "light2",
		title: {
			text: "Recettes mensuelles"
		},
		axisX: {
			valueFormatString: "MMM"
		},
		axisY: {
			prefix: "CFA",
			labelFormatter: addSymbols
		},
		toolTip: {
			shared: true
		},
		legend: {
			cursor: "pointer",
			itemclick: toggleDataSeries
		},
		data: [
			{
				type: "column",
				name: "Ventes totals",
				showInLegend: true,
				xValueFormatString: "MMMM YYYY",
				yValueFormatString: "$#,##0",
				dataPoints: data
			}
			,
			{
				type: "spline",
				name: "Services annexes",
				showInLegend: true,
				yValueFormatString: "$#,##0",
				dataPoints: data1
			},
			{
				type: "area",
				name: "Hébergements",
				markerBorderColor: "white",
				markerBorderThickness: 2,
				showInLegend: true,
				yValueFormatString: "$#,##0",
				dataPoints: data2
			}
		]
	};
	$("#chartContainer").CanvasJSChart(options);
	
	function addSymbols(e) {
		var suffixes = ["", "K", "M", "B"];
		var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);
	
		if (order > suffixes.length - 1)
			order = suffixes.length - 1;
	
		var suffix = suffixes[order];
		return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
	}
	
	function toggleDataSeries(e) {
		if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		} else {
			e.dataSeries.visible = true;
		}
		e.chart.render();
	}
	
	
	// }
}