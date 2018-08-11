//******************************************************************************************************************
// Prorgam Name : tableFunctions.js
// Developer : Prabakaran Sekar
// Description : 	This javascript file is called by the external XSL file. The file contains functions for 
//					filtering table, sorting table,urlDecode and open a new browser window.
//
// Change History:
//
// Version #		Date		Changed By		Description
//----------------------------------------------------------------
// 1.0				9/1/2006	 Prabakar		Initial Version
// 1.1				26/02/2007	 Prabakar		Mouseover tooltip added. 4 More columes added (SmartChoice Action,Product Street 
//                                              Price,Product List Price, Product Price Indication )
// 1.2				12/03/2007	 Aruna		    Added rank coulmn for each product and display of all Product numbers
//                                              entered in the dropdown in report irrespective of whether they are valid or not.
// 1.3			    27/03/2007  Aruna		    Display of EPP Price and Display of EPP Saving Percentage.
//******************************************************************************************************************


//------------------------------------------------------------------------------------------------------------------
//-----------------------------------------Table Filetering Functions-----------------------------------------------
//------------------------------------------------------------------------------------------------------------------

// Attach the filter to a table. filterRow specifies the rownumber at which the filter should be inserted.
/*-----------------------------------------------------------------------------------------------------------
Name: attachFilter
Input parm datatype:object , int
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function attachFilter(table, filterRow)
 {
	table.filterRow = filterRow;
	// Check if the table has any rows. If not, do nothing
	if(table.rows.length > 0) 
	{
		// Insert the filterrow and add cells whith drowdowns.
		var filterRow = table.insertRow(table.filterRow);
		var deletedrow = table.deleteRow(table.filterRow+1);
		for(var i = 0; i < table.rows[table.filterRow + 1].cells.length; i++) 
		{
			
			var c = document.createElement("TH");
			table.rows[table.filterRow].appendChild(c);
			if(i == 12+alterTable+altTable || i == 13+alterTable+altTable) 
			{
				var opt = document.createElement("div");
	  			opt.innerHTML = "<b>&nbsp;</b>";
			}
			 else 
			{
				var opt = document.createElement("select");
				opt.onchange = filter;
			}
			c.appendChild(opt);
		
		}
		// Set the functions
		table.fillFilters = fillFilters;
		table.inFilter = inFilter;
		table.buildFilter = buildFilter;
		table.showAll = showAll;
		table.detachFilter = detachFilter;
		table.filterElements = new Array();
		
		// Fill the filter
		table.fillFilters();
		table.filterEnabled = true;
	}
}

// This function returns unique values for an array.
/*-----------------------------------------------------------------------------------------------------------
Name: unique
Input parm datatype: Array 
Return datatype: Unique Array
-------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------
Name: detachFilter
Input parm datatype: None
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function detachFilter() 
{
	if(this.filterEnabled) 
	{
		// Remove the filter
		this.showAll();
		this.deleteRow(this.filterRow);
		this.filterEnabled = false;
	}
}

// Checks if a column is filtered
/*-----------------------------------------------------------------------------------------------------------
Name: inFilter
Input parm datatype:int
Return datatype: bool
-------------------------------------------------------------------------------------------------------------*/
function inFilter(col) 
{
	for(var i = 0; i < this.filterElements.length; i++) 
	{
		if(this.filterElements[i].index == col)
			return true;
	}
	return false;
}

// Fills the filters for columns which are not fiiltered
/*-----------------------------------------------------------------------------------------------------------
Name: fillFilters
Input parm datatype:None
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function fillFilters() 
{ 
	for(var col = 0; col < this.rows[this.filterRow].cells.length; col++) 
	{	
		if(col == 12+alterTable+altTable || col == 13+alterTable+altTable) 
		{
			continue;
		}
		
		if(!this.inFilter(col)) 
		{
			this.buildFilter(col, "(all)");
		}
	}
}

/*-----------------------------------------------------------------------------------------------------------
Name: formatHREF
Input parm datatype:string
Return datatype: string
-------------------------------------------------------------------------------------------------------------*/
function formatHREF(str)
 {
	return (str.substr(str.indexOf(">")+1,str.lastIndexOf("<")-str.indexOf(">")-1))?(str.substr(str.indexOf(">")+1,str.lastIndexOf("<")-str.indexOf(">")-1)):str;
	
}

