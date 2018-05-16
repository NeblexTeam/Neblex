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
				if(totalValue > floatvalue )
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
				if(parseFloat(document.getElementById(transactionType + "Order").value) > floatvalue )
				{
					document.getElementById(transactionType + "Button").className = "btn-large btn-gray"
					document.getElementById(transactionType + "Button").disabled = true;
				}
			}
		}
	}
