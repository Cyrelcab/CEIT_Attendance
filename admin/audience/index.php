<?php
// Initialize $_settings as an empty object if it's not already defined
if (!isset($_settings)) {
	$_settings = new stdClass();
}
?>
<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>

<?php
// Fetch specific columns in the database
$sy_qry = $conn->query("SELECT DISTINCT school_year FROM event_audience ORDER BY school_year ASC");
$department_qry = $conn->query("SELECT DISTINCT department FROM event_audience ORDER BY department ASC");
$course_qry = $conn->query("SELECT DISTINCT course FROM event_audience ORDER BY course ASC");
$yrlevel_qry = $conn->query("SELECT DISTINCT year_level FROM event_audience ORDER BY year_level ASC");
?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_audience" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>

		<div class="card-body">
			<table class="table table-hover table-bordered" id="list">
				<div class="d-flex justify-content-center align-items-center">
					<form id="filterForm" action="" method="GET">

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
							<button class="btn btn-sm btn-danger" type="button" onclick="location.reload()">Reset</button>
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
				<th>Event</th>
				<th>Name</th>
				<th>ID No.</th>
				<th>School Year</th>
				<th>Department</th>
				<th>Course</th>
				<th>Year Level</th>
				<th>Details</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="tableBody">
			<?php
			$i = 1;

			$qry = $conn->query("SELECT a.*,e.title FROM event_audience a inner join event_list e on e.id = a.event_id order by a.name asc  ");
			while ($row = $qry->fetch_assoc()) :
			?>
				<tr>
					<th class="text-center"><?php echo $i++ ?></th>
					<td><b><?php echo ucwords($row['title']) ?></b></td>
					<td><b><?php echo ucwords($row['name']) ?></b> <span><a href="javascript:void(0)" class="view_data" data-id="<?php echo $row['id'] ?>"><span class="fa fa-qrcode"></span></a></span></td>
					<td><b><?php echo ucwords($row['schoolid']) ?></b></td>
					<td><b><?php echo ucwords($row['school_year']) ?></b> </td>
					<td><b><?php echo ucwords($row['department']) ?></b></td>
					<td><b><?php echo ucwords($row['course']) ?></b> </td>

					<td><b><?php echo ucwords($row['year_level']) ?></b> </td>

					<td>
						<small> <b>Email:</b> <?php echo $row['email'] ?></small><br>
						<small> <b>Contact #:</b> <?php echo $row['contact'] ?></small>
					</td>
					<td class="text-center">
						<div class="btn-group">
							<a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_audience">
								<i class="fas fa-edit"></i>
							</a>
							<button type="button" class="btn btn-danger btn-flat delete_audience" data-id="<?php echo $row['id'] ?>">
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
		$('.new_audience').click(function() {
			uni_modal("New Audience", "./audience/manage.php")
		})
		$('.manage_audience').click(function() {
			uni_modal("Manage Audience", "./audience/manage.php?id=" + $(this).attr('data-id'))
		})

		$('.view_data').click(function() {
			uni_modal("QR", "./audience/view.php?id=" + $(this).attr('data-id'))
		})

		$('.delete_audience').click(function() {
			_conf("Are you sure to delete this audience?", "delete_audience", [$(this).attr('data-id')])
		})
		$('#list').dataTable()

		$('#filterForm').on('submit', function(e) {
			e.preventDefault(); // Prevent default form submission
			filterData(); // Call filterData function
		});
	})

	function delete_audience($id) {
		start_loader()
		$.ajax({
			url: _base_url_ + 'classes/Master.php?f=delete_audience',
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

	//function to filter data in audience
	function filterData() {
		var form = $('#filterForm');
		var data = form.serialize();

		$.ajax({
			url: 'http://localhost/event/admin/audience/filter_data.php',
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
							var tableRow = `
                            <tr>
                                <th class="text-center">${index + 1}</th>
                                <td><b>${row.title}</b></td>
                                <td><b>${row.name}</b></td>
                                <td><b>${row.schoolid}</b></td>
                                <td><b>${row.school_year}</b></td>
                                <td><b>${row.department}</b></td>
                                <td><b>${row.course}</b></td>
                                <td><b>${row.year_level}</b></td>
                                <td>
                                    <small><b>Email:</b> ${row.email}</small><br>
                                    <small><b>Contact #:</b> ${row.contact}</small><br>
                                </td>
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
				console.error(error);
			}
		});
	}
</script>