// Fills the columns dropdown box. 
// setValue is the value which the dropdownbox should have one filled. 
// If the value is not suplied, the first item is selected
/*-----------------------------------------------------------------------------------------------------------
Name: buildFilter
Input parm datatype:int,string
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function buildFilter(col, setValue) 
{
	// Get a reference to the dropdownbox.
	var opt = this.rows[this.filterRow].cells[col].firstChild;
	
	// remove all existing items
	while(opt.length > 0)
		opt.remove(0);
	
	var values = new Array();
		
	// put all relevant strings in the values array.
	for(var i = this.filterRow + 1; i < this.rows.length; i++) 
	{
		var row = this.rows[i];
		if(row.style.display != "none" && row.className != "noFilter") 
		{
			if(altTable==1)
			{
				if(col == 1 || col == 11+alterTable || col == 16+alterTable) 
				{
					var str = row.cells[col].innerHTML;
					
					values.push((formatHREF(str)).trim());
			 
				}
				 else 
				{
					values.push((row.cells[col].innerHTML).trim());
				}
			}
			else
			{
                if(col == 1 || col == 9+alterTable || col == 15+alterTable) 
				{
					var str = row.cells[col].innerHTML;
					
					values.push((formatHREF(str)).trim());
			 
				}
				 else 
				{
					values.push((row.cells[col].innerHTML).trim());
				}
			}
		}
	}
	if(altTable==1)
	{
		if(col == 0 ||col == 16+alterTable || col == 3+alterTable || col == 4+alterTable || col == 5+alterTable || col == 6+alterTable || col ==7+alterTable  || col ==8+alterTable || col == 10+alterTable) 
		{
			values.sort(sortNumber)		
		}
		 else 
		 {
			values.sort();
		}
	}
	else
	{
		if(col == 0 ||col == 15+alterTable || col == 3+alterTable || col == 4+alterTable || col == 5+alterTable || col == 6+alterTable || col ==8+alterTable ) 
		{
			values.sort(sortNumber)		
		}
		 else 
		 {
			values.sort();
		}

	}
	//add each unique string to the dopdownbox
	var value;
	values = values.unique();
	for(var i = 0; i < values.length; i++) 
	{
		if(values[i].toLowerCase() != value) 
		{
			value = values[i].toLowerCase();
			opt.options.add(new Option(values[i], value));
		}
	}

	opt.options.add(new Option("(all)", "(all)"), 0);

	if(setValue != undefined)
		opt.value = setValue;
	else
		opt.options[0].selected = true;
}

/*-----------------------------------------------------------------------------------------------------------
Name: sortNumber
Input parm datatype:int,int
Return datatype: int
-------------------------------------------------------------------------------------------------------------*/
function sortNumber(a, b) 
{
	
		if(!Number(a)) 
		{
			a = 0;
		}
		if(!Number(b)) 
		{
			b = 0;
		}
		var result = a - b;

		if(Number(result)) 
		{
			return (result);
		} else 
		{
			return (0);	
		}
	

}
	


