



jQuery(document).ready(function(){

	

	jQuery(document).on("click", ".deleteUser", function(){

		var userId = $(this).data("userid"),

			hitURL = baseURL + "deleteUser",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this user ?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { userId : userId } 

			}).done(function(data){

				console.log(data);

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("User successfully deleted"); }

				else if(data.status = false) { alert("User deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});

	

	



	//delete holiday

	jQuery(document).on("click", ".deleteHoliday", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteHoliday",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Holiday ?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

				 

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Holiday successfully deleted"); }

				else if(data.status = false) { alert("Holiday deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}





	

	});





		//delete attendance

		jQuery(document).on("click", ".deleteStaffAttendance", function(){

			var row_id = $(this).data("row_id"),

				hitURL = baseURL + "deleteStaffAttendance",

				currentRow = $(this);

			

			var confirmation = confirm("Are you sure to delete this Attendance ?");

			

			if(confirmation)

			{

				jQuery.ajax({

				type : "POST",

				dataType : "json",

				url : hitURL,

				data : { row_id : row_id } 

				}).done(function(data){

					 

					currentRow.parents('tr').remove();

					if(data.status = true) { alert("Attendance successfully deleted"); }

					else if(data.status = false) { alert("Attendance deletion failed"); }

					else { alert("Access denied..!"); }

				});

			}

		});



	//delete Religion

	jQuery(document).on("click", ".deleteReligion", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteReligion",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Religion ?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

				 

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Religion successfully deleted"); }

				else if(data.status = false) { alert("Religion deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});



	//delete Cast

	jQuery(document).on("click", ".deleteCaste", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteCaste",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Caste?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Caste successfully deleted"); }

				else if(data.status = false) { alert("Caste deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});



	

	//delete Nationality

	jQuery(document).on("click", ".deleteNationality", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteNationality",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Nationality ?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Nationality successfully deleted"); }

				else if(data.status = false) { alert("Nationality deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});



	//delete Category

	jQuery(document).on("click", ".deleteCategory", function(){

		var row_id = $(this).data("row_id"),

		hitURL = baseURL + "deleteCategory",

		currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Category ?");

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Category successfully deleted"); }

				else if(data.status = false) { alert("Category deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});



	jQuery(document).on("click", ".deleteDepartment", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteDepartment",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Department?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Department successfully deleted"); }

				else if(data.status = false) { alert("Department deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});

	

	jQuery(document).on("click", ".deleteStream", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteStream",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Stream?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Stream successfully deleted"); }

				else if(data.status = false) { alert("Stream deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});

	

	jQuery(document).on("click", ".deleteSection", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteSection",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Section?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Section successfully deleted"); }

				else if(data.status = false) { alert("Section deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});



	jQuery(document).on("click", ".deleteClassTimings", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteClassTimings",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Class Time?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Time successfully deleted"); }

				else if(data.status = false) { alert("Time deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});



	

	//delete time table shift info

	jQuery(document).on("click", ".deleteDayShifting", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteDayShifting",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Data?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Record successfully deleted"); }

				else if(data.status = false) { alert("Record deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});



	

	jQuery(document).on("click", ".deleteFeeName", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteFeeName",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Fee Name?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Record successfully deleted"); }

				else if(data.status = false) { alert("Record deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});



	

		//delete candidate 

		jQuery(document).on("click", ".deletePost", function(){

			var post_id = $(this).data("post_id"),

				hitURL = baseURL + "deletePost",

				currentRow = $(this);

			

			var confirmation = confirm("Are you sure to delete this Election Post Name ?");

			

			if(confirmation)

			{

				jQuery.ajax({

				type : "POST",

				dataType : "json",

				url : hitURL,

				data : { post_id : post_id } 

				}).done(function(data){

					 

					currentRow.parents('tr').remove();

					if(data.status = true) { alert("Election Post Name successfully deleted"); }

					else if(data.status = false) { alert("Election Post Name deletion failed"); }

					else { alert("Access denied..!"); }

				});

			}

	

	

		

		});



		//delete candidate 

		jQuery(document).on("click", ".deleteStudentElection", function(){

			var row_id = $(this).data("row_id"),

				hitURL = baseURL + "deleteStudentElection",

				currentRow = $(this);

			

			var confirmation = confirm("Are you sure to delete this Election Candidate ?");

			

			if(confirmation)

			{

				jQuery.ajax({

				type : "POST",

				dataType : "json",

				url : hitURL,

				data : { row_id : row_id } 

				}).done(function(data){

					

					currentRow.parents('tr').remove();

					if(data.status = true) { alert("Election Candidate successfully deleted"); }

					else if(data.status = false) { alert("Election Candidate deletion failed"); }

					else { alert("Access denied..!"); }

				});

			}





		

		});



		

		//delete fee type 

		jQuery(document).on("click", ".deleteFeeType", function(){

			var row_id = $(this).data("row_id"),

				hitURL = baseURL + "deleteFeeType",

				currentRow = $(this);

			

			var confirmation = confirm("Are you sure to delete this Fee Type Info ?");

			

			if(confirmation)

			{

				jQuery.ajax({

				type : "POST",

				dataType : "json",

				url : hitURL,

				data : { row_id : row_id } 

				}).done(function(data){

					 

					currentRow.parents('tr').remove();

					if(data.status = true) { alert("Fee Type Info successfully deleted"); }

					else if(data.status = false) { alert("Fee Type Info deletion failed"); }

					else { alert("Access denied..!"); }

				});

			}

		});



		// news feed

		jQuery(document).on("click", ".deleteNewsFeed", function(){

			var row_id = $(this).data("row_id"),

				hitURL = baseURL + "deleteNewsFeed",

				currentRow = $(this);

			

			var confirmation = confirm("Are you sure to delete this News Feed?");

			

			if(confirmation)

			{

				jQuery.ajax({

				type : "POST",

				dataType : "json",

				url : hitURL,

				data : { row_id : row_id } 

				}).done(function(data){

					 

					currentRow.parents('tr').remove();

					if(data.status = true) { alert("News Feed successfully deleted"); 

					window.location.reload();

				}

					else if(data.status = false) { alert("News Feed deletion failed"); }

					else { alert("Access denied..!"); }

				});

			}

	

	

		

		});



		jQuery(document).on("click", ".deleteStudentRequestDetails", function(){
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "deleteStudentRequestDetails",
				currentRow = $(this);
			
			var confirmation = confirm("Are you sure to delete this request?");
			
			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { row_id : row_id } 
				}).done(function(data){
						
					currentRow.parents('tr').remove();
					if(data.status = true) { alert("Request successfully deleted"); }
					else if(data.status = false) { alert("Request deletion failed"); }
					else { alert("Access denied..!"); }
				});
			}
		});

		jQuery(document).on("click", ".deleteRemarkName", function(){
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "deleteRemarkName",
				currentRow = $(this);
			
			var confirmation = confirm("Are you sure to delete this Remarks Name ?");
			
			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { row_id : row_id } 
				}).done(function(data){
						
					currentRow.parents('tr').remove();
					if(data.status = true) { alert("Remarks Name successfully deleted"); }
					else if(data.status = false) { alert("Remarks Name deletion failed"); }
					else { alert("Access denied..!"); }
				});
			}
		});


		jQuery(document).on("click", ".deleteStudentRemarkDetails", function(){
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "deleteStudentRemarkDetails",
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

		jQuery(document).on("click", ".activeJobPost", function(){

			var row_id = $(this).data("row_id"),
	
				hitURL = baseURL + "activeJobPost",
	
				currentRow = $(this);
			var confirmation = confirm("Are you sure to Activate this Job Post ?");
			if(confirmation)
	
			{
	
				jQuery.ajax({
	
				type : "POST",
	
				dataType : "json",
	
				url : hitURL,
	
				data : { row_id : row_id } 
	
				}).done(function(data){
	
					 
	
					if(data.status = true) { alert("Job Post successfully activated");
					location.reload(); }
	
					else if(data.status = false) { alert("Job Post activation failed");
					location.reload(); }
	
					else { alert("Access denied..!");
					location.reload(); }
	
				});
	
			}
	
		
	
		});
	
		jQuery(document).on("click", ".inactiveJobPost", function(){
	
			var row_id = $(this).data("row_id"),
	
				hitURL = baseURL + "inactiveJobPost",
	
				currentRow = $(this);
	
			var confirmation = confirm("Are you sure to inactivate this Job Post ?");
			if(confirmation)
	
			{
	
				jQuery.ajax({
	
				type : "POST",
	
				dataType : "json",
	
				url : hitURL,
	
				data : { row_id : row_id } 
	
				}).done(function(data){
	
					if(data.status = true) { alert("Job Post successfully inactivated");
					location.reload(); }
	
					else if(data.status = false) { alert("Job Post inactivation failed");
					location.reload(); }
	
					else { alert("Access denied..!");
					location.reload(); }
	
				});
	
			}
	
		
	
		});
		jQuery(document).on("click", ".deleteJobPost", function(){
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "deleteJobPost",
				currentRow = $(this);
			
			var confirmation = confirm("Are you sure to delete this Job Post Info?");
			
			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { row_id : row_id } 
				}).done(function(data){
						
					currentRow.parents('tr').remove();
					if(data.status = true) { alert("Job Post Info successfully deleted"); }
					else if(data.status = false) { alert("Job Post Info deletion failed"); }
					else { alert("Access denied..!"); }
				});
			}
		});
		

});

