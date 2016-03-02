<?php
$title = 'Einstellungen';
require('header.php');

?>
<div class="container-fluid">
    <div class="col-xs-12 col-sm-6 col-lg-4 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">WLAN-Verschlüsselung</h3>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                WLAN verschlüsseln
                    <div class="material-switch pull-right">
                        <input id="switchEncrypt" name="read" type="checkbox" <?php if(getEncryption()) echo "checked"?>/>
                        <label for="switchEncrypt" class="label-primary"></label>
                    </div>
                </div>
                <div class="list-group-item">
                    <form id="setWifiPassword">
                        <div id="wifi" class="input-group">
                            <input type="password" class="form-control" placeholder="WLAN-Passwort" id="wifiPassword" value = "<?php echo getWifiPassword();?>" minlength="8" required>
                            <span class="input-group-btn">
                                <span class="btn btn-default" id="visible"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></span>
                                <button class="btn btn-default" type="submit">Festlegen</button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="list-group-item">
                    <button class="btn btn-default btn-block" id="restartPi" data-loading-text="Neustart...">Pi neustarten</button>
                    <div class="small text-center">Änderungen am WLAN werden erst nach einem Reboot aktiv</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-lg-4 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Datenzugriff</h3>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    Lesezugriff
                    <div class="material-switch pull-right">
                        <input id="switchRead" name="read" type="checkbox" <?php if(getAccess("read")) echo "checked"?>/>
                        <label for="switchRead" class="label-primary"></label>
                    </div>
                </div>
                <div class="list-group-item">
                    Schreibzugriff
                    <div class="material-switch pull-right">
                        <input  id="switchWrite" name="write" type="checkbox" <?php if(getAccess("write")) echo "checked"?>/>
                        <label for="switchWrite" class="label-primary"></label>
                    </div>
                </div>
                <div class="list-group-item">
                    <button class="btn btn-default btn-block" id="restartSamba" data-loading-text="Neustart...">Samba neustarten</button>
                    <div class="small text-center">Änderungen an den Zugriffsrechten übernimmt der Samba erst nach einem Neustart</div>
                </div>
            </div>
        </div>
    </div>
        <div class="col-xs-12 col-sm-6 col-lg-4 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Benutzerpasswort festlegen</h3>
            </div>
            <div class="panel-body list-group">
            <form class="input-group" id="setPassword">
                <input type="password" class="form-control" placeholder="Passwort" id="password1" minlength="6" required>
                <input type="password" class="form-control" placeholder="Passwort wiederholen" id="password2" minlength="6" required>
                <input class="btn btn-default btn-block" type="submit" value="Passwort festlegen">
            </form>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.php');
?>