// This function is called when a dropdown box changes
/*-----------------------------------------------------------------------------------------------------------
Name: filter
Input parm datatype:None
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function filter() 
{

	var table = this; // 'this' is a reference to the dropdownbox which changed
	while(table.tagName.toUpperCase() != "TABLE")
		table = table.parentNode;
    
	var filterIndex = this.parentNode.cellIndex; // The column number of the column which should be filtered
	var filterText = table.rows[table.filterRow].cells[filterIndex].firstChild.value;
	
	// First check if the column is allready in the filter.
	var bFound = false;
	var q=0;

	for(var i = 0; i < table.filterElements.length; i++) 
	{
		if(table.filterElements[i].index == filterIndex) 
		{
			bFound = true;
			// If the new value is '(all') this column is removed from the filter.
			if(filterText == "(all)") 
			{
				table.filterElements.splice(i, 1);
				q=1;
				
			} else 
			{				
				table.filterElements[i].filter = filterText;
			}
			break;
		}
	}
	if(!bFound) 
	{
		// the column is added to the filter
		var obj = new Object();
		obj.filter = filterText;
		obj.index = filterIndex;
		table.filterElements.push(obj);
	}
	
	// first set all rows to be displayed
	table.showAll();
	
	
	// the filtering of correct rows.
	for(var i = 0; i < table.filterElements.length; i++) 
	{
	   	// First fill the dropdown box for this column
		table.buildFilter(table.filterElements[i].index, table.filterElements[i].filter);
		var rowArray = new Array();
        var indexArray = new Array();
        // Apply the filter
		var k =0;
		for(var j = table.filterRow + 1; j < table.rows.length; j++) 
		{
			var row = table.rows[j];
			if(table.style.display != "none" && row.className != "noFilter") 
			{
			   if( table.filterElements[i].index == 1 || table.filterElements[i].index == 9+alterTable+betTable || table.filterElements[i].index == 15+alterTable+altTable) 
			   	{
		 			if(table.filterElements[i].filter != (formatHREF(row.cells[table.filterElements[i].index].innerHTML.toLowerCase())).trim()) 
					{
						row.style.display = "none";
													
					} else 
					{
						if(row.style.display != "none") 
						{
							rowArray[k] = new Object;
							indexArray[k]= new Object;
							rowArray[k].oldIndex = k;
							indexArray[k].oldIndex = k;
							rowArray[k].value = j;
							indexArray[k].value = formatHREF(row.cells[0].innerHTML.toLowerCase());
							k++;
						}
					
					}
				} else 
				{
					if(table.filterElements[i].filter != (row.cells[table.filterElements[i].index].innerHTML.toLowerCase()).trim()) 
					{
						row.style.display = "none";
								
					} else 
					{
						if(row.style.display != "none") 
						{
							rowArray[k] = new Object;
							indexArray[k]= new Object;
							rowArray[k].oldIndex = k;
							indexArray[k].oldIndex = k;
							rowArray[k].value = j;
							indexArray[k].value =formatHREF(row.cells[0].innerHTML.toLowerCase());
							
							k++;
						}
					}
		
				}
				
	    	}
						
		}
		
	}
	// Fill the dropdownboxes for the remaining columns.
	  table.fillFilters();
	 // alert(table.filterElements.length);
	  var table = document.getElementById('results');
	  var tbody = table.getElementsByTagName('tbody')[0];
	  var rows = tbody.getElementsByTagName('tr');
	  var rowSArray = new Array();
	  for (var i=0, length=rows.length; i<length; i++) 
	  {
			rowSArray[i] = new Object;
			rowSArray[i].oldIndex = i;
			rowSArray[i].value = rows[i].getElementsByTagName('td')[0].innerHTML;
		
	  }
	 var u=0;
	//change the background color of rows when user clicks on the dropdown for any column based on product number change.
	//q is 1 when user selects 'all' option in the dropdown	 
	 if(q == 1) 
	 {
	 
	    for(i=0;i<rowSArray.length;i++) 
	    {
		     if(i!=0) 
		     {
		        if(u==1) 
		        {		      
			       if(rowSArray[i-1].value== rowSArray[i].value) 
			       {
			           rows[i].className = "onchange";
			       } else if (rowSArray[i-1].value!= rowSArray[i].value) 
			       { 
			           u=0;
			           rows[i].className = "default";
			        			      
			       }
			     } else if(rowSArray[i-1].value!= rowSArray[i].value) 
			     {
			         rows[i].className = "onchange";
			         u=1;
			     
			     } else 
			     { 
			       rows[i].className = "default";
			    }
		        
		      } else if(i==0) 
			  {
			    
			    rows[i].className = "default";
			  }
		   }
	 }
	 //used for changing background color when user selects any element in drop down including 'all' option.
	 var v=0;	 
	 for(var i=0,length=k;i<length;i++) 
	 {
		 var row = table.rows[rowArray[i].value];   
	   	  if(i!=0) 
	   	  {		       	        		       
		       if(v==1) 
		        { 
			       if(indexArray[i-1].value== indexArray[i].value) 
			       {
			           row.className = "onchange";
			       } else if (indexArray[i-1].value!= indexArray[i].value) 
			       { 
			           v=0;
			            row.className = "default";
			       }
			     } else if(indexArray[i-1].value!= indexArray[i].value) 
			     {
			         row.className = "onchange";
			         v=1;
			     
			     } else 
			     { 
			        row.className = "default";
			     }
		       		       
			} else if (i==0) 
			{
			   row.className = "default";
			}
	   }
	 
	}

/*-----------------------------------------------------------------------------------------------------------
Name: showAll
Input parm datatype:None
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function showAll() 
{
	for(var i = this.filterRow + 1; i < this.rows.length; i++) 
	{
		this.rows[i].style.display = "";
	}
}

//---------------------------------------------------------------------------------------------------------------
//-----------------------------------------Table Sorting Functions-----------------------------------------------
//---------------------------------------------------------------------------------------------------------------

var sortedOn;
var oldType;
var oldLinkId = {};
/*-----------------------------------------------------------------------------------------------------------
Name: sortTable
Input parm datatype:int,int
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
	function sortTable(sortOn,type,id) 
	{
		if(id != "fake"){
		if(oldLinkId.id != undefined){
			document.getElementById(oldLinkId.id).href= oldLinkId.href
			document.getElementById(oldLinkId.id).onclick= oldLinkId.onclick
			document.getElementById(oldLinkId.id).firstChild.title = oldLinkId.title
		}
		
		oldLinkId.id = id.id;
		oldLinkId.href = id.href;
		oldLinkId.onclick = id.onclick;
		oldLinkId.title = id.firstChild.title
		id.firstChild.title = 'Column already sorted on this'
		id.removeAttribute('href')
		id.removeAttribute('onclick')
		}
		//document.getElementById(id.id).pare
	 	var table = document.getElementById('results');
		var tbody = table.getElementsByTagName('tbody')[0];
		var rows = tbody.getElementsByTagName('tr');
		//Mah
		var valuePresent = false;
		var prevRowValue = "";
		
		var rowArray = new Array();
		var k =0;
		for (var i=0, length=rows.length; i<length; i++) 
		{
			   rowArray[k] = new Object;
			   rowArray[k].oldIndex = i;
			   rowArray[k].value = rows[i].getElementsByTagName('td')[sortOn].innerHTML.trim();
				//Mah
			   if  (rowArray[k].value != null && rowArray[k].value != "-")  {
				     valuePresent = true;
			   }
			   
			   k++;
		}
		if (valuePresent) { 
			//if the current column is sorted already the this will sort in decending order
			if (sortOn != sortedOn || type != oldType) 
			{
				oldType = type;
				sortedOn = sortOn;
				//if our table column number 1,7 are numbers so we are calling funciton RowCompareNumbers
				if(altTable==1)
				{
					if (sortOn == 0 || sortOn == 3+alterTable || sortOn == 4+alterTable || sortOn == 5+alterTable || sortOn == 6+alterTable || sortOn == 7+alterTable || sortOn == 8+alterTable || sortOn == 10+alterTable || sortOn == 16+alterTable ) 
					{
						if(type == 0) 
						{
							rowArray.sort(rowCompareNumbers);
						} else 
						{
							rowArray.sort(rowCompareNumbersReverse);
						}
					}
					else if(sortOn == 16+alterTable) 
					{ 
						if(type == 0) 
						{
							rowArray.sort(rowCompareDollars);
						} else 
						{
							rowArray.sort(rowCompareDollarsReverse);
						}
					} else 
					{
						if(type == 0) 
						{
							rowArray.sort(rowCompare);
						} else 
						{
							rowArray.sort(rowCompareReverse);
						}
				     }
				}
				else
				{
					if (sortOn == 0 || sortOn == 3+alterTable || sortOn == 4+alterTable || sortOn == 5+alterTable || sortOn == 6+alterTable || sortOn == 8+alterTable || sortOn == 15+alterTable) 
					{
						if(type == 0) 
						{
							rowArray.sort(rowCompareNumbers);
						} else 
						{
							rowArray.sort(rowCompareNumbersReverse);
						}
					} 
				
					else if(sortOn == 15+alterTable) 
					{ 
						if(type == 0) 
						{
							rowArray.sort(rowCompareDollars);
						} else 
						{
							rowArray.sort(rowCompareDollarsReverse);
						}
					} else 
					{
						if(type == 0) 
						{
							rowArray.sort(rowCompare);
						} else 
						{
							rowArray.sort(rowCompareReverse);
						}
					}
				}
			}
		}
	    var newTbody = document.createElement('tbody');
		for (var i=0, length=rowArray.length; i<length; i++) 
		{
			newTbody.appendChild(rows[rowArray[i].oldIndex].cloneNode(true));
		}
				
		table.replaceChild(newTbody, tbody);
		
		//change the background color of rows when user clicks on the column heads link.
		
		var sortRows = newTbody.getElementsByTagName('tr');
		var rowSortArray = new Array();
	    var z=0;
		for (var i=0, length=sortRows.length; i<length; i++) 
		{
		   if(sortRows[i].style.display != "none") 
		   {   
			rowSortArray[z] = new Object;
			rowSortArray[z].oldIndex = i;
			rowSortArray[z].value = sortRows[i].getElementsByTagName('td')[sortOn].innerHTML.trim();
			z++;
			}
		}
		  
		var k=0;
		var q=0;
		var y=0;
	
		for(i=0;i<sortRows.length;i++) 
		{   
		    if(sortRows[i].style.display != "none") 
		    {  
		   
		     if(y!=0) 
		     {
		        if(q==1) 
		        { 
			       if(rowSortArray[y-1].value== rowSortArray[y].value) 
			       {
			           sortRows[i].className = "onchange";
			           
			       } else if (rowSortArray[y-1].value!= rowSortArray[y].value) 
			       { 
			           q=0;
			           sortRows[i].className = "default";
			        			      
			       }
			    } else if(rowSortArray[y-1].value!= rowSortArray[y].value) 
			    {
				     sortRows[i].className = "onchange";
			         q=1;
			     
			    } else 
			    { 
			        sortRows[i].className = "default";
			    }
			  } else if(y==0) 
			  {
			     sortRows[i].className = "default";
			  }
			 
			  if(rowSortArray[y].value=="-") 
			  {
		        k++;
		      }
		      y++;
		    }
			
		}//end of for 
		var rowSArray = new Array();
		var f=0;
		var g=0; 
		if(k==rowSortArray.length) 
		{
		  for (var i=0, length=sortRows.length; i<length; i++) 
		  {
		  if(sortRows[i].style.display != "none") 
		  { 
			rowSArray[f] = new Object;
			rowSArray[f].oldIndex = i;
			rowSArray[f].value = sortRows[i].getElementsByTagName('td')[0].innerHTML;
			f++;
			
			}
		  }
		   for(i=0;i<rowSArray.length;i++) 
		   {
		    if(sortRows[i].style.display != "none") 
		    { 
		      sortRows[i].className = "default";
			}
		   }
		}
	
	}
		
//this function is for comparing only for string variables
/*-----------------------------------------------------------------------------------------------------------
Name: rowCompareReverse
Input parm datatype:int,int
Return datatype: int
-------------------------------------------------------------------------------------------------------------*/
	function rowCompareReverse(a, b) 
	{
		var aVal = a.value;
		var bVal = b.value;
		return (aVal.toLowerCase() == bVal.toLowerCase() ? 0 : (aVal.toLowerCase() > bVal.toLowerCase() ? 1 : -1));
	}

	
