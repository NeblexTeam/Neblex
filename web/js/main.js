window.onload = function() {
	let loaded = document.getElementsByTagName("body")[0];
	loaded.className = "loaded";
};

$(function() {
	let modal = $('[id^="modal-wrapper-"]');
	let input = $('[id^="input-"]');
	window.onclick = function(event){
		for(let i=0; i<modal.length;i++){
			if (event.target == modal[i]){
				modal[i].style.display = "none";
				input[i].disabled = "true";
			}
		}		
		for(let i=0; i< input.length;i++){
			//input[i].disabled = "true";

		}		
	}

});	

	/* ONCHANGE FUNCTION IN EXCHANGE.PHP */
	function totalPrice(transactionType){
		document.getElementById(transactionType + "Button").className = "btn-large btn-gray"
		document.getElementById(transactionType + "Button").disabled = true;

		totalValue = parseFloat(document.getElementById(transactionType + "Price").value * document.getElementById(transactionType + "Order").value).toFixed(8);

		document.getElementById(transactionType + "Total").innerHTML = totalValue ;
		if(document.getElementById(transactionType + "Price").value != "" && document.getElementById(transactionType + "Order").value != "")
		{
			document.getElementById(transactionType + "Button").disabled = false;
			if(transactionType == "buy")
			{
				comaRemover = document.getElementById(transactionType + "_Maximum").innerHTML;
				comaRemover = comaRemover.replace(/,/g, "");
				floatvalue = parseFloat(comaRemover);
				document.getElementById(transactionType + "Button").className = "btn-large btn-green"
				if(totalValue > floatvalue)
				{
					document.getElementById(transactionType + "Button").className = "btn-large btn-gray"
					document.getElementById(transactionType + "Button").disabled = true;
				}
			}
			else
			{
				comaRemover = document.getElementById(transactionType + "_Maximum").innerHTML;
				comaRemover = comaRemover.replace(/,/g, "");
				floatvalue = parseFloat(comaRemover);
				document.getElementById(transactionType + "Button").className = "btn-large btn-red"
				if(parseFloat(document.getElementById(transactionType + "Order").value) > floatvalue)
				{
					document.getElementById(transactionType + "Button").className = "btn-large btn-gray"
					document.getElementById(transactionType + "Button").disabled = true;
				}
			}
		}
	}

	function sortTable(col, id) {
		let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
		table = document.getElementById(id);
		switching = true;
		dir = "asc"; 
		while (switching) {
		  switching = false;
		  rows = table.getElementsByTagName("TR");
		  for (i = 1; i < (rows.length - 1); i++) {
			shouldSwitch = false;
			x = rows[i].getElementsByTagName("TD")[col];
			y = rows[i + 1].getElementsByTagName("TD")[col];
			if (dir == "asc") {
			  if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
				shouldSwitch= true;
				break;
			  }
			} else if (dir == "desc") {
			  if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
				shouldSwitch = true;
				break;
			  }
			}
		  }
		  if (shouldSwitch) {
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
			switchcount ++;      
		  } else {
			if (switchcount == 0 && dir == "asc") {
			  dir = "desc";
			  switching = true;
			}
		  }
		}
	}
	  
	function filterTable(idInput, idTable, col) {
		var input, filter, table, tr, td, i;
		input = document.getElementById(idInput);
		filter = input.value.toUpperCase();
		table = document.getElementById(idTable);
		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
		 	td = tr[i].getElementsByTagName("td")[col];
		  	if (td) {
				if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
				} else {
				tr[i].style.display = "none";
				}
		 	}       
		}
		if(idTable == "tableOrderHistory"){
			if(col == 0)
			{
				document.getElementById("inputPair").value = "";
				document.getElementById("inputType").value = "";
			}
			if(col == 1)
			{
				document.getElementById("inputDate").value = "";
				document.getElementById("inputType").value = "";
			}
			if(col == 2)
			{
				document.getElementById("inputDate").value = "";
				document.getElementById("inputPair").value = "";
			}
		}
	}

	// function hideRow(idTable, filter, col) {
	// 	var input, table, tr, td, i;
	// 	table = document.getElementById(idTable);
	// 	tr = table.getElementsByTagName("tr");
	// 	for (i = 0; i < tr.length; i++) {
	// 		/* col = 7 for order history and 2 for balance */
	// 	  td = tr[i].getElementsByTagName("td")[col];
	// 	  if (td) {
	// 		if (td.innerHTML == filter) {
	// 		  tr[i].style.display = "";
	// 		} else {
	// 		  tr[i].style.display = "none";
	// 		}
	// 	  }       
	// 	}
	// }