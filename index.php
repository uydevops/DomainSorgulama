<?php
include 'Database.php';
include 'WhoisService.php';
include 'DomainService.php';

$dbConnection = (new Database())->getConnection();
$whoisService = new WhoisService("84f1315348e48531343649b9cf5a492e");
$domainService = new DomainService($dbConnection, $whoisService);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["test"])) {
    $domain = $_POST["d_adi"];
    $success = $domainService->saveDomainData($domain);

    if ($success) {
        header("Location: islemler.php");
        exit();
    } else {
        echo "Domain data could not be saved.";
    }
}

include 'header.php';
?>

<button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-black">Yeni Veri Ekle</button>

<div id="id01" class="w3-modal">
    <div class="w3-modal-content">
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
        <center>
            <form action="" method="POST">
                <input type="text" placeholder="Domain Adı" class="form-control" name="d_adi" required><br>
                <input type="text" placeholder="Firma Adı" class="form-control" name="f_adi"><br>
                <button class="btn btn-success" name="test">Kaydet</button>
            </form>
        </center>
    </div>
</div>

<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Domain İd</th>
            <th>Domain Adı</th>
            <th>Başlangıç Tarihi</th>
            <th>Güncelleme Tarihi</th>
            <th>Bitis Tarih</th>
            <th>Kalan Gün</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $records = $domainService->getAllDomains();
        foreach ($records as $record) { ?>
            <tr>
                <td><?php echo htmlspecialchars($record["d_id"]); ?></td>
                <td><?php echo htmlspecialchars($record["d_adi"]); ?></td>
                <td><?php echo htmlspecialchars($record["b_tarih"]); ?></td>
                <td><?php echo htmlspecialchars($record["g_tarih"]); ?></td>
                <td><?php echo htmlspecialchars($record["bi_tarih"]); ?></td>
                <td><?php echo htmlspecialchars($record["k_gun"]); ?></td>
                <td>
                    <button type="button" class="btn btn-primary btn-xs dt-edit">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-danger btn-xs dt-delete">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</body>
</html>
