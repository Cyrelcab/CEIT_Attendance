<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<?php
// Fetch specific columns in the database
$qry = $conn->query("SELECT DISTINCT title FROM event_list ORDER BY title ASC");
$sy_qry = $conn->query("SELECT DISTINCT school_year FROM event_list ORDER BY school_year ASC");
$semester_qry = $conn->query("SELECT DISTINCT semester FROM event_list ORDER BY semester ASC");
$department_qry = $conn->query("SELECT DISTINCT department FROM event_list ORDER BY department ASC");
$course_qry = $conn->query("SELECT DISTINCT course FROM event_list ORDER BY course ASC");
$yrlevel_qry = $conn->query("SELECT DISTINCT year_level FROM event_list ORDER BY year_level ASC");
?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_event" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table table-hover table-bordered" id="list">
				<div class="d-flex justify-content-center align-items-center">
					<form id="filterForm" action="" method="GET">
						<div class="row">
							<!-- this is for the title dropdown-->
							<div class="col-md-2 mx-2 mb-3">
								<select name="title" id="">
									<option value="default" selected>Title</option>
									<?php
									while ($row = $qry->fetch_assoc()) {
										$title = ucwords($row['title']);
										$selected = (isset($_GET['title']) && $_GET['title'] == $title) ? 'selected' : '';
										echo '<option value="' . $title . '" ' . $selected . '>' . $title . '</option>';
									}
									?>
								</select>
							</div>

							<!-- this is for the school year dropdown--->
							<div class="col-md-2 mx-2 mb-3">
								<select name="school_year" id="">
									<option value="default" selected>School Year</option>
									<?php
									// Reset pointer to start of data
									$sy_qry->data_seek(0);
									while ($row = $sy_qry->fetch_assoc()) {
										$school_year = ucwords($row['school_year']);
										$selected = (isset($_GET['school_year']) && $_GET['school_year'] == $school_year) ? 'selected' : '';
										echo '<option value="' . $school_year . '" ' . $selected . '>' . $school_year . '</option>';
									}
									?>
								</select>
							</div>

							<!-- this is for the semester dropdown --->
							<div class="col-md-2 mx-2 mb-3">
								<select name="semester" id="">
									<option value="default" selected>Semester</option>
									<?php
									// Reset pointer to start of data
									$semester_qry->data_seek(0);
									while ($row = $semester_qry->fetch_assoc()) {
										$semester = ucwords($row['semester']);
										$selected = (isset($_GET['semester']) && $_GET['semester'] == $semester) ? 'selected' : '';
										echo '<option value="' . $semester . '" ' . $selected . '>' . $semester . '</option>';
									}
									?>
								</select>
							</div>

							<!-- this is for the department dropdown--->
							<div class="col-md-2 mx-2 mb-3">
								<select name="department" id="">
									<option value="default" selected>Department</option>
									<?php
									// Reset pointer to start of data
									$department_qry->data_seek(0);
									while ($row = $department_qry->fetch_assoc()) {
										$department = ucwords($row['department']);
										$selected = (isset($_GET['department']) && $_GET['department'] == $department) ? 'selected' : '';
										echo '<option value="' . $department . '" ' . $selected . '>' . $department . '</option>';
									}
									?>
								</select>
							</div>

							<!-- this is for the course dropdown -->
							<div class="col-md-2 mx-2 mb-3">
								<select name="course" id="">
									<option value="default" selected>Course</option>
									<?php
									// Reset pointer to start of data
									$course_qry->data_seek(0);
									while ($row = $course_qry->fetch_assoc()) {
										$course = ucwords($row['course']);
										$selected = (isset($_GET['course']) && $_GET['course'] == $course) ? 'selected' : '';
										echo '<option value="' . $course . '" ' . $selected . '>' . $course . '</option>';
									}
									?>
								</select>
							</div>

							<!-- this is for the year level dropdown -->
							<div class="col-md-2 mx-2 mb-3">
								<select name="year_level" id="">
									<option value="default" selected>Year Level</option>
									<?php
									// Reset pointer to start of data
									$yrlevel_qry->data_seek(0);
									while ($row = $yrlevel_qry->fetch_assoc()) {
										$year_level = ucwords($row['year_level']);
										$selected = (isset($_GET['year_level']) && $_GET['year_level'] == $year_level) ? 'selected' : '';
										echo '<option value="' . $year_level . '" ' . $selected . '>' . $year_level . '</option>';
									}
									?>
								</select>
							</div>

							<!--button for filter data-->
							<div class="col-md-2 mx-2 mb-3">
								<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-filter"></i> Filter</button>
							</div>
						</div>
					</form>


				</div>


				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Title</th>
						<th>Venue</th>
						<th>School Year</th>
						<th>Semester</th>
						<th>Department</th>
						<th>Course</th>
						<th>Year Level</th>
						<th>Description</th>
						<th>Details</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="tableBody">
					<?php
					$i = 1;
					$users = $conn->query("SELECT id,concat(firstname,' ',lastname) as name FROM users where `type` =2  ");
					$assignees = array();
					while ($urow = $users->fetch_assoc()) {
						$assignees[$urow['id']] = ucwords($urow['name']);
					}
					$qry = $conn->query("SELECT * FROM event_list order by title asc  ");
					while ($row = $qry->fetch_assoc()) :
						$assignee = isset($assignees[$row['user_id']]) ? $assignees[$row['user_id']] : "N/A";
					?>
						<tr>
							<th class="text-center"><?php echo $i++ ?></th>
							<td><b><?php echo ucwords($row['title']) ?></b></td>

							<td><b><?php echo ucwords($row['venue']) ?></b></td>


							<td><b><?php echo ucwords($row['school_year']) ?></b></td>

							<td><b><?php echo ucwords($row['semester']) ?></b></td>
							<td><b><?php echo ucwords($row['department']) ?></b></td>
							<td><b><?php echo ucwords($row['course']) ?></b></td>
							<td><b><?php echo ucwords($row['year_level']) ?></b></td>
							<td><b><?php echo $row['description'] ?></b></td>
							<td>
								<small><b>DateTime Start:</b> <?php echo date("M d Y h:i A", strtotime($row['datetime_start'])) ?></small><br>
								<small><b>DateTime End:</b> <?php echo date("M d Y h:i A", strtotime($row['datetime_end'])) ?></small><br>
							</td>
							<td class="text-center">
								<?php
								if (strtotime($row['datetime_start']) > time()) : ?>
									<span class="badge badge-light">Pending</span>
								<?php elseif (strtotime($row['datetime_end']) <= time()) : ?>
									<span class="badge badge-success">Done</span>
								<?php elseif ((strtotime($row['datetime_start']) < time()) && (strtotime($row['datetime_end']) > time())) : ?>
									<span class="badge badge-primary">On-Going</span>
								<?php endif; ?>
							</td>
							<td class="text-center">
								<div class="btn-group">
									<a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_event">
										<i class="fas fa-edit"></i>
									</a>
									<button type="button" class="btn btn-danger btn-flat delete_event" data-id="<?php echo $row['id'] ?>">
										<i class="fas fa-trash"></i>
									</button>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('.new_event').click(function() {
			uni_modal("New Event", "./event/manage.php")
		})
		$('.manage_event').click(function() {
			uni_modal("Manage Event", "./event/manage.php?id=" + $(this).attr('data-id'))
		})

		$('.delete_event').click(function() {
			_conf("Are you sure you want to delete this event?WARNING! Deleting this event will also delete the audience if there are connected to this event.", "delete_event", [$(this).attr('data-id')])
		})
		$('#list').dataTable()

		// Prevent default form submission and handle with AJAX
		$('#filterForm').on('submit', function(e) {
			e.preventDefault(); // Prevent default form submission
			filterData(); // Call filterData function
		});
	})

	function delete_event($id) {
		start_loader()
		$.ajax({
			url: _base_url_ + 'classes/Master.php?f=delete_event',
			method: 'POST',
			data: {
				id: $id
			},
			dataType: "json",
			error: err => {
				alert_toast("An error occured");
				end_loader()
			},
			success: function(resp) {
				if (resp.status == "success") {
					location.reload()
				} else {
					alert_toast("Deleting Data Failed");
				}
				end_loader()
			}
		})
	}

	//this code is to change the text in the button base on my choice in dropdown menu
	function changeButtonText(buttonId, text) {
		var button = document.getElementById(buttonId);
		if (button) {
			button.textContent = text;
		} else {
			console.error("Button with ID " + buttonId + " not found.");
		}
	}

	// this function is to filter all the data that been selected in dropdowns
	function filterData() {
		var form = $('#filterForm');
		var data = form.serialize();

		$.ajax({
			url: 'filter_data.php',
			method: 'GET',
			data: data,
			dataType: 'json',
			success: function(response) {
				console.log(response);
				var tableBody = $('#tableBody');
				tableBody.empty();

				if (Array.isArray(response)) {
					if (response.length > 0) {
						response.forEach(function(row, index) {
							var statusBadge = '';
							var startTime = new Date(row.datetime_start);
							var endTime = new Date(row.datetime_end);
							var now = new Date();

							if (startTime > now) {
								statusBadge = '<span class="badge badge-light">Pending</span>';
							} else if (endTime <= now) {
								statusBadge = '<span class="badge badge-success">Done</span>';
							} else if (startTime < now && endTime > now) {
								statusBadge = '<span class="badge badge-primary">On-Going</span>';
							}

							var tableRow = `
                            <tr>
                                <th class="text-center">${index + 1}</th>
                                <td><b>${row.title}</b></td>
                                <td><b>${row.venue}</b></td>
                                <td><b>${row.school_year}</b></td>
                                <td><b>${row.semester}</b></td>
                                <td><b>${row.department}</b></td>
                                <td><b>${row.course}</b></td>
                                <td><b>${row.year_level}</b></td>
                                <td><b>${row.description}</b></td>
                                <td>
                                    <small><b>DateTime Start:</b> ${new Date(row.datetime_start).toLocaleString()}</small><br>
                                    <small><b>DateTime End:</b> ${new Date(row.datetime_end).toLocaleString()}</small><br>
                                </td>
                                <td class="text-center">${statusBadge}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" data-id="${row.id}" class="btn btn-primary btn-flat manage_event">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-flat delete_event" data-id="${row.id}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
							tableBody.append(tableRow);
						});
					} else {
						tableBody.append('<tr><td colspan="12" class="text-center">No data found</td></tr>');
					}
				} else {
					console.error("Expected array but got:", response);
					tableBody.append('<tr><td colspan="12" class="text-center">Error fetching data</td></tr>');
				}
			},
			error: function(xhr, status, error) {
				console.log("hello");
				console.error("AJAX error:", xhr.responseText, status, error);
			}
		});
	}
</script>