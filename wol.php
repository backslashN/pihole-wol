<?php
/*
*    Pi-hole: A black hole for Internet advertisements
*    (c) 2017 Pi-hole, LLC (https://pi-hole.net)
*    Network-wide ad blocking via your own hardware.
*
*    This file is copyright under the latest version of the EUPL.
*    Please see LICENSE file for your rights under this license.
*/

require 'scripts/pi-hole/php/header_authenticated.php';
?>

<?php
function loadConfig() {
    $conf = parse_ini_file("/etc/pihole/wol.conf", true);

    if (is_array($conf)) {
        return $conf;
    } else {
        return [
            "machine-name" => [
                "mac" => "00:00:00:00:00:00",
                "ip" => "192.168.0.123",
            ],
        ];
    }
}
$machines = loadConfig();
?>

<!-- Title -->
<div class="page-header">
    <h1>backslashN's wake-on-lan tool</h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box" id="machines-list">
            <div class="box-header with-border">
                <h3 class="box-title">
                    List of configured machines
                </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="machinesTable" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Machine</th>
                            <th>MAC</th>
                            <th>IP</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($machines as $m => $a): ?>
                            <tr>
                            <td>
                                <?php echo $m; ?>
                            </td>
                            <td>
                                <code class="breakall"><?php echo $a["mac"]; ?></code>
                            </td>
                            <td>
                                <code class="breakall"><?php echo $a["ip"]; ?></code>
                            </td>
                            <td>
                                <button type="button" class="btn btn-default btn-xs text-maroon" onclick="window.location.href='?wake=<?php echo $m; ?>';">
                                    Wake up
                                </button>
                                <button type="button" class="btn btn-default btn-xs text-green" onclick="window.location.href='?check=<?php echo $m; ?>';">
                                    Check
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="button" id="resetButton" class="btn btn-default btn-sm text-red hidden">Reset sorting</button>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<?php
function execAndShow($cmd, $action, $target) {
    $output=null;
    $retval=null;

    exec($cmd, $output, $retval);
?>

<h3>
    <?php echo $action; ?> -- <?php echo $target; ?>
</h3>

<pre id="output" style="width: 100%; height: 100%; max-height:650px; overflow-y:scroll;">
<b><?php echo "> $cmd"; ?></b> <br/>
<?php
foreach ($output as &$line) {
    echo "$line </br>";
}

echo "<br/><i>Returned with status $retval</i>";
?>
</pre> 

<?php
}

$wake_machine=$_GET['wake'];
$check_machine=$_GET['check'];

if (isset($wake_machine)) {
    $action = 'Waking up';
    $target = $wake_machine;
    $mac = $machines[$target]["mac"];
    $cmd = "wakeonlan $mac";
    execAndShow($cmd, $action, $target);
} elseif (isset($check_machine)) {
    $action = 'Checking';
    $target = $check_machine;
    $ip = $machines[$target]["ip"];
    $cmd = "ping -c 1 $ip";
    execAndShow($cmd, $action, $target);
} else {
    $action = 'List';
}
?>

<?php
require 'scripts/pi-hole/php/footer.php';
?>
