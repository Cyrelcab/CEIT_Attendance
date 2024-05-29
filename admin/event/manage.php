<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM event_list where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
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
<form action="" id="event-frm">
    <div id="msg" class="form-group"></div>
    <input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
    <div class="form-group">
        <label for="title" class="control-label">Title</label>
        <input type="text" class="form-control form-control-sm" name="title" id="title" value="<?php echo isset($title) ? $title : '' ?>" required>
    </div>
    <div class="form-group">
        <label for="venue" class="control-label">Venue</label>
        <input type="text" class="form-control form-control-sm" name="venue" id="venue" value="<?php echo isset($venue) ? $venue : '' ?>" required>
    </div>
	<div class="form-group">
        <label for="school_year" class="control-label">School Year</label>
        <input type="text" class="form-control form-control-sm" name="school_year" id="school_year" value="<?php echo isset($school_year) ? $school_year : '' ?>" required>
    </div>
    <div class="form-group">
        <label for="semester" class="control-label">Semester</label>
        <select class="form-control form-control-sm" name="semester" id="semester" required>
            <option value="">Select Semester</option>
            <option value="1st" <?php echo $semester === '1st' ? 'selected' : ''; ?>>1st semester</option>
            <option value="2nd" <?php echo $semester === '2nd' ? 'selected' : ''; ?>>2nd semester</option>
        </select>
    </div>
    
	<div class="form-group">
    <label for="department" class="control-label">Department</label>
    <select class="form-control form-control-sm" name="department" id="department" required>
        <option value="">Select Department</option>
        <option value="IT" <?php echo $department === 'IT' ? 'selected' : ''; ?>>IT Department</option>
        <option value="Engineering" <?php echo $department === 'Engineering' ? 'selected' : ''; ?>>Engineering Department</option>
        <option value="All" <?php echo $department === 'All' ? 'selected' : ''; ?>>All Department</option>
       
    </select>
</div>

<div class="form-group">
    <label for="course" class="control-label">Course</label>
    <select class="form-control form-control-sm" name="course" id="course" required>
        <option value="">Select Course</option>

            <option value="BSIT" <?php echo $course === 'BSIT' ? 'selected' : ''; ?>>BSIT</option>
            <option value="DCT" <?php echo $course === 'DCT' ? 'selected' : ''; ?>>DCT</option>
            <option value="BSIT & DCT" <?php echo $course === 'BSIT & DCT' ? 'selected' : ''; ?>>BSIT & DCT</option>
            <option value="BSEE" <?php echo $course === 'BSEE' ? 'selected' : ''; ?>>BSEE</option>
            <option value="BSCpE" <?php echo $course === 'BSCpE' ? 'selected' : ''; ?>>BSCpE</option>
            <option value="EET" <?php echo $course === 'EET' ? 'selected' : ''; ?>>EET</option>
            <option value="BSEE & BSCpE" <?php echo $course === 'BSEE & BSCpE' ? 'selected' : ''; ?>>BSEE & BSCpE</option>
            <option value="BSEE & EET" <?php echo $course === 'BSEE & EET' ? 'selected' : ''; ?>>BSEE & EET</option>
            <option value="BSEE & BSCpE & EET" <?php echo $course === 'BSEE & BSCpE & EET' ? 'selected' : ''; ?>>BSEE & BSCpE & EET</option>
            <option value="All" <?php echo $course === 'All' ? 'selected' : ''; ?>>All Courses</option>
 

    </select>
