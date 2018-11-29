<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Fabelio - Custom Calendar</title>
	<link rel="stylesheet" href="assets/vendor/bootstrap-4/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/f-calendar.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Fabelio Custom Calendar</h1>
				<hr>
				<div class="row justify-content-md-center">
					<div class="col-md-12">
						<h3 class="current-month"><?php echo date('F') . ", " . date('Y') ?></h3>
						<div class="calendar">
							<div class="calendar-header">
								<div>MON</div>
								<div>TUE</div>
								<div>WED</div>
								<div>THU</div>
								<div>FRI</div>
								<div>SAT</div>
								<div>SUN</div>
							</div>
							<?php 
								function getWeeks($date, $rollover) {
					        $cut = substr($date, 0, 8);
					        $daylen = 86400;

					        $timestamp = strtotime($date);
					        $first = strtotime($cut . "00");
					        $elapsed = ($timestamp - $first) / $daylen;

					        $weeks = 1;

					        for ($i = 1; $i <= $elapsed; $i++) {
				            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
				            $daytimestamp = strtotime($dayfind);

				            $day = strtolower(date("l", $daytimestamp));

				            if($day == strtolower($rollover))  $weeks ++;
					        }

					        return $weeks;
						    }

								$weekInMonth = getWeeks(date('Y-m-d'), "monday");
								$dayInWeek = 7;
								$dayInMonthArr = array();
								$firstDay = date('N');
								$numMonth = date('n');
								$calDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $numMonth, date('Y'));

								$day = 1;
								for($j = 0; $j < $weekInMonth; $j++) {
									$weekArr = array();
									for($i = 0; $i < $dayInWeek; $i++) {
										if($j == 0) {
											if($i >= ($firstDay - 1)) {
												array_push($weekArr, $day);
												$day++;
											} else {
												array_push($weekArr, 0);
											}
										} else {
											if($day <= $calDaysInMonth) {
												array_push($weekArr, $day);
												$day++;
											} else {
												array_push($weekArr, 0);
											}
										}
									}

									array_push($dayInMonthArr, $weekArr);
								}

								foreach($dayInMonthArr as $keyWeek => $perWeek) {
									echo '<div class="calendar-body">';

									foreach($perWeek as $keyDay => $perDay) {
										if($perDay == 0) {
											$dataId = "date_0";
											$perDayDesc = "";
										} else {
											if(strlen($perDay) == 1) {
												$perDayDesc = $perDay;
												$dataId = "date_" . date('Y') . "-" . $numMonth . "-0" . $perDay;
											} else {
												$perDayDesc = $perDay;
												$dataId = "date_" . date('Y') . "-" . $numMonth . "-" . $perDay;
											}
										}
										echo '<div class="calendar-day day" data-id="'. $dataId .'">'. $perDayDesc .'</div>';
									}

									echo '</div>';
								}
							 ?>
						</div>
					</div>
				</div>
				<hr>
				<p class="footer">copyright. 2018. frmnqdr.</p>
			</div>
		</div>
	</div>

	<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Add Event</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form id="formAddEvent">
	        	<div class="form-group hidden">
	            <label for="eventId" class="col-form-label">ID:</label>
	            <input type="text" class="form-control" id="eventId" readonly />
	          </div>
	          <div class="form-group">
	            <label for="eventName" class="col-form-label">Name:</label>
	            <input type="text" class="form-control" id="eventName" placeholder="Event Name" />
	          </div>
	          <div class="form-group">
	            <label for="eventTime" class="col-form-label">Time:</label>
	            <input type="time" class="form-control" id="eventTime" />
	          </div>
	          <div class="form-group">
	            <label for="eventInviteesEmail" class="col-form-label">Invitees:</label>
	            <input type="text" class="form-control" id="eventInviteesEmail" placeholder="Invitees" aria-describedby="eventInviteesEmailHelpBlock" />
	            <small id="eventInviteesEmailHelpBlock" class="form-text text-muted">
							  Invitees Email separated by commas.
							</small>
	          </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" id="btnSaveModal">Save</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="eventDetailModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Event Info</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form id="formEventDetail">
	        	<div class="form-group hidden">
	            <label for="eventId" class="col-form-label">ID:</label>
	            <input type="text" class="form-control" id="eventId" readonly />
	          </div>
	          <div class="form-group">
	            <label for="eventName" class="col-form-label">Name:</label>
	            <span id="eventNameSpan"></span>
	          </div>
	          <div class="form-group">
	            <label for="eventTime" class="col-form-label">Time:</label>
	            <span id="eventTimeSpan"></span>
	          </div>
	          <div class="form-group">
	            <label for="eventInviteesEmail" class="col-form-label">Invitees:</label>
	            <span id="eventInviteesSpan"></span>
	          </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" id="btnSaveModal">Save</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script src="assets/vendor/jquery/jquery-3.1.1.min.js"></script>
	<script src="assets/vendor/bootstrap-4/js/bootstrap.min.js"></script>
	<script src="assets/f-calendar.js"></script>
	<script src="assets/f-storage.js"></script>
</body>
</html>