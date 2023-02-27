<script>

	var data = <?= atj($data); ?>;
	// console.log(data);

	am4core.ready(function() {
		// Themes begin
		am4core.useTheme(am4themes_animated);
		// Themes end

		var chart = am4core.create('<?= $div_name ?>', am4charts.XYChart)
		chart.colors.step = 2;

		chart.cursor = new am4charts.XYCursor();
		chart.cursor.lineY.disabled = true;
		chart.cursor.lineX.disabled = true;


		chart.legend = new am4charts.Legend()
		chart.legend.position = 'top'
		chart.legend.paddingBottom = 20
		chart.legend.labels.template.maxWidth = 95

		var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
		xAxis.dataFields.category = "category";
		xAxis.renderer.grid.template.location = 0;
		xAxis.renderer.minGridDistance = 30;

		// xAxis.dataFields.category = 'category'
		xAxis.renderer.cellStartLocation = 0.1
		xAxis.renderer.cellEndLocation = 0.9
		// xAxis.renderer.grid.template.location = 0;
		// xAxis.renderer.labels.template.rotation = -90;
		// xAxis.renderer.labels.template.location = .5;
		// xAxis.renderer.minGridDistance = .1;

		xAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
		  if (target.dataItem && target.dataItem.index & 2 == 2) {
		    return dy + 30;
		  }
		  return dy;
		});


		var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
		yAxis.min = 0;

		function createSeries(value, name) {
		    var series = chart.series.push(new am4charts.ColumnSeries())
		    series.dataFields.valueY = value
		    series.dataFields.categoryX = 'category'
		    series.name = name

		    series.events.on("hidden", arrangeColumns);
		    series.events.on("shown", arrangeColumns);

		    // series.dataFields.valueY = "value";
		    // series.dataFields.categoryX = "category";
		    // series.tooltipText = "{categoryX}: {valueY}";


		    var bullet = series.bullets.push(new am4charts.LabelBullet())
		    bullet.interactionsEnabled = false
		    bullet.dy = 30;
		    bullet.label.text = ''
		    bullet.label.fill = am4core.color('#ffffff')

		    return series;
		}

		chart.data = [];
		for(var i = 0; i < data.length ; i++){
			// console.log('--',data);
			var tmp = {};
			var fleet = data[i];
			tmp.category = fleet.group == null ? 'Sin año de medición': fleet.group;
			tmp.CO2GKM = fleet.CO2GKM == null ? 0 : parseFloat(fleet.CO2GKM);
			tmp.NOXGKM = fleet.NOXGKM == null ? 0 : parseFloat(fleet.NOXGKM);
			tmp.PM25GKM = fleet.PM25GKM == null ? 0 : parseFloat(fleet.PM25GKM);
			tmp.PM10GKM = fleet.PM10GKM == null ? 0 : parseFloat(fleet.PM10GKM);
			tmp.CNGKM = fleet.CNGKM == null ? 0 : parseFloat(fleet.CNGKM);
			tmp.CO2GTonKM = fleet.CO2GTonKM == null ? 0 : parseFloat(fleet.CO2GTonKM);
			tmp.NOXGTonKM = fleet.NOXGTonKM == null ? 0 : parseFloat(fleet.NOXGTonKM);
			tmp.PM25GTonKM = fleet.PM25GTonKM == null ? 0 : parseFloat(fleet.PM25GTonKM);
			tmp.PM10GTonKM = fleet.PM10GTonKM == null ? 0 : parseFloat(fleet.PM10GTonKM);
			tmp.CNGTonKM = fleet.CNGTonKM == null ? 0 : parseFloat(fleet.CNGTonKM);

			tmp.CO2GKM = fleet.CO2GKM == null ? Math.random()*10 : parseFloat(fleet.CO2GKM);
			tmp.NOXGKM = fleet.NOXGKM == null ? Math.random()*10 : parseFloat(fleet.NOXGKM);
			tmp.PM25GKM = fleet.PM25GKM == null ? Math.random()*10 : parseFloat(fleet.PM25GKM);
			tmp.PM10GKM = fleet.PM10GKM == null ? Math.random()*10 : parseFloat(fleet.PM10GKM);
			tmp.CNGKM = fleet.CNGKM == null ? Math.random()*10 : parseFloat(fleet.CNGKM);
			tmp.CO2GTonKM = fleet.CO2GTonKM == null ? Math.random()*10 : parseFloat(fleet.CO2GTonKM);
			tmp.NOXGTonKM = fleet.NOXGTonKM == null ? Math.random()*10 : parseFloat(fleet.NOXGTonKM);
			tmp.PM25GTonKM = fleet.PM25GTonKM == null ? Math.random()*10 : parseFloat(fleet.PM25GTonKM);
			tmp.PM10GTonKM = fleet.PM10GTonKM == null ? Math.random()*10 : parseFloat(fleet.PM10GTonKM);
			tmp.CNGTonKM = fleet.CNGTonKM == null ? Math.random()*10 : parseFloat(fleet.CNGTonKM);

			
			chart.data.push(tmp);
		}
		// console.log(chart.data);

		createSeries('CO2GKM','CO2GKM');
		createSeries('NOXGKM','NOXGKM');
		createSeries('PM25GKM','PM25GKM');
		createSeries('PM10GKM','PM10GKM');
		createSeries('CNGKM','CNGKM');
		createSeries('CO2GTonKM','CO2GTonKM');
		createSeries('NOXGTonKM','NOXGTonKM');
		createSeries('PM25GTonKM','PM25GTonKM');
		createSeries('PM10GTonKM','PM10GTonKM');
		createSeries('CNGTonKM','CNGTonKM');

		function arrangeColumns() {

		    var series = chart.series.getIndex(0);

		    var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
		    if (series.dataItems.length > 1) {
		        var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
		        var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
		        var delta = ((x1 - x0) / chart.series.length) * w;
		        if (am4core.isNumber(delta)) {
		            var middle = chart.series.length / 2;

		            var newIndex = 0;
		            chart.series.each(function(series) {
		                if (!series.isHidden && !series.isHiding) {
		                    series.dummyData = newIndex;
		                    newIndex++;
		                }
		                else {
		                    series.dummyData = chart.series.indexOf(series);
		                }
		            })
		            var visibleCount = newIndex;
		            var newMiddle = visibleCount / 2;

		            chart.series.each(function(series) {
		                var trueIndex = chart.series.indexOf(series);
		                var newIndex = series.dummyData;

		                var dx = (newIndex - trueIndex + middle - newMiddle) * delta

		                series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
		                series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
		            })
		        }
		    }
		}

	}); // end am4core.ready()
</script>

<div id="<?= $div_name ?>" class="chartDiv"></div>
