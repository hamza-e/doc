"use strict";

var workingDays;

$.ajax({url: get_list_rendezvous,
dataType: 'json',
contentType: 'application/json',
async: false,
success:function(data) {
	listRendezVous = data.listRV;
	workingDays = data.businessDays;
}});

$('#calendar').fullCalendar({
	header: {
		left: 'prev',
		center: 'title',
		right: 'next'
	},
	defaultDate: new Date(),
	editable: true,
	droppable: true, // this allows things to be dropped onto the calendar
	slotDuration: '00:'+rendezvous_duree+':00',
	drop: function() {
		// is the "remove after drop" checkbox checked?
		if ($('#drop-remove').is(':checked')) {
			// if so, remove the element from the "Draggable Events" list
			$(this).remove();
		}
	},
	eventLimit: true, // allow "more" link when too many events
	events: listRendezVous,
	businessHours: {
		dow: workingDays,
		start: '00:00',
		end: '23:59'
	},
	eventConstraint:"businessHours",
	eventDrop: function(event, delta, revertFunc,resourceId) {

	    //alert(event.title + " was dropped on " + event.start.format());
	    console.log(event.title+" was dropped on " + event.start.format());
	    if (!confirm("Êtes-vous sûr de modifier le rendez vous à la date "+ event.start.format())) {
	      revertFunc(); //returner à la date initial lors de l'annulation du drop
	    }else{
			//modification de la date du rendez vous 
	    	$.ajax({url: edit_list_ondrop,
				dataType: 'json',
				contentType: 'application/json',
				async: false,
				data: {id: event.id,date : event.start.format()},
				success:function(data) {
						console.log(data);
					if( data.status == 'ok'){
						alert('Rendez vous modifié !!!');
					}else if(data.status == 'pris'){
						revertFunc();
						alert('Date Déja pris');
					}else if(data.status == 'out'){
						revertFunc();
						alert('Hors horaire');
					}
				}
			});
	    }
	},
	dayClick: function (date, jsEvent, view) {
		//$(this).css('border-color', 'red');
		var res = date.format().split('T');
		if(!$(jsEvent.target).hasClass('fc-bgevent')){
			$.ajax({url: route_checkdispo,
	            dataType: 'json',
	            contentType: 'application/json',
	            async: true,
	            data:{date:res[0]},
	            success:function(data) {
	                console.log(data);
	                $('#dispoHours2').children('option').remove();
	                for (var i = 0; i < data.length; i++) {
	                	var t = (res[1] == data[i]) ? "selected":"";
	                    $('#dispoHours2').append(
	                        '<option value="'+data[i]+'" '+t+'>'+data[i]+'</option>'
	                    );
	                }
	                $('#dispoHours').children('option').remove();
	                for (var i = 0; i < data.length; i++) {
	                	var t = (res[1] == data[i]) ? "selected":"";
	                    $('#dispoHours').append(
							'<option value="'+data[i]+'" '+t+'>'+data[i]+'</option>'
	                    	);
	                }
	            }
	        });
			$('#date').val(res[0]);
			$('#date2').val(res[0]);
			$('#modalAdd').modal();
		}
	},
	eventClick: function(calEvent, jsEvent, view) {

		console.log('Event: ' + calEvent.id);
		console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
		console.log('View: ' + view.name);
		
    //change the border color
    //$(this).css('border-color', 'red');

  }

});

// Hide default header
//$('.fc-header').hide();


// Previous month action
$('#cal-prev').click(function(){
	$('#calendar').fullCalendar( 'prev' );
});

// Next month action
$('#cal-next').click(function(){
	$('#calendar').fullCalendar( 'next' );
});

// Change to month view
$('#change-view-month').click(function(){
	$('#calendar').fullCalendar('changeView', 'month');

	// safari fix
	$('#content .main').fadeOut(0, function() {
		setTimeout( function() {
			$('#content .main').css({'display':'table'});
		}, 0);
	});

});

// Change to week view
$('#change-view-week').click(function(){
	$('#calendar').fullCalendar( 'changeView', 'agendaWeek');

	// safari fix
	$('#content .main').fadeOut(0, function() {
		setTimeout( function() {
			$('#content .main').css({'display':'table'});
		}, 0);
	});

});

// Change to day view
$('#change-view-day').click(function(){
	$('#calendar').fullCalendar( 'changeView','agendaDay');

	// safari fix
	$('#content .main').fadeOut(0, function() {
		setTimeout( function() {
			$('#content .main').css({'display':'table'});
		}, 0);
	});

});

// Change to today view
$('#change-view-today').click(function(){
	$('#calendar').fullCalendar('today');
});

/* initialize the external events
 -----------------------------------------------------------------*/
$('#external-events .event-control').each(function() {

	// store data so the calendar knows to render an event upon drop
	$(this).data('event', {
		title: $.trim($(this).text()), // use the element's text as the event title
		stick: true // maintain when user navigates (see docs on the renderEvent method)
	});

	// make the event draggable using jQuery UI
	$(this).draggable({
		zIndex: 999,
		revert: true,      // will cause the event to go back to its
		revertDuration: 0  //  original position after the drag
	});

});

$('#external-events .event-control .event-remove').on('click', function(){
	$(this).parent().remove();
});

// Submitting new event form
$('#add-event').submit(function(e){
	e.preventDefault();
	var form = $(this);

	var newEvent = $('<div class="event-control p-10 mb-10">'+$('#event-title').val() +'<a class="pull-right text-muted event-remove"><i class="fa fa-trash-o"></i></a></div>');

	$('#external-events .event-control:last').after(newEvent);

	$('#external-events .event-control').each(function() {

		// store data so the calendar knows to render an event upon drop
		$(this).data('event', {
			title: $.trim($(this).text()), // use the element's text as the event title
			stick: true // maintain when user navigates (see docs on the renderEvent method)
		});

		// make the event draggable using jQuery UI
		$(this).draggable({
			zIndex: 999,
			revert: true,      // will cause the event to go back to its
			revertDuration: 0  //  original position after the drag
		});

	});

	$('#external-events .event-control .event-remove').on('click', function(){
		$(this).parent().remove();
	});

	form[0].reset();

	$('#cal-new-event').modal('hide');

});