//this function is for comparing only for Numbers
/*-----------------------------------------------------------------------------------------------------------
Name: rowCompareNumbersReverse
Input parm datatype:int,int
Return datatype: int
-------------------------------------------------------------------------------------------------------------*/
	function rowCompareNumbersReverse(a, b) 
	{
		var aVal = parseInt(a.value);
		var bVal = parseInt(b.value);
		
		if(!Number(aVal)) 
		{
			aVal = 0;
		}
		if(!Number(bVal)) 
		{
			bVal = 0;
		}
		var result = aVal - bVal;

		if(Number(result)) 
		{
			return (result);
		} else 
		{
			return (0);	
		}
	}
	
	
//this function is for comparing values which is starts with $ simble
/*-----------------------------------------------------------------------------------------------------------
Name: rowCompareDollarsReverse
Input parm datatype:int,int
Return datatype: int
-------------------------------------------------------------------------------------------------------------*/
	function rowCompareDollarsReverse(a, b) 
	{
		var aVal = parseFloat(a.value.substr(8)?a.value.substr(8):a.value);
		var bVal = parseFloat(b.value.substr(8)?b.value.substr(8):b.value);
		if(!Number(aVal)) 
		{
			aVal = 0;
		}
		if(!Number(bVal)) 
		{
			bVal = 0;
		}
		var result = aVal - bVal;

		if(Number(result)) 
		{
			return (result);
		} else 
		{
			return (0);	
		}
	}
	

//this function is for comparing only for string variables
/*-----------------------------------------------------------------------------------------------------------
Name: rowCompare
Input parm datatype:int,int
Return datatype: int
-------------------------------------------------------------------------------------------------------------*/
	function rowCompare(a, b) 
	{
       	var aVal = a.value;
		var bVal = b.value;
		return (aVal.toLowerCase() == bVal.toLowerCase() ? 0 : (aVal.toLowerCase() > bVal.toLowerCase() ? -1 : 1));
	}
	
	
//this function is for comparing only for Numbers
/*-----------------------------------------------------------------------------------------------------------
Name: rowCompareNumbers
Input parm datatype:int,int
Return datatype: int
-------------------------------------------------------------------------------------------------------------*/
	function rowCompareNumbers(a, b) 
	{

		var aVal = parseInt(a.value);
		var bVal = parseInt(b.value);
		if(!Number(aVal)) 
		{
			aVal = 0;
			if(bVal == 0){
				aVal = 1;
			}
		}
		if(!Number(bVal)) 
		{
			bVal = 0;
			if(aVal == 0){
				bVal = 1;
			}
		}
		
		var result = bVal - aVal;

		if(Number(result)) 
		{
			return (result);
		} else 
		{
			return (0);
		}
	}

//this function is for comparing values which is starts with $ simble
/*-----------------------------------------------------------------------------------------------------------
Name: rowCompareDollars
Input parm datatype:int,int
Return datatype: int
-------------------------------------------------------------------------------------------------------------*/
	function rowCompareDollars(a, b) 
	{
	
		var aVal = parseFloat(a.value.substr(8)?a.value.substr(8):a.value);
		var bVal = parseFloat(b.value.substr(8)?b.value.substr(8):b.value);
		if(!Number(aVal)) 
		{
			aVal = 0;
		}
		if(!Number(bVal)) 
		{
			bVal = 0;
		}
		
		var result = bVal - aVal;

		if(Number(result)) 
		{
			return (result);
		} else 
		{
			return (0);
		}
		
	}

