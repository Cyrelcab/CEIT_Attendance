<?php
require_once('../../config.php'); // Adjust the path as needed

if (isset($_GET['e']) && !empty($_GET['e'])) {
    $eventId = $_GET['e'];
    $qry = $conn->query("SELECT * FROM event_list WHERE id = {$eventId}");
    
    if ($qry->num_rows > 0) {
        $event = $qry->fetch_assoc();
    } else {
        echo "Event not found.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/styles.css">
    <script src="<?php echo base_url ?>dist/js/html5-qrcode.min.js"></script>
    <script src="<?php echo base_url ?>dist/js/sweetalert.min.js"></script>
    <script src="<?php echo base_url ?>dist/js/html5-qrcode.js"></script>
<script src="<?php echo base_url ?>dist/js/html5-qrcode-scanner.js"></script>
<script src="<?php echo base_url ?>dist/js/sweetalert.min.js"></script>
</head>
<body>
    <style>
        /* styles.css */

body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.container {
    margin: 0 auto;
    padding: 20px;
    max-width: 800px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

#qr_holder {
    margin-top: 20px;
    text-align: center;
}

#qr-reader {
    width: 60%;
    margin: 0 auto;
    padding: 10px;
    border: 2px solid #007bff;
    border-radius: 8px;
}

#qr-reader-results {
    margin-top: 20px;
    font-size: 1.2em;
    color: #28a745;
}

@media (max-width: 720px) {
    #qr-reader {
        width: 100%;
    }
    #qr-reader__scan_region video {
        object-fit: cover !important;
    }
}

.btn {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    background-color: #007bff;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn:hover {
    background-color: #0056b3;
    color: #fff;
}

.btn-rounded {
    border-radius: 50px;
}

.w-100 {
    width: 100%;
}

.d-flex {
    display: flex;
}

.justify-content-end {
    justify-content: flex-end;
}

.pt-3 {
    padding-top: 1rem;
}

    </style>
<div class="container">
    <div class="col-md-12 pt-3" id="qr_holder" align="center">
        <div class="w-100 d-flex justify-content-end">
            <a class="btn btn-primary btn-rounded" id="startLive" href="../../registrar?e=<?php echo $_GET['e'] ?>">Back</a>
        </div>
        <div id="qr-reader"></div>
        <div id="qr-reader-results"></div>
    </div>
    <input type="hidden" id="audience_id" value="">
</div>

<script>
    function start_loader() {
        // Implement your loader start function here
    }

    function end_loader() {
        // Implement your loader end function here
    }

    function alert_toast(message) {
        // Implement your toast message function here
    }

    function _qsave() {
        start_loader();
        var audience_id = $('#audience_id').val();
        $.ajax({
            url: '<?php echo base_url ?>classes/Master.php?f=register',
            method: 'POST',
            data: { audience_id: audience_id, event_id: '<?php echo $_GET['e'] ?>' },
            error: err => {
                console.log(err);
                alert_toast('An Error Occurred.');
                end_loader();
            },
            success: function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == 1) {
                    swal({
                        title: resp.name,
                        text: 'Successfully Registered',
                        icon: 'success',
                        timer: 2000,
                        buttons: false,
                    });
                } else if (resp.status == 2) {
                    swal({
                        title: 'Code is not Valid',
                        text: 'Code is not enrolled in this event',
                        icon: 'error',
                        timer: 2000,
                        buttons: false,
                    });
                } else if (resp.status == 3) {
                    swal({
                        title: 'Already Recorded',
                        text: resp.name + ' is already recorded',
                        icon: 'error',
                        timer: 2000,
                        buttons: false,
                    });
                } else {
                    alert_toast('An Error Occurred.');
                }
                setTimeout(function() {
                    $('#audience_id').val('');
                    end_loader();
                }, 2100);
            }
        });
    }

    function docReady(fn) {
        if (document.readyState === "complete" || document.readyState === "interactive") {
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;

        function onScanSuccess(qrCodeMessage) {
            if (qrCodeMessage !== $('#audience_id').val()) {
                ++countResults;
                lastResult = qrCodeMessage;
                $('#audience_id').val(qrCodeMessage);
                _qsave();
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 5, qrbox: 150 }
        );

        html5QrcodeScanner.render(onScanSuccess);
    });

    $(document).ready(function() {
        $('.main-container').height($(window).height() - $('.top-head').height());
    });
</script>
</body>
</html>
