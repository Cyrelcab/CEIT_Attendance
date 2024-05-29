<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="h-100 pt-2">
                <form action="" class="h-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="input-group col-md-5">
                            <input type="text" class='form-control' name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : "" ?>" placeholder="Search Event">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-light border">
                                    <i class="fas fa-search text-muted"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="col-md-12">
                    <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 row-cols-xs-1">
                        <?php
                        $where = "";
                        if ($_settings->userdata('type') != 1)
                            $where = " where user_id = '{$_settings->userdata('id')}' ";
                        if (isset($_GET['search'])) {
                            if (empty($where))
                                $where = " where ";
                            else
                                $where .= " and ";
                            $where .= " title LIKE '%" . $_GET['search'] . "%' or description LIKE '%" . $_GET['search'] . "%' ";
                        }
                        $qry = $conn->query("SELECT * FROM event_list {$where}");
                        while ($row = $qry->fetch_assoc()):
                        ?>
                            <a href="javascript:void(0)" class="col m-2 event-item" data-id="<?php echo $row['id'] ?>">
                                <div class="callout callout-info m-2 col event_item text-dark">
                                    <dl>
                                        <dt><b><?php echo $row['title'] ?></b></dt>
                                        <dd><?php echo $row['description'] ?></dd>
                                        <dd><b>Start:</b> <?php echo date('F d, Y h:i A', strtotime($row['datetime_start'])) ?></dd>
                                        <dd><b>End:</b> <?php echo date('F d, Y h:i A', strtotime($row['datetime_end'])) ?></dd>
                                    </dl>
                                    <div class="w-100 d-flex justify-content-end">
                                        <?php 
                                        if (strtotime($row['datetime_start']) > time()): ?>
                                            <span class="badge badge-light">Pending</span>
                                        <?php elseif (strtotime($row['datetime_end']) <= time()): ?>
                                            <span class="badge badge-success">Done</span>
                                        <?php elseif ((strtotime($row['datetime_start']) < time()) && (strtotime($row['datetime_end']) > time())): ?>
                                            <span class="badge badge-primary">On-Going</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal HTML -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="eventDetailsBody">
                <!-- Event details will be loaded here via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('.event-item').click(function(){
        var eventId = $(this).data('id');
        $.ajax({
            url: '../admin/attendance/manage.php',
            method: 'GET',
            data: {e: eventId},
            success: function(response){
                $('#eventDetailsBody').html(response);
                $('#eventDetailsModal').modal('show');
            },
            error: function(xhr, status, error){
                console.error("Error: " + status + " - " + error);
                console.log(xhr.responseText);
            }
        });
    });
});
</script>