//---------------------------------------------------------------------------------------------------------------
//---------------------------------Url encode and new window funcitons-------------------------------------------
//---------------------------------------------------------------------------------------------------------------

/*-----------------------------------------------------------------------------------------------------------
Name: goto
Input parm datatype:string
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function goto(targeturl) 
{
	//the targeturl is encoded is we need to decode it
	//there is seperate function for decode the url
	window.open (urlDecode(targeturl),"_blank");
}


/*-----------------------------------------------------------------------------------------------------------
Name: urlDecode
Input parm datatype:string
Return datatype: string
-------------------------------------------------------------------------------------------------------------*/
function urlDecode(encoded) 
{
	// Replace + with ' '
	// Replace %xx with equivalent character
	// Put [ERROR] in output if %xx is invalid.
   var HEXCHARS = "0123456789ABCDEFabcdef"; 
   var encoded = encoded;
   var originalURL = "";
   var i = 0;
   while (i < encoded.length) 
   {
	   var ch = encoded.charAt(i);
	   if (ch == "+") 
	   {
	       originalURL += " ";
		   i++;
	   } else if (ch == "%") 
	   {
			if (i < (encoded.length-2) 
					&& HEXCHARS.indexOf(encoded.charAt(i+1)) != -1 
					&& HEXCHARS.indexOf(encoded.charAt(i+2)) != -1 ) 
					{
				originalURL += unescape( encoded.substr(i,3) );
				i += 3;
			} else 
			{
				alert( 'Bad escape combination near ...' + encoded.substr(i) );
				originalURL += "%[ERROR]";
				i++;
			}
		} else 
		{
		   originalURL += ch;
		   i++;
		}
	} // while
   return (originalURL);
};


/*-----------------------------------------------------------------------------------------------------------
Name: changeStockValue
Input parm datatype:None
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function changeStockValue() 
{

		var stocklist=new Array("not in stock","limited number in stock","available","24h chrono","on order","available within 14 days","available within 28 days");
		var table = document.getElementById('results');
		var tbody = table.getElementsByTagName('tbody')[0];
		var rows = tbody.getElementsByTagName('tr');
	
		var rowArray = new Array();

		for (var i=0, length=rows.length; i<length; i++) 
		{
			rowArray[i] = new Object;
			rowArray[i].value = rows[i].getElementsByTagName('td')[14+alterTable+altTable].firstChild.nodeValue;
			if(!isNumeric(rowArray[i].value)) 
			{
				rows[i].getElementsByTagName('td')[14+alterTable+altTable].innerHTML="-"
			} else 
			{
				rows[i].getElementsByTagName('td')[14+alterTable+altTable].innerHTML = stocklist[rowArray[i].value];
			}
		}
		
}


//This function simply replace &amp: by &
/*-----------------------------------------------------------------------------------------------------------
Name: changeMessage
Input parm datatype:None
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function changeMessage() 
{
 
  var table = document.getElementById('results');
  var tbody = table.getElementsByTagName('tbody')[0];
  var rows = tbody.getElementsByTagName('tr');
 
  var rowArray = new Array();
 
  for (var i=0, length=rows.length; i<length; i++) 
  {
   rowArray[i] = new Object;
   rows[i].getElementsByTagName('td')[10+alterTable+altTable].innerHTML=rows[i].getElementsByTagName('td')[10+alterTable+altTable].innerHTML.replace(/&amp;/g,'&');
   rows[i].getElementsByTagName('td')[13+alterTable+altTable].innerHTML=rows[i].getElementsByTagName('td')[13+alterTable+altTable].innerHTML.replace(/&amp;/g,'&');
  }
}


//This function defines constructor with properties.
/*-----------------------------------------------------------------------------------------------------------
Name: ProdObject
Input parm datatype:String,String
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
// define a constructor with properties
function ProdObject(value,rank) {
   this.value = value;
   this.rank = rank;
}


//This function copies an array into another array.
/*-----------------------------------------------------------------------------------------------------------
Name: copy
Input parm datatype:None
Return datatype: Array
-------------------------------------------------------------------------------------------------------------*/
// Array.copy() - Copy an array
if( typeof Array.prototype.copy==='undefined' ) {
 Array.prototype.copy = function() {
  var a = [], i = this.length;
  while( i-- ) {
   a[i] = typeof this[i].copy!=='undefined' ? this[i].copy() : this[i];
  }
  return a;
 };
}


