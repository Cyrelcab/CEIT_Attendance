<?php
$event_id = isset($_GET['eid']) ? $_GET['eid'] : '';
$event_year = isset($_GET['year']) ? $_GET['year'] : '';
?>
<style>
	.alert {
		border: 1px solid #f9000059;
		background-color: #f9000059;
	}
</style>
<div class="col-md-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="filter-frm">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label for="event_id">Event</label>
								<select name="event_id" id="event_id" class="custom-select custom-select-sm select2">
									<?php
									$event = $conn->query("SELECT * FROM event_list ORDER BY title ASC");
									while ($row = $event->fetch_assoc()) :
										if (empty($event_id))
											$event_id = $row['id'];
									?>
										<option value="<?php echo $row['id'] ?>" <?php echo $event_id == $row['id'] ? 'selected' : '' ?>>
											<?php echo ucwords($row['title']) ?>
										</option>
									<?php endwhile; ?>
								</select>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label for="course">Course</label>
								<input type="text" name="course" id="course" class="form-control form-control-sm" value="<?php echo isset($_GET['course']) ? $_GET['course'] : ''; ?>" placeholder="Enter course">
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label for="semester">Semester</label>
								<input type="text" name="semester" id="semester" class="form-control form-control-sm" value="<?php echo isset($_GET['semester']) ? $_GET['semester'] : ''; ?>" placeholder="Enter semester">
							</div>
						</div>

						<div class="col-sm-3">
							<div class="form-group">
								<label for="event_year">School Year</label>
								<input type="text" name="event_year" id="event_year" class="form-control form-control-sm" value="<?php echo $event_year; ?>" placeholder="Enter year (e.g., 2002)">
							</div>
						</div>
						<div class="col-sm-2">
							<button class="btn btn-sm btn-primary mt-4"><i class="fa fa-filter"></i> Filter</button>
							<button class="btn btn-sm btn-success mt-4" type="button" onclick="_Print()"><i class="fa fa-print"></i> Print</button>
						</div>
					</div>
				</div>
			</form>
			<hr class="border-primary">
			<?php
			// Fetch the total number of students attending the event
			$total_students_query = $conn->query("SELECT COUNT(*) as total_students 
  FROM event_audience");
			$total_students_row = $total_students_query->fetch_assoc();
			$total_students_attending = $total_students_row['total_students'];

			// Query to count total present attendees for the event
			$present_attendees_query = $conn->query("SELECT COUNT(*) as present_attendees 
  FROM registration_history 
  WHERE event_id = '{$event_id}'");
			$present_attendees_row = $present_attendees_query->fetch_assoc();
			$present_attendees = $present_attendees_row['present_attendees'];

			// Calculate the total non-present attendees
			$non_present_attendees = $total_students_attending - $present_attendees;

			// Query to count total attendees (students and non-students) for the event from the event_audience table
			$total_attendees_query = $conn->query("SELECT COUNT(*) as total_attendees 
  FROM event_audience 
  WHERE event_id = '{$event_id}'");
			$total_attendees_row = $total_attendees_query->fetch_assoc();
			$total_attendees = $total_attendees_row['total_attendees'];



			?>


			<div id="report-tbl-holder">
				<h4 class="text-center">Report</h4>
				<hr>


				<?php
				if (!empty($event_year)) {
					$qry = $conn->query("SELECT * FROM event_list WHERE school_year = '$event_year'");
				} elseif (!empty($event_id)) {
					$qry = $conn->query("SELECT * FROM event_list WHERE id = '$event_id'");
				} else {
					// Add filters for Course and Semester
					$course = isset($_GET['course']) ? $_GET['course'] : '';
					$semester = isset($_GET['semester']) ? $_GET['semester'] : '';

					$qry = $conn->query("SELECT * FROM event_list WHERE course = '$course' AND semester = '$semester'");
				}
				while ($row = $qry->fetch_assoc()) :
					$event_id = $row['id'];
				?>
					<div class="callout">
						<div class="row">
							<div class="col-md-6">
								<dl>
									<dt>Event Title</dt>
									<dd><?php echo $row['title'] ?></dd>
								</dl>
								<dl>
									<dt>Event Venue</dt>
									<dd><?php echo $row['venue'] ?></dd>
								</dl>
								<dl>
									<dt>Semester</dt>
									<dd><?php echo $row['semester'] ?></dd>
								</dl>
								<dl>
									<dt>School Year</dt>
									<dd><?php echo $row['school_year'] ?></dd>
								</dl>
								<dl>
									<dt>Course</dt>
									<dd><?php echo $row['course'] ?></dd>
								</dl>
								<dl>
									<dl>
										<dt>Year Level</dt>
										<dd><?php echo $row['year_level'] ?></dd>
									</dl>
									<dl>
										<dt>Event Description</dt>
										<dd><?php echo $row['description'] ?></dd>
									</dl>
							</div>
							<div class="col-md-6">
								<dl>
									<dt>Event Start</dt>
									<dd><?php echo date("M d, Y h:i A", strtotime($row['datetime_start'])) ?></dd>
								</dl>
								<dl>
									<dt>Event End</dt>
									<dd><?php echo date("M d, Y h:i A", strtotime($row['datetime_end'])) ?></dd>
								</dl>

								<?php if ($row['limit_registration'] == 1) : ?>
									<dl>
										<dt>Registration Cut-off Time</dt>
										<dd><?php echo date("M d, Y h:i A", strtotime($row['datetime_end'] . ' + ' . $row['limit_time'] . ' minutes')) ?></dd>
									</dl>

								<?php endif; ?>

								<dl>
									<dt>Total List of Students: <?php echo $total_students_attending ?></dt>
								</dl>
								<dl>
									<dt>Total Assigned Present Attendees: <?php echo $present_attendees ?></dt>
								</dl>
								<dl>
									<dt>Total Non-Assigned Attendees: <?php echo $non_present_attendees ?></dt>
								</dl>

								</dl>


							</div>
						</div>
					</div>
					<label for="audience_id">Search</label>
					<input type="text" id="searchInput" placeholder="Search for names.." class="form-control form-control-sm mb-2">
					<table id="report-tbl" class="table table-stripped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Date/Time</th>
								<th>Name</th>
								<th>ID No.</th>
								<th>Course</th>
								<th>Year Level</th>
								<th>Contact</th>
								<th>Email</th>
							</tr>
						</thead>

						<tbody>
							<?php
							$i = 1;
							$registration_query = $conn->query("SELECT a.*, r.id as rid, r.date_created as rdate FROM registration_history r INNER JOIN event_audience a ON a.id = r.audience_id WHERE r.event_id = '{$event_id}' ORDER BY r.id ASC");
							while ($row = $registration_query->fetch_assoc()) :
							?>
								<tr>
									<td class="text-center"><?php echo $i++; ?></td>
									<td><?php echo date("M d, Y h:i A", strtotime($row['rdate'])) ?></td>
									<td><?php echo ucwords($row['name']) ?></td>
									<td><?php echo ucwords($row['schoolid']) ?></td>
									<td><?php echo ucwords($row['course']) ?></td>

									<td><?php echo ucwords($row['year_level']) ?></td>
									<td><?php echo ucwords($row['contact']) ?></td>
									<td><?php echo ucwords($row['email']) ?></td>

								</tr>
							<?php endwhile; ?>
							<?php if ($registration_query->num_rows <= 0) : ?>
								<tr>
									<th class="text-center" colspan="8">No Data.</th>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
					<hr>
				<?php endwhile; ?>
			</div>
		</div>
	</div>

	<noscript>
		<style>
			table {
				border-collapse: collapse;
				width: 100%;
			}

			tr,
			td,
			th {
				border: 1px solid black;
			}

			td,
			th {
				padding: 3px;
			}

			.text-center {
				text-align: center;
			}

			.text-right {
				text-align: right;
			}

			p {
				margin: unset;
			}

			.alert {
				border: 1px solid #f9000059;
				background-color: #f9000059;
			}
		</style>
	</noscript>
	<script>
		function _Print() {
			start_loader();
			var ns = $('noscript').clone();
			var report = $('#report-tbl-holder').clone();
			var head = $('head').clone();

			var _html = report.prepend(ns.html());
			_html.prepend(head);
			var nw = window.open('', '_blank', "height=900,width=1200");
			nw.document.write(_html.html());
			nw.document.close();
			nw.print();

			setTimeout(function() {
				nw.close();
				end_loader();
			});
		}

		$(document).ready(function() {
			$('.select2').select2();
			$('#filter-frm').submit(function(e) {
				e.preventDefault();
				var event_id = $('#event_id').val();
				var event_year = $('#event_year').val();
				var url = _base_url_ + 'admin/?page=reports';
				if (event_id) {
					url += '&eid=' + event_id;
				}
				if (event_year) {
					url += '&year=' + event_year;
				}
				location.replace(url);
			});
		});
	</script>
	<script>
		$(document).ready(function() {
			$('#searchInput').on('input', function() {
				var keywords = $(this).val().toLowerCase().split(" ");
				$('#report-tbl tbody tr').each(function() {
					var rowText = $(this).text().toLowerCase();
					var showRow = true;
					for (var i = 0; i < keywords.length; i++) {
						if (rowText.indexOf(keywords[i]) === -1) {
							showRow = false;
							break;
						}
					}
					$(this).toggle(showRow);
				});
			});
		});
	</script>

</div>