</div>

    <div class="form-group">
        <label for="year_level" class="control-label">Year Level</label>
        <select class="form-control form-control-sm" name="year_level" id="year_level" required>
            <option value="">Select Year Level</option>
            <option value="1st year" <?php echo $year_level === '1st year' ? 'selected' : ''; ?>>1st Year</option>
            <option value="2nd year?" <?php echo $year_level === '2nd year' ? 'selected' : ''; ?>>2nd Year</option>
            <option value="3rd year" <?php echo $year_level === '3rd year' ? 'selected' : ''; ?>>3rd Year</option>
            <option value="4th year" <?php echo $year_level === '4th year' ? 'selected' : ''; ?>>4th Year</option>
            <option value="1st year & 2nd year" <?php echo $year_level === '1st year & 2nd year' ? 'selected' : ''; ?>>1st Year &amp; 2nd Year</option>
            <option value="1st year & 3rd year" <?php echo $year_level === '1st year & 3rd year' ? 'selected' : ''; ?>>1st Year &amp; 3rd Year</option>
            <option value="1st Year & 4th year" <?php echo $year_level === '1st year & 4th year' ? 'selected' : ''; ?>>1st Year &amp; 4th Year</option>
            <option value="2nd & 3rd" <?php echo $year_level === '2nd year & 3rd year' ? 'selected' : ''; ?>>2nd Year &amp; 3rd Year</option>
            <option value="2nd year & 4th year" <?php echo $year_level === '2nd year & 4th year' ? 'selected' : ''; ?>>2nd Year &amp; 4th Year</option>
            <option value="3rd year&abreve;& 4th year" <?php echo $year_level === '3rd year & 4th year' ? 'selected' : ''; ?>>3rd Year &amp; 4th Year</option>
            <option value="1st year & 2nd year & 3rd year" <?php echo $year_level === '1st year & 2nd year & 3rd year' ? 'selected' : ''; ?>>1st Year &amp; 2nd Year &amp; 3rd Year</option>
            <option value="1st & 2nd & 4th" <?php echo $year_level === '1st year & 2nd year & 4th year' ? 'selected' : ''; ?>>1st Year &amp; 2nd Year &amp; 4th Year</option>
            <option value="1st year & 3rd year & 4th year" <?php echo $year_level === '1st year & 3rd year & 4th year' ? 'selected' : ''; ?>>1st Year &amp; 3rd Year &amp; 4th Year</option>
            <option value="2nd year & 3rd year & 4th year" <?php echo $year_level === '2nd year & 3rd year & 4th year' ? 'selected' : ''; ?>>2nd Year &amp; 3rd Year &amp; 4th Year</option>
            <option value="All" <?php echo $year_level === 'All' ? 'selected' : ''; ?>>All Year</option>
        </select>
    </div>
    <div class="form-group">
        <label for="description" class="control-label">Description</label>
        <textarea type="text" class="form-control form-control-sm" name="description" id="description" required><?php echo isset($description) ? $description : '' ?></textarea>
    </div>
    <div class="form-group">
        <label for="datetime_start" class="control-label">DateTime Start</label>
        <input type="datetime-local" class="form-control form-control-sm" name="datetime_start" id="datetime_start" value="<?php echo isset($datetime_start) ? date("Y-m-d\\TH:i",strtotime($datetime_start)) : '' ?>" required>
    </div>
    <div class="form-group">
        <label for="datetime_end" class="control-label">DateTime End</label>
        <input type="datetime-local" class="form-control form-control-sm" name="datetime_end" id="datetime_end" value="<?php echo isset($datetime_end) ? date("Y-m-d\\TH:i",strtotime($datetime_end)) : '' ?>" required>
    </div>
    <div class="form-group">
        <div class="icheck-primary">
            <input type="checkbox" id="limit_registration" name="limit_registration" value="1">
            <label for="limit_registration">
                Limited Time Of Registration Only
            </label>
        </div>
    </div>
    <div class="form-group" style="display:none">
        <label for="limit_time" class="control-label">Limit Registration Time (In Minutes)</label>
        <input type="number" min="0" class="form-control form-control-sm" name="limit_time" id="limit_time" value="<?php echo isset($limit_time) ? $limit_time : '' ?>">
    </div>
</form>

<script>
	$(document).ready(function(){
		$('.select2').select2();
		$('#limit_registration').on('change input', function(){
			if($(this).is(":checked") == true){
				$('#limit_time').parent().show('slow');
				$('#limit_time').attr("required", true);
			} else {
				$('#limit_time').parent().hide('slow');
				$('#limit_time').attr("required", false);
			}
		});

		function validateForm() {
			let isValid = true;
			$('#event-frm input[required], #event-frm select[required]').each(function(){
				if($(this).val() === '') {
					$(this).addClass('is-invalid');
					isValid = false;
				} else {
					$(this).removeClass('is-invalid');
				}
			});
			return isValid;
		}

		$('#event-frm').submit(function(e){
			e.preventDefault();
			if(validateForm()){
				start_loader();
				if($('.err_msg').length > 0)
					$('.err_msg').remove();
				$.ajax({
					url: _base_url_+'classes/Master.php?f=save_event',
					data: new FormData($(this)[0]),
					cache: false,
					contentType: false,
					processData: false,
					method: 'POST',
					type: 'POST',
					dataType: 'json',
					error: err => {
						console.log(err);
						alert_toast("An error occurred", "error");
						end_loader();
					},
					success: function(resp){
						if(resp.status == 'success'){
							location.reload();
						}else if(resp.status == 'duplicate'){
							var _frm = $('#event-frm #msg');
							var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Title already exists.</div>";
							_frm.prepend(_msg);
							_frm.find('input#title').addClass('is-invalid');
							$('[name="title"]').focus();
						}else{
							alert_toast("An error occurred.", 'error');
						}
						end_loader();
					}
				});
			} else {
				alert_toast("Please fill in all required fields.", "error");
			}
		});
	});
</script>