//This function is used to create rank for all the products.
/*-----------------------------------------------------------------------------------------------------------
Name: changeRankValue
Input parm datatype:None
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function changeRankValue(columnarray) 
{
		var originalcolumnArray = columnarray;
		var originalcolArray = columnarray;
		var table = document.getElementById('results');
		var tbody = table.getElementsByTagName('tbody')[0];
		var rows = tbody.getElementsByTagName('tr');
		var newTbody = document.createElement('tbody');
		var removedOrigColArray = originalcolumnArray.unique();
		var tableColArray = new Array();
		var count = 0;
		var rank = 1;
		var k = 0;
		if(rows.length!=0)
		{
			var totalcolumns = rows[0].getElementsByTagName('td').length;
			var tableColumnArray = new Array();
			//reading column data from table
			for (var i=0, length=rows.length; i<length; i++) 
			{
				tableColumnArray[i] = formatHREF(rows[i].getElementsByTagName('td')[0].innerHTML).trim();
			}
		    
			//Removing duplicate values in a array
		    originalcolumnArray = originalcolumnArray.unique();
			tableColumnArray = tableColumnArray.arrange();
			for (var i=0, length=tableColumnArray.length; i<length; i++) 
			{	
				if(tableColumnArray[i] !=tableColumnArray[i-1] ){
					if(tableColumnArray[i] == originalcolumnArray[count] ){
						newTbody.appendChild(rows[i].cloneNode(true));
						count++;
															
					}else{
							
						var cRow = createEmptyRow(totalcolumns,originalcolumnArray[count]);
						newTbody.appendChild(cRow)
						count++;
						i--;
					}
				}else{
					newTbody.appendChild(rows[i].cloneNode(true));
				}
			}	
		
			for(var k=0;k<originalcolumnArray.length;k++)
			{
				if(count!=originalcolumnArray.length)
				{
					var cRow = createEmptyRow(totalcolumns,originalcolumnArray[count]);
					newTbody.appendChild(cRow)
					count++;
				}
			}
		}
		else
		{
			var totalcolumns=alterTable+16+altTable;
			for(var k=0;k<originalcolumnArray.length;k++)
			{
				if(count!=originalcolumnArray.length)
				{
					var cRow = createEmptyRow(totalcolumns,originalcolumnArray[count]);
					newTbody.appendChild(cRow)
					count++;
				}
			}
		}

		table.replaceChild(newTbody, tbody);
		//Inserting Ranks for the rows
  		var rowss = newTbody.getElementsByTagName('tr');
		var rowArray = new Array();
		var removedDupArray = new Array();
		var rowArr = new Array();
		var dupArray = new Array();
		var rankArray = new Array();
		var k =0;
		for (var i=0, length=rowss.length; i<length; i++) 
		{
			rowArray[i] = new Object;
			rowArray[i].oldIndex = i;
			rowArray[i].value = formatHREF(rowss[i].getElementsByTagName('td')[0].innerHTML);
		}	
		for (var i=0, length=rowss.length; i<length; i++) 
		{
			rowArr[i] = new Object;
			rowArr[i].oldIndex = i;
			rowArr[i].value = formatHREF(rowss[i].getElementsByTagName('td')[0].innerHTML);
		}	

		removedDupArray=rowArr.copy();
		for (var i=0; i<removedDupArray.length - 1; i++)
		{
			for (var j=i+1; j<removedDupArray.length; j++)
			{
				if (removedDupArray[i].value == removedDupArray[j].value)
				removedDupArray[j].value = '';
				
			}
		}
		var k=0;
		for (var m=0; m<removedDupArray.length; m++)
		{
			if (removedDupArray[m].value != '')
			{
                dupArray[k] = new Object;
			    dupArray[k].oldIndex = k;
			    dupArray[k].value=removedDupArray[m].value;
				k++;
			}
		}
	    for (var k=0, length=dupArray.length; k<length; k++) 
		{
			rankArray[k] = new ProdObject(dupArray[k].value,rank);
			rank++;
					
		}	
		
		for (var i=0, length=rowArray.length; i<length; i++) 
		{ 
			for (var k=0, length1=rankArray.length; k<length1; k++) 
			{	
			  	 if(rowArray[i].value==rankArray[k].value)
				 {
					rowss[i].getElementsByTagName('td')[0].innerHTML =rankArray[k].rank;
				 }
			}
           
		}
	sortTable('0',1,"fake")

}


//This function creates an empty row.
/*-----------------------------------------------------------------------------------------------------------
Name: createEmptyRow
Input parm datatype:Int,String
Return datatype: Row
-------------------------------------------------------------------------------------------------------------*/

function createEmptyRow(noOfCol,prNo){
	var row = document.createElement('tr');
	for(var i=0;i<noOfCol;i++){
		var td = document.createElement('td');
		 td.className = "content";
		if(i <= 1){
			td.appendChild(document.createTextNode(prNo));
		}else{
			td.appendChild(document.createTextNode('-'));
		}
		row.appendChild(td);
	}
	return row;
}

//This function will change the background color of rows on product change for default login
/*-----------------------------------------------------------------------------------------------------------
Name: changeRowBackClr
Input parm datatype:None
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function changeRowBackClr() 
{      
	  var table = document.getElementById('results');
	  var tbody = table.getElementsByTagName('tbody')[0];
	  var rows = tbody.getElementsByTagName('tr');
	  var rowArray = new Array();
	  //alert(rows.length);
	  for (var i=0, length=rows.length; i<length; i++) 
	  {
			rowArray[i] = new Object;
			rowArray[i].oldIndex = i;
			rowArray[i].value = rows[i].getElementsByTagName('td')[0].innerHTML;
		
	  }
	  
	 
	//onchange is for blue color and default is for white color.
	var k=0;
	 for(i=0;i<rowArray.length;i++) 
	 {
		   if(i!=0) 
		   {
		        if(k==1) 
		        { 
			      
			       if(rowArray[i-1].value== rowArray[i].value) 
			       {
			           rows[i].className = "onchange";
			           //alert("begin");
			       } else if (rowArray[i-1].value!= rowArray[i].value) 
			       { 
			           k=0;
			           rows[i].className = "default";
			        			      
			       }
			    } else if(rowArray[i-1].value!= rowArray[i].value) 
			    {
			         //alert('begin');
			         rows[i].className = "onchange";
			         k=1;
			     
			    } else 
			    {
			      rows[i].className = "default";
			    }
						
			} else if(i==0) 
			{
		     rows[i].className = "default";
		   }
	 }
	  
}

/*-----------------------------------------------------------------------------------------------------------
Name: openpopup
Input parm datatype:string
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function openpopup(id) 
{
	popOnLoad(id);
}

/*-----------------------------------------------------------------------------------------------------------
Name: openwindow
Input parm datatype:string
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function openwindow(id) 
{
	popOnLoad(id);
}

/*-----------------------------------------------------------------------------------------------------------
Name: popOnLoad
Input parm datatype:string
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/
function popOnLoad(id) 
{
    testwindow= window.open ("http://h20180.www2.hp.com/apps/Lookup?h_pagetype=c-001&h_audience="+ms+"&h_lang="+lc+"&h_cc="+cc+"&h_query="+id, "mywindow","toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes");
}

/*-----------------------------------------------------------------------------------------------------------
Name: addImage
Input parm datatype:None
Return datatype: None
-------------------------------------------------------------------------------------------------------------*/


