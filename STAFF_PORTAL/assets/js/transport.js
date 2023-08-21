
$(document).ready(function(){
    

    //delete a Bus
    jQuery(document).on("click", ".deleteBus", function(){
        
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteBus",
            currentRow = $(this);
        
        var confirmation = confirm("Are you sure to delete this Bus ?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){
                    
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("Bus Info successfully deleted"); }
                else if(data.status = false) { alert("Bus Info deletion failed"); }
                else { alert("Access denied..!"); }
            });
        }
    });

    //delete a Tyre Info
    jQuery(document).on("click", ".deleteTyre", function(){
        
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteTyre",
            currentRow = $(this);
        
        var confirmation = confirm("Are you sure to delete this Tyre Info ?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){
                    
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("Tyre Info successfully deleted"); }
                else if(data.status = false) { alert("Tyre Info deletion failed"); }
                else { alert("Access denied..!"); }
            });
        }
    });

    
//delete a Fuel Info
jQuery(document).on("click", ".deleteFuel", function(){
    
    var row_id = $(this).data("row_id"),
        hitURL = baseURL + "deleteFuel",
        currentRow = $(this);
    
    var confirmation = confirm("Are you sure to delete this Fuel Info ?");
    
    if(confirmation)
    {
        jQuery.ajax({
        type : "POST",
        dataType : "json",
        url : hitURL,
        data : { row_id : row_id } 
        }).done(function(data){
                
            currentRow.parents('tr').remove();
            if(data.status = true) { alert("Fuel Info successfully deleted"); }
            else if(data.status = false) { alert("Fuel Info deletion failed"); }
            else { alert("Access denied..!"); }
        });
    }
});

    //delete a Tyre Info
    jQuery(document).on("click", ".deleteTrip", function(){
    
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteTrip",
            currentRow = $(this);
        
        var confirmation = confirm("Are you sure to delete this Trip Info ?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){
                    
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("Trip Info successfully deleted"); }
                else if(data.status = false) { alert("Trip Info deletion failed"); }
                else { alert("Access denied..!"); }
            });
        }
    });

        


    jQuery(document).on("click", ".deleteStudentTransport", function(){
        
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteStudentTransport",
            currentRow = $(this);
        
        var confirmation = confirm("Are you sure to delete this Student Transport Info?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){
                    
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("Student Transport Info successfully deleted"); }
                else if(data.status = false) { alert("Student Transport Info deletion failed"); }
                else { alert("Access denied..!"); }
            });
        }
    });

    //delete a Spare Info
    jQuery(document).on("click", ".deleteSpare", function(){
        
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteSpare",
            currentRow = $(this);
        
        var confirmation = confirm("Are you sure to delete this Spare Info ?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){
                    
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("Spare Info successfully deleted"); }
                else if(data.status = false) { alert("Spare Info deletion failed"); }
                else { alert("Access denied..!"); }
            });
        }
    });

    //delete a Service Info
    jQuery(document).on("click", ".deleteService", function(){
        
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteService",
            currentRow = $(this);
        
        var confirmation = confirm("Are you sure to delete this Service Info ?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){
                    
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("Service Info successfully deleted"); }
                else if(data.status = false) { alert("Service Info deletion failed"); }
                else { alert("Access denied..!"); }
            });
        }
    });

    //delete a Tyre Info
jQuery(document).on("click", ".deleteTransportName", function(){
    
    var row_id = $(this).data("row_id"),
        hitURL = baseURL + "deleteTransportName",
        currentRow = $(this);
    
    var confirmation = confirm("Are you sure to delete this Transport Info ?");
    
    if(confirmation)
    {
        jQuery.ajax({
        type : "POST",
        dataType : "json",
        url : hitURL,
        data : { row_id : row_id } 
        }).done(function(data){
                
            currentRow.parents('tr').remove();
            if(data.status = true) { alert("Transport Info successfully deleted"); }
            else if(data.status = false) { alert("Transport Info deletion failed"); }
            else { alert("Access denied..!"); }
        });
    }
});



});


