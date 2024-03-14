jQuery(document).ready(function(){



	//delete fees structure

	jQuery(document).on("click", ".deleteFeeStrtucture", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteFeeStrtucture",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Fees?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Fees successfully deleted"); }

				else if(data.status = false) { alert("Fees deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});

	

	

    jQuery(document).on("click", ".approveConcession", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "approveConcession",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to Approve this request?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

				

				if(data.status = true) { alert("Request successfully Approved");

				window.location.reload() }

				else if(data.status = false) { alert("Failed to approve request"); }

				else { alert("Access denied..!"); }

			});

		}

	});

	

	

    jQuery(document).on("click", ".rejectConcession", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "rejectConcession",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to Reject this request?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){



				if(data.status = true) { alert("Request successfully Rejected"); 

				window.location.reload()}

				else if(data.status = false) { alert("Failed to reject request"); }

				else { alert("Access denied..!"); }

			});

		}

	});

	jQuery(document).on("click", ".approveScholarship", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "approveScholarship",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to Approve this request?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

				

				if(data.status = true) { alert("Request successfully Approved");

				window.location.reload() }

				else if(data.status = false) { alert("Failed to approve request"); }

				else { alert("Access denied..!"); }

			});

		}

	});

	

	

    jQuery(document).on("click", ".rejectScholarship", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "rejectScholarship",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to Reject this request?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){



				if(data.status = true) { alert("Request successfully Rejected"); 

				window.location.reload()}

				else if(data.status = false) { alert("Failed to reject request"); }

				else { alert("Access denied..!"); }

			});

		}

	});


    // delete Fee Installment

	jQuery(document).on("click", ".deleteFeeInstallment", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteFeeInstallment",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Fee Instalment Info?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Fee Instalment successfully deleted"); }

				else if(data.status = false) { alert("Fee Instalment deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});



	// delete Management Fee

	jQuery(document).on("click", ".deleteMngtFee", function(){

		var row_id = $(this).data("row_id"),

			hitURL = baseURL + "deleteMngtFee",

			currentRow = $(this);

		

		var confirmation = confirm("Are you sure to delete this Management Fee?");

		

		if(confirmation)

		{

			jQuery.ajax({

			type : "POST",

			dataType : "json",

			url : hitURL,

			data : { row_id : row_id } 

			}).done(function(data){

					

				currentRow.parents('tr').remove();

				if(data.status = true) { alert("Management Fee successfully deleted"); }

				else if(data.status = false) { alert("Management Fee deletion failed"); }

				else { alert("Access denied..!"); }

			});

		}

	});



});