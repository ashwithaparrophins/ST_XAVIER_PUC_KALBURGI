		//delete a staff








		jQuery(document).on("click", ".deleteStaff", function(){


			








			var row_id = $(this).data("row_id"),


				hitURL = baseURL + "deleteStaff",


				currentRow = $(this);


			


			var confirmation = confirm("Are you sure to delete this Staff ?");


			


			if(confirmation)


			{


				jQuery.ajax({


				type : "POST",


				dataType : "json",


				url : hitURL,


				data : { row_id : row_id } 


				}).done(function(data){


					 


					currentRow.parents('tr').remove();


					if(data.status = true) { alert("Staff successfully deleted"); }


					else if(data.status = false) { alert("Staff deletion failed"); }


					else { alert("Access denied..!"); }


				});


			}








		


		});





		// delete staff subject


		jQuery(document).on("click", ".deleteStaffSubject", function(){


			var row_id = $(this).data("row_id"),


				hitURL = baseURL + "deleteStaffSubject",


				currentRow = $(this);


			


			var confirmation = confirm("Are you sure to delete this Subject ?");


			


			if(confirmation)


			{


				jQuery.ajax({


				type : "POST",


				dataType : "json",


				url : hitURL,


				data : { row_id : row_id } 


				}).done(function(data){


					 


					currentRow.parents('tr').remove();


					if(data.status = true) { alert("Subject successfully deleted"); }


					else if(data.status = false) { alert("Subject deletion failed"); }


					else { alert("Access denied..!"); }


				});


			}


		


		});





		


		// delete staff class


		jQuery(document).on("click", ".deleteStaffSection", function(){


			var row_id = $(this).data("row_id"),


				hitURL = baseURL + "deleteStaffSection",


				currentRow = $(this);


			


			var confirmation = confirm("Are you sure to delete this Class ?");


			


			if(confirmation)


			{


				jQuery.ajax({


				type : "POST",


				dataType : "json",


				url : hitURL,


				data : { row_id : row_id } 


				}).done(function(data){


					 


					currentRow.parents('tr').remove();


					if(data.status = true) { alert("Class successfully deleted"); }


					else if(data.status = false) { alert("Class deletion failed"); }


					else { alert("Access denied..!"); }


				});


			}


		


		});

		jQuery(document).on("click", ".deleteStaffRemarkDetails", function(){
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "deleteStaffRemarkDetails",
				currentRow = $(this);
			
			var confirmation = confirm("Are you sure to delete this Remark ?");
			
			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { row_id : row_id } 
				}).done(function(data){
						
					currentRow.parents('tr').remove();
					if(data.status = true) { alert("Remark successfully deleted"); }
					else if(data.status = false) { alert("Remark deletion failed"); }
					else { alert("Access denied..!"); }
				});
			}
		});

		


