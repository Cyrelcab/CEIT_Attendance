<?php
require_once('../../config.php');
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM event_audience where id = {$_GET['id']}");
	foreach ($qry->fetch_array() as $k => $v) {
		if (!is_numeric($k)) {
			$$k = $v;
		}
	}
}
?>
<?php
// Assuming you have a variable $course that holds the selected course value
$course = isset($course) ? $course : '';
$school_year = isset($school_year) ? $school_year : '';
$semester = isset($semester) ? $semester : '';
$year_level = isset($year_level) ? $year_level : '';
$department = isset($department) ? $department : '';

?>
<form action="" id="audience-frm">
	<div id="msg" class="form-group"></div>
	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
	<div class="form-group">
		<label for="name" class="control-label">Fullname</label>
		<input type="text" class="form-control form-control-sm" name="name" id="name" value="<?php echo isset($name) ? $name : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="schoolid" class="control-label">ID No.</label>
		<input type="text" class="form-control form-control-sm" name="schoolid" id="schoolid" value="<?php echo isset($schoolid) ? $schoolid : '' ?>" required>
	</div>

	<div class="form-group">
		<label for="school_year" class="control-label">School Year</label>
		<input type="text" class="form-control form-control-sm" name="school_year" placeholder="Ex. 2023-2024" id="school_year" value="<?php echo isset($school_year) ? $school_year : '' ?>" required>
	</div>

	<div class="form-group">
		<label for="department" class="control-label">Department</label>
		<select class="form-control form-control-sm" name="department" id="department" required onchange="updateCourses()">
			<option value="">Select Department</option>
			<option value="IT" <?php echo $department === 'IT' ? 'selected' : ''; ?>>IT Department</option>
			<option value="Engineering" <?php echo $department === 'Engineering' ? 'selected' : ''; ?>>Engineering Department</option>
		</select>
	</div>

	<div class="form-group">
		<label for="course" class="control-label">Course</label>
		<select class="form-control form-control-sm" name="course" id="course" required>
			<option value="">Select Course</option>
			<?php
			// PHP code to generate course options based on the selected department
			if ($department === 'IT') {
				echo '<option value="BSIT" ' . ($course === 'BSIT' ? 'selected' : '') . '>BSIT</option>';
				echo '<option value="DCT" ' . ($course === 'DCT' ? 'selected' : '') . '>DCT</option>';
			} elseif ($department === 'Engineering') {
				echo '<option value="BSEE" ' . ($course === 'BSEE' ? 'selected' : '') . '>BSEE</option>';
				echo '<option value="BSCpE" ' . ($course === 'BSCpE' ? 'selected' : '') . '>BSCpE</option>';
				echo '<option value="EET" ' . ($course === 'EET' ? 'selected' : '') . '>EET</option>';
			}
			?>
		</select>
	</div>

<script>
    function updateCourses() {
        var department = document.getElementById("department").value;
        var courseSelect = document.getElementById("course");
        courseSelect.innerHTML = ""; // Clear previous options
        
        // Generate course options based on the selected department
        if (department === "IT") {
            courseSelect.innerHTML += '<option value="BSIT">BSIT</option>';
            courseSelect.innerHTML += '<option value="DCT">DCT</option>';
        } else if (department === "Engineering") {
            courseSelect.innerHTML += '<option value="BSEE">BSEE</option>';
            courseSelect.innerHTML += '<option value="BSCpE">BSCpE</option>';
            courseSelect.innerHTML += '<option value="EET">EET</option>';
        }
    }
</script>
	<div class="form-group">
		<label for="year_level" class="control-label">Year Level</label>
		<select class="form-control form-control-sm" name="year_level" id="year_level" required>
			<option value="">Select Year Level</option>
			<option value="1st year" <?php echo $year_level === '1st year' ? 'selected' : ''; ?>>1st Year</option>
			<option value="2nd year" <?php echo $year_level === '2nd year' ? 'selected' : ''; ?>>2nd Year</option>
			<option value="3rd year" <?php echo $year_level === '3rd year' ? 'selected' : ''; ?>>3rd Year</option>
			<option value="4th year" <?php echo $year_level === '4th year' ? 'selected' : ''; ?>>4th Year</option>
		</select>
	</div>
	<div class="form-group">
		<label for="email" class="control-label">Email</label>
		<input type="email" class="form-control form-control-sm" name="email" id="email" value="<?php echo isset($email) ? $email : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="contact" class="control-label">Contact</label>
		<input type="text" class="form-control form-control-sm" name="contact" id="contact" value="<?php echo isset($contact) ? $contact : '' ?>" required>
	</div>

	<div class="form-group">
		<label for="event_id" class="control-label">Event</label>
		<select name="event_id" id="event_id" class="custom-select select2" required>
			<option></option>
			<?php
			$qry = $conn->query("SELECT id,title FROM event_list order by concat(title) asc ");
			while ($row = $qry->fetch_assoc()) :
			?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($event_id) && $event_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['title']) ?></option>
			<?php endwhile; ?>
		</select>
	</div>

</form>
<script>
	$(document).ready(function() {
		$('.select2').select2();

		$('#audience-frm').submit(function(e) {
			e.preventDefault()
			start_loader()
			if ($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url: _base_url_ + 'classes/Master.php?f=save_audience',
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				dataType: 'json',
				error: err => {
					console.log(err)
					alert_toast("an error occured", "error")
					end_loader()
				},
				success: function(resp) {
					if (resp.status == 'success') {
						location.reload();
					} else {
						alert_toast("An error occured.", 'error');
					}
					end_loader()
				}
			})
		})
	})
</script>