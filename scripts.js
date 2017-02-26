function print_id(id){

	// $.ajax({
	//     url: './buy.php',
	//     type: 'POST',
	//     data: {id: id},
	//     success: function( response ){
	//     	alert("SUCCESS: "+response);
	//     	window.location.href = "./buy.php";
	//     },
	//     error: function( response ){
	//     	alert("ERROR: "+response);
	//     }
	// });

	window.location.href = "./buy.php?id="+id;
}