function addImage() 
{
	var table = document.getElementById('results');
	var thead = table.getElementsByTagName('thead')[0];
	var rows = thead.getElementsByTagName('tr')[0];
	var cels = rows.getElementsByTagName('td');
	for (var i=0, length=cels.length; i<length; i++) 
	{
		var value = cels[i].innerHTML
		if(i != alterTable+12+altTable && i != alterTable+13+altTable)
		cels[i].innerHTML = value + '<div><a id=al'+i+' href="javascript:;" onclick="sortTable('+i+',0,this);"><img src="GetEzbReport/down.gif" border = 0 alt=" " title=" Sort in Descending Order" ></a>  <a id=dl'+i+' href="javascript:;" onclick="sortTable('+i+',1,this);"><img src="GetEzbReport/up.gif" border = 0 alt=" " title="Sort in Ascending Order" ></a></div>'
	}

}

//this funciton checks the given number is whether number or not 
/*-----------------------------------------------------------------------------------------------------------
Name: isNumeric
Input parm datatype:string
Return datatype: bool
-------------------------------------------------------------------------------------------------------------*/
function isNumeric(sText) 
{
var ValidChars = "0123456789.";
var IsNumber=true;
var Char;



for (i = 0; i < sText.length && IsNumber == true; i++) 
{ 
  Char = sText.charAt(i); 
  if (ValidChars.indexOf(Char) == -1) 
  {
     IsNumber = false;
     }
  }
return IsNumber;

}


//this funciton will trim the given string
/*-----------------------------------------------------------------------------------------------------------
Name: trim
Input parm datatype:string
Return datatype: string
-------------------------------------------------------------------------------------------------------------*/
String.prototype.trim = function() {
	return this.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,"");
};


//this funciton will return unique array
/*-----------------------------------------------------------------------------------------------------------
Name: unique
Input parm datatype:Array
Return datatype: Array
-------------------------------------------------------------------------------------------------------------*/

Array.prototype.unique = function( b ) { 
	var tmp = new Array(0), i, l = this.length;

	for(i=0;i<l;i++){
		if(!contains(tmp, this[i])){
			tmp.length+=1;
			tmp[tmp.length-1]=this[i];
		}
	}
	return tmp;
};

function contains(a, e) {
	for(j=0;j<a.length;j++) if(a[j]==e) return true;
	return false;
}

//this funciton will return unique array
/*-----------------------------------------------------------------------------------------------------------
Name: arrange
Input parm datatype:Array
Return datatype: Array
-------------------------------------------------------------------------------------------------------------*/
Array.prototype.arrange = function(  ) {
	var a = [], i,j,count=0, l = this.length;
	var c = this.unique();
	//a[0] = this[0];
	var clength = c.length;
	for( i=0; i<clength; i++ ){
			for( j=i; j<l; j++ ){
				if(c[i] == this[j]){
					a[count] = this[j]
					count++;
				}
			}
	}
	return a;
};

//this funciton will will remove continous string from array
/*-----------------------------------------------------------------------------------------------------------
Name: removeContinuous
Input parm datatype:Array
Return datatype: Array
-------------------------------------------------------------------------------------------------------------*/
Array.prototype.removeContinuous = function() {
	var a = [], i,j,count=0, l = this.length;
	for( i=0; i<l; i++ ) {
			if(this[i] != this[i+1]){
				a[count] = this[i]
				count++;
			}
	}
	return a;
};



//This function shows the pop up for promo information

/*-----------------------------------------------------------------------------------------------------------
Name: showTooltip
Input parm datatype:objecjt, String
Return datatype: 
-------------------------------------------------------------------------------------------------------------*/
	function showTooltip(e,tooltipTxt){
		var temp = new Array();
		temp = tooltipTxt.split(',');
		var tempHTML = '<div><table  border="0" cellspacing="2" cellpadding="2">';
		for(var i = 0;i<temp.length;i++){
			tempHTML += '<tr><td>'+temp[i]+'</td><td>'+temp[++i]+'</td></tr>';
		}
		tempHTML += '</table></div>';
		
		doTooltip(e,tempHTML)
	}

//ver 1.01 @ 190 lins added
//This function shows the pop up for promo information

/*-----------------------------------------------------------------------------------------------------------
Name: showTooltip
Input parm datatype:objecjt, String
Return datatype: 
-------------------------------------------------------------------------------------------------------------*/
	function showTooltip(e,tooltipTxt){
		var temp = new Array();
		temp = tooltipTxt.split(',');
		var tempHTML = '<div><table  border="0" cellspacing="2" cellpadding="2">';
		for(var i = 0;i<temp.length;i++){
			tempHTML += '<tr><td>'+temp[i]+'</td><td>'+temp[++i]+'</td></tr>';
		}
		tempHTML += '</table></div>';
		
		doTooltip(e,tempHTML)
	}


//This function will show the popup messeage for prome
/*-----------------------------------------------------------------------------------------------------------
Name: doTooltip
Input parm datatype:objecjt, String
Return datatype: 
-------------------------------------------------------------------------------------------------------------*/
function doTooltip(e, msg) {
  if ( typeof Tooltip == "undefined" || !Tooltip.ready ) return;
  Tooltip.show(e, msg);
}


