function renderAllEvent(allEvent) {
	try{
		allEventLen = allEvent.length
		for(var i = 0; i < allEventLen; i++) {
			var dataId = allEvent[i].id,
					dataName = allEvent[i].name,
					dataTime = allEvent[i].time,
					dataInvitees = allEvent[i].invitees;
			var maxNameLen = 20;

			if(dataName.length > maxNameLen) {
				dataName = dataName.substring(0, maxNameLen) + "...";
			}

			var bgColor = generateBgColor();
			var eventAppend = '<div class="badge badge-info daily-event" style="width: 100%; background-color: '+ bgColor +'" data-name="'+ dataName +'" data-time="'+ dataTime +'" data-invitees="'+ dataInvitees +'">'+ dataName +'</div>';

			$('.calendar-day[data-id="'+ dataId +'"]').append(eventAppend);
		}
	} catch(err) {
		console.log("All Event is empty...");
	}
}

function generateBgColor() {
	var colors = ['#f44242', '#f49541', '#f4df41', '#8ef441', '#41f4b2', '#41caf4', '#4641f4', '#9a41f4', '#f441b5', '#1c1c1c'];
	var randomColor = colors[Math.floor(Math.random() * colors.length)];

	return randomColor;
}

$(document).ready(function() {
	var allEvent = [];
	
	allEvent = JSON.parse(sessionStorage.getItem("pageData"));
	if(allEvent == null) {
		allEvent = [];
	}
	
	$('.daily-event').remove();
	renderAllEvent(allEvent);

	$('div.calendar-day').click(function() {
		var id = $(this).data('id');

		if(! id.includes("_0")) {
			$('form#formAddEvent')[0].reset();
			$('input#eventId').val(id);
			$('#addEventModal').modal('show'); 
		}
	});

	$('button#btnSaveModal').click(function() {
		var event = {};
		var id = $('input#eventId').val();
		var name = $('input#eventName').val();
		var time = $('input#eventTime').val();
		var invitees = $('input#eventInviteesEmail').val();

		console.log('id='+id+',name='+name+', time='+time+', invitees='+invitees);

		event["id"] = id;
		event["name"] = name;
		event["time"] = time;
		event["invitees"] = invitees;
		allEvent.push(event);

		saveData('pageData', allEvent);

		$('#addEventModal').modal('toggle');

		$('.daily-event').remove();
		renderAllEvent(allEvent);
	});

	$('div.daily-event').click(function() {
		var evtName = $(this).data('name'),
				evtTime = $(this).data('time'),
				evtInvitees = $(this).data('invitees');

		$('span#eventNameSpan').html(evtName);
		$('span#eventTimeSpan').html(evtTime);
		$('span#eventInviteesSpan').html(evtInvitees);
	});
});