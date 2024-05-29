<?php
require_once('../../config.php'); // Adjusted path to reach the root directory

if (isset($_GET['e']) && !empty($_GET['e'])) {
    $eventId = $_GET['e'];
    $qry = $conn->query("SELECT * FROM event_list WHERE id = {$eventId}");
    
    if ($qry->num_rows > 0) {
        $event = $qry->fetch_assoc();
    } else {
        echo "Event not found.";
        exit;
    }
    ?>
    <div class="card card-outline card-primary">
        <div class="card-body">
            <dl>
                <dt>Event Title</dt>
                <dd><?php echo $event['title'] ?></dd>
            </dl>
            <dl>
                <dt>Event Description</dt>
                <dd><?php echo $event['description'] ?></dd>
            </dl>
            <dl>
                <dt>Event Venue</dt>
                <dd><?php echo $event['venue'] ?></dd>
            </dl>
            <dl>
                <dt>Event Start</dt>
                <dd><?php echo date('F d, Y h:i A', strtotime($event['datetime_start'])) ?></dd>
            </dl>
            <dl>
                <dt>Event End</dt>
                <dd><?php echo date('F d, Y h:i A', strtotime($event['datetime_end'])) ?></dd>
            </dl>
            <dl>
                <dt>Status</dt>
                <dd>
                    <?php
                    if (strtotime($event['datetime_start']) > time()) {
                        echo '<span class="badge badge-light">Pending</span>';
                    } elseif (strtotime($event['datetime_end']) <= time()) {
                        echo '<span class="badge badge-success">Done</span>';
                    } elseif ((strtotime($event['datetime_start']) < time()) && (strtotime($event['datetime_end']) > time())) {
                        echo '<span class="badge badge-primary">On-Going</span>';
                    }
                    ?>
                </dd>
            </dl>
        </div>
    </div>
    <style>
        .atooltip, .atooltip:focus {
            background: unset;
            border: unset;
            padding: unset;
        }
    </style>
    <br>
    <div class="card card-outline card-primary">
        <div class="w-100 d-flex justify-content-center mt-3">
        <a href="../registrar?e=<?php echo $_GET['e'] ?>" class="btn btn-primary btn-rounded">Open QR Scanner</a>
        </div>
        <div class="col-md-12 p-2">
            <div class="callout">
                <div class="row">
                    <div class="col-md-6">
                        <dl>
                            <dt>Event Title</dt>
                            <dd><?php echo $event['title'] ?></dd>
                        </dl>
                        <dl>
                            <dt>Event Venue</dt>
                            <dd><?php echo $event['venue'] ?></dd>
                        </dl>
                        <dl>
                            <dt>Event Description</dt>
                            <dd><?php echo $event['description'] ?></dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl>
                            <dt>Event Start</dt>
                            <dd><?php echo date("M d, Y h:i A", strtotime($event['datetime_start'])) ?></dd>
                        </dl>
                        <dl>
                            <dt>Event End</dt>
                            <dd><?php echo date("M d, Y h:i A", strtotime($event['datetime_end'])) ?></dd>
                        </dl>
                        <?php 
                        if (isset($event['limit_registration']) && $event['limit_registration'] == 1) {
                        ?>
                        <dl>
                            <dt>Registration Cut-off Time</dt>
                            <dd><?php echo date("M d, Y h:i A", strtotime($event['datetime_end'] . ' + ' . $event['limit_time'] . ' minutes')) ?></dd>
                            <input type="hidden" id="regCutOff" value="<?php echo date("Y-m-d H:i:s", strtotime($event['datetime_end'] . ' + ' . $event['limit_time'] . ' minutes')) ?>">
                        </dl>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="d-flex w-100 justify-content-between">
                <h3>Present Attendees</h3>
                <div class="input-group input-group-sm mb-3 col-md-4">
                    <input type="text" class='form-control' name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : "" ?>" placeholder="Search">
                    <div class="input-group-append">
                    </div>
                </div>
            </div>
            <hr>
            <div class="clear-fix"></div>
            <div class="row row-cols-lg-4 row-col-xs-1" id="present">
            </div>
            <h5 class='text-center' id="loadData" style="">Loading Data. Please Wait...</h5>
            <h5 class='text-center' id="noData" style="display: none">No Attendees registered yet.</h5>
        </div>
    </div>
    <div class="d-none" id="clone-item">
        <div class="col a-item">
            <div class="callout border-0">
                <button type="button" class="float-right atooltip" data-toggle="tooltip" data-html="true" title="">
                    <i class="fa fa-info-circle text-info"></i>
                </button>
                <dl>
                    <dt class="aname">John Smith</dt>
                    <dd class="aremarks">Remarks</dd>
                </dl>
                <div class="w-100 d-flex justify-content-end">
                    <small class="text-muted adate">Jun 23, 2021 6:23 PM</small>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        var Int_func;
        $(document).ready(function () {
            load_list();

            $('[name=search]').on('input', function () {
                var _filter = $(this).val().toLowerCase();

                if ($('#present .a-item').length > 0) {
                    $('#present .a-item').each(function () {
                        var _txt = $(this).text().toLowerCase();
                        console.log(_txt.includes(_filter), $(this));
                        if (_txt.includes(_filter) == true) {
                            $(this).toggle(true);
                        } else {
                            $(this).toggle(false);
                        }
                    });
                }
            });

            // Check registration cut-off time
            var regCutOff = new Date($('#regCutOff').val());
            var now = new Date();
            if (now > regCutOff) {
                $('#startLive').prop('href', 'javascript:void(0)').click(function () {
                    alert('The registration has ended.');
                });
            }
        });

        function load_list() {
            Int_func = setInterval(() => {
                var last_id = 0;
                if ($('#present .a-item').length > 0) {
                    last_id = $('#present .a-item').last().attr('data-id');
                }
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=load_registration",
                    method: 'POST',
                    data: { last_id: last_id, event_id: '<?php echo $eventId ?>' },
                    dataType: "json",
                    error: function (err) {
                        alert_toast("An error occurred", "error");
                        clearInterval(Int_func);
                    },
                    success: function (resp) {
                        $('#loadData').remove();
                        if (resp.length > 0) {
                            Object.keys(resp).map(k => {
                                var _clone = $('#clone-item').clone();
                                _clone.find('.aname').text(resp[k].name);
                                _clone.find('.aremarks').text(resp[k].remarks);
                                _clone.find('.adate').text(resp[k].rdate);
                                _clone.find('.atooltip').attr('title', '<b>Contact #:</b> ' + resp[k].contact + ' <br> <b>Email:</b> ' + resp[k].email);
                                _clone.find('.a-item').attr('data-id', resp[k].rid);
                                $('#present').append(_clone.html());
                            });
                        }
                    },
                    complete: () => {
                        $('[data-toggle="tooltip"]').tooltip();

                        if ($('#present .a-item').length > 0) {
                            $('#noData').hide();
                        } else {
                            $('#noData').show();
                        }
                    }
                })
            }, 1500);
        }
    </script>
<?php
}
?>
