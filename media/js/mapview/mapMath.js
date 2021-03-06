/***********************************************************
* mapMath.js - Script
* This software is copy righted by Etherton Technologies Ltd. 2013
* Written by Dylan Gillespie <dylan@ethertontech.com> 
* Started on 2013-08-05
* Javascript code for the math for creating the map
*************************************************************/



 //Constructor for mapMath
var mapMath = (function(){

	/**
	* This takes in a set of data and finds the min and max,
	* then uses super complex math to figure out the optimal min and max, 
	* like round to nice managable numbers and decide if we should baseline
	* off of zero or not
	* @param array data is the array that contains all the data points for the map
	* @return array that contains the min and span
	*/
	function calculateMinSpread(data, indicator)
	{
		//loop over the data to pre process it and figure out the below:
		var min = Infinity; 
		var max = -Infinity; 
		
		if(extend_range){
			var ids = indicator.split('_');
			//for all sheets find the indicators
			for(sheet in data.sheets){
				var dataPtr = data.sheets[sheet];
				for(var i = 1; i < ids.length; i++){
					dataPtr = dataPtr.indicators[parseInt(ids[i])];
				}
				//now that we have the indicator we want, find mins and max
				if(typeof(dataPtr) != 'undefined'){
					for(regions in dataPtr.data){
						var regData = parseFloat(dataPtr.data[regions].value);
						if(regData < min)
						{
							min = regData;
						}
						//check for max
						if(regData > max)
						{
							max = regData;
						}
					}
				}
			}
			
		}
		else{	
			for(areaName in data)
			{
				//data[areaName] = data[areaName];
				//check for min
				if(data[areaName] < min)
				{
					min = data[areaName];
				}
				//check for max
				if(data[areaName] > max)
				{
					max = data[areaName];
				}
			}
		}
		
		//console.log("max: " + max + " min: " + min);
		//figure out the order of magnitude of max
		var maxMagnitude = calculateMagnitude(max);
		if (maxMagnitude < 1)
		{
			if(max < 0)
			{
				max = 0;
			}
			else
			{
				max = maxMagnitude * 10;
			}
		}
		else if(maxMagnitude == 1)
		{
			max = 10;
		}
		else if(max%maxMagnitude != 0)
		{
			max = (Math.floor(max/maxMagnitude)+1) * maxMagnitude;
		}
		
		//figure out the order of magnitude of max	
		var minMagnitude = calculateMagnitude(min);
		
		if(min == 0)
		{
			min = 0;
		}
		else if (minMagnitude < 1)
		{
			min = Math.floor(min/minMagnitude)*minMagnitude;
			min = parseFloat(min.toFixed(Math.log(10)/Math.log((1.0/minMagnitude)))); //making up for crappy float rounding errors
		}
		else if(minMagnitude == 1)
		{
			min = 0;
		}
		else if(min%minMagnitude != 0)
		{
			min = Math.floor(min/minMagnitude) * minMagnitude;
		}

		//now we decide if we want to base line off zero
		//We don't baseline off zero if the min is negative and the max is positive
		if(!(min < 0 && max > 0))
		{
			//now we want to figure out if max or min is closer to zero
			var closerToZero = min;
			if(max < 0)
			{ //max is closer
				closerToZero = max;
			}
			//now we see if the number closer to zero, is further from zero than max is from min. and if the absolute
			//value of the number involved are more than 1000
			
			if(!(Math.abs(closerToZero) > Math.abs(max-min) && Math.abs(closerToZero) > 1000))
			{
				if(max > 0)
				{
					min = 0;
				}
				else
				{
					max = 0;
				}
			}
			
		}
		
		//calculate the spread
		var spread = max - min;
		
		if(Math.abs(spread) < 1)
		{
			round = false;
		}
		else
		{
			round = true;
		}
		
		var retVal = new Array();
		retVal["min"] = min;
		retVal["spread"] = spread;

		return retVal;
	}

	/**
	* Figures out the magnitude 
	* @param int num number to be calculated
	* @return float magnitude that was calculated
	*/
	function calculateMagnitude(num)
	{
		if(isNaN(num) || num == Number.POSITIVE_INFINITY || num == Number.NEGATIVE_INFINITY)
		{
			return 0;
		}
			
		num = Math.abs(num);
		//is this number equal to or greater than 1?
		if(num == 0)
			return 0;
		
		else if(num >= 1)
		{
			var magnitude = 0;
			for (var i = 1; i <= num; i = i * 10)
			{
				if(num - i < ((i*10)-(1*i)))
				{				
					magnitude = i;
					break;
				}
			}
			return magnitude;
		}
		else
		{ //it's a decimal value
			var magnitude = 0.1;
			for (magnitude = 0.1; (num - magnitude) < 0; magnitude = magnitude / 10)
			{
				if(magnitude < 0.00000001)
					{
						break;
					}
			}		
			return magnitude;
		}
	}
	
	
	//return so that the functions are called when using class.function()	 
	return {calculateMinSpread:calculateMinSpread};
	  
})();
 
