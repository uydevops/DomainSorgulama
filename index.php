<?php
include 'db.php';

function fetchWhoisData($domain, $apiKey) {
    $url = "https://api.whoapi.com/?domain=$domain&r=whois&apikey=$apiKey";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = json_decode(curl_exec($ch), true);
    curl_close($ch);
    return $output;
}

function calculateDaysRemaining($expiryDate) {
    $today = time();
    $targetDate = strtotime($expiryDate);
    $dateDiff = $targetDate - $today;
    return round($dateDiff / (60 * 60 * 24));
}

if (isset($_POST["test"])) {
    $domain = $_POST["d_adi"];
    $apiKey = "84f1315348e48531343649b9cf5a492e";

    $output = fetchWhoisData($domain, $apiKey);

    if (isset($output['status']) && $output['status'] == 0) {
        $daysRemaining = calculateDaysRemaining($output['date_expires']);

        $recordDate = date('Y-m-d', strtotime($output["date_created"]));
        $updateDate = date('Y-m-d', strtotime($output["date_updated"]));
        $expiryDate = date('Y-m-d', strtotime($output["date_expires"]));

        $stmt = $db->prepare("INSERT INTO domain_kayit (d_adi, b_tarih, g_tarih, bi_tarih, k_gun) VALUES (?, ?, ?, ?, ?)");
        $success = $stmt->execute([$domain, $recordDate, $updateDate, $expiryDate, $daysRemaining]);

        if ($success) {
            echo "Eklendi";
            header("Location: islemler.php");
            exit();
        } else {
            echo "Eklenmedi";
        }
    }
}
?>

<?php include 'header.php'; ?>

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
        $query = $db->prepare("SELECT * FROM domain_kayit");
        $query->execute();
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

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

</body>
</html>
