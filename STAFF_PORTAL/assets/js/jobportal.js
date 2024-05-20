
$(document).ready(function(){

	
	jQuery(document).on("click", "#approveJobApplication", function(){
		var application_number = $(this).data("application_number"),
			hitURL = baseURL + "updateJobApplicationStatus",
			currentRow = $(this);
		var confirmation = confirm("Are you sure to approve this Job Application ?");
		if(confirmation) {
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { 
                type:"Approve",
                application_number : application_number, 
            } 

			}).done(function(data){
				// $('#tr'+application_number).html('<b id="tr'+application_number+'" style="color:green">Approved</b>');
				if(data.status = true) { 
					alert("Application Approved Successfully."); 
					window.location.reload();  }
				else if(data.status = false) { alert("Application Approve failed"); }
				else { alert("Access denied..!"); }
			});
		}
    });

    

    jQuery(document).on("click", "#rejectJobApplication", function(){
		var application_number = $(this).data("application_number"),
			hitURL = baseURL + "updateJobApplicationStatus",
            currentRow = $(this);
		var confirmation = confirm("Are you sure to reject this Job Application ?");
		if(confirmation) {
			jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { 
                    type:"Reject",
                    application_number : application_number,
                }

			}).done(function(data){
				// $('#tr'+row_id).html('<b id="tr'+row_id+'" style="color:red">Rejected</b>');
				if(data.status = true) { 
					alert("Application Rejected Successfully.");
					window.location.reload();  }
				else if(data.status = false) { alert("Application Reject Failed"); }
				else { alert("Access denied..!"); }
			});
		}
    });

    
    
    
	jQuery(document).on("click", ".deleteStudentApplication", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteStudentApplication",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Admission Info?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Admission Info successfully deleted"); }
				else if(data.status = false) { alert("Failed to Delete"); }
				else { alert("Access denied..!"); }
			});
		}
	});

    
});