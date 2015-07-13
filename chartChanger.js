// work out which stat button has been clicked
			$(".glyphicon-stats").click (function(){
				switch(this.id){
					case "distStat":
						$("#squareChart").attr("src","img/sampleScatterGraphDist01.jpeg");
					break;
					case "durStat":
						$("#squareChart").attr("src","img/sampleScatterGraphDuration01.jpeg");
					break;
					case "spdStat":
						$("#squareChart").attr("src","img/sampleScatterGraphSpeed01.jpeg");
					break;
					case "enStat":
						$("#squareChart").attr("src","img/sampleScatterGraphEnergy01.jpeg");
					break;
					case "co2Stat":
						$("#squareChart").attr("src","img/sampleScatterGraphCO201.jpeg");
					break;
					default:
					alert("Argh");

				}


			});

		// $("iframe").attr("src", "http://www.ecowebhosting.co.uk");
		// $("p").html("The text (and website) has been changed");
		// alert($("iframe").attr("src"));
	//});


	//alert($("iframe").attr("src"));
	// $("#greenCircle").hover(function(){
	// 	alert("Hovering");
	// });