//This function will hide the popup messeage for prome
/*-----------------------------------------------------------------------------------------------------------
Name: hideTip
Input parm datatype:objecjt, String
Return datatype: 
-------------------------------------------------------------------------------------------------------------*/
function hideTip() {
  if ( typeof Tooltip == "undefined" || !Tooltip.ready ) return;
  Tooltip.hide();
}
	
	//====================================================================================
	var dw_event = {
  
  add: function(obj, etype, fp, cap) {
    cap = cap || false;
    if (obj.addEventListener) obj.addEventListener(etype, fp, cap);
    else if (obj.attachEvent) obj.attachEvent("on" + etype, fp);
  }, 

  remove: function(obj, etype, fp, cap) {
    cap = cap || false;
    if (obj.removeEventListener) obj.removeEventListener(etype, fp, cap);
    else if (obj.detachEvent) obj.detachEvent("on" + etype, fp);
  }, 

  DOMit: function(e) { 
    e = e? e: window.event;
    e.tgt = e.srcElement? e.srcElement: e.target;
    
    if (!e.preventDefault) e.preventDefault = function () { return false; }
    if (!e.stopPropagation) e.stopPropagation = function () { if (window.event) window.event.cancelBubble = true; }
        
    return e;
  }
  
}


var viewport = {
  getWinWidth: function () {
    this.width = 0;
    if (window.innerWidth) this.width = window.innerWidth - 18;
    else if (document.documentElement && document.documentElement.clientWidth) 
  		this.width = document.documentElement.clientWidth;
    else if (document.body && document.body.clientWidth) 
  		this.width = document.body.clientWidth;
  },
  
  getWinHeight: function () {
    this.height = 0;
    if (window.innerHeight) this.height = window.innerHeight - 18;
  	else if (document.documentElement && document.documentElement.clientHeight) 
  		this.height = document.documentElement.clientHeight;
  	else if (document.body && document.body.clientHeight) 
  		this.height = document.body.clientHeight;
  },
  
  getScrollX: function () {
    this.scrollX = 0;
  	if (typeof window.pageXOffset == "number") this.scrollX = window.pageXOffset;
  	else if (document.documentElement && document.documentElement.scrollLeft)
  		this.scrollX = document.documentElement.scrollLeft;
  	else if (document.body && document.body.scrollLeft) 
  		this.scrollX = document.body.scrollLeft; 
  	else if (window.scrollX) this.scrollX = window.scrollX;
  },
  
  getScrollY: function () {
    this.scrollY = 0;    
    if (typeof window.pageYOffset == "number") this.scrollY = window.pageYOffset;
    else if (document.documentElement && document.documentElement.scrollTop)
  		this.scrollY = document.documentElement.scrollTop;
  	else if (document.body && document.body.scrollTop) 
  		this.scrollY = document.body.scrollTop; 
  	else if (window.scrollY) this.scrollY = window.scrollY;
  },
  
  getAll: function () {
    this.getWinWidth(); this.getWinHeight();
    this.getScrollX();  this.getScrollY();
  }
  
}


var Tooltip = {
    followMouse: true,
    offX: 8,
    offY: 12,
    tipID: "tipDiv",
    showDelay: 100,
    hideDelay: 200,
	ready:false,
	timer:null,
	tip:null,

	init:function(){
		if(document.createElement&&document.body&&typeof document.body.appendChild!="undefined"){
			if(!document.getElementById(this.tipID)){
				var el=document.createElement("DIV");
				el.id=this.tipID;document.body.appendChild(el);
			}
			this.ready=true;
		}
	},
	show:function(e,msg){
		if(this.timer){
			clearTimeout(this.timer);
			this.timer=0;
			}
		if(!this.ttready)return;
		this.tip=document.getElementById(this.tipID);
		if(this.followMouse)dw_event.add(document,"mousemove",this.trackMouse,true);
		this.writeTip("");
		this.writeTip(msg);
		viewport.getAll();
		this.positionTip(e);
		this.timer=setTimeout("Tooltip.toggleVis('"+this.tipID+"', 'visible')",this.showDelay);
	},
	writeTip:function(msg){
		if(this.tip&&typeof this.tip.innerHTML!="undefined")this.tip.innerHTML=msg;
	},
	positionTip:function(e){
		if(this.tip&&this.tip.style){
			var x=e.pageX?e.pageX:e.clientX+viewport.scrollX;
			var y=e.pageY?e.pageY:e.clientY+viewport.scrollY;
			if(x+this.tip.offsetWidth+this.offX>viewport.width+viewport.scrollX){
				x=x-this.tip.offsetWidth-this.offX;
				if(x<0)x=0;
			}else x=x+this.offX;
			if(y+this.tip.offsetHeight+this.offY>viewport.height+viewport.scrollY){
				y=y-this.tip.offsetHeight-this.offY;
				if(y<viewport.scrollY)y=viewport.height+viewport.scrollY-this.tip.offsetHeight;
			}else y=y+this.offY;
			this.tip.style.left=x+"px";
			this.tip.style.top=y+"px";
		}
	},
	hide:function(){
		if(this.timer){
			clearTimeout(this.timer);
			this.timer=0;
		}
		this.timer=setTimeout("Tooltip.toggleVis('"+this.tipID+"', 'hidden')",this.hideDelay);
		if(this.followMouse)dw_event.remove(document,"mousemove",this.trackMouse,true);
		this.tip=null;
	},
	toggleVis:function(id,vis){
		var el=document.getElementById(id);
		if(el)el.style.visibility=vis;
	},
	trackMouse:function(e){
		e=dw_event.DOMit(e);
		Tooltip.positionTip(e);
	}
};
Tooltip.ttready=true;
//ver 1.01 @ 190 lins added ends here