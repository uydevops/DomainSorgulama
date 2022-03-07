<?php

include 'db.php';
if (isset($_POST["test"])) {
    $domain = $d_adi = $_POST["d_adi"];
    $r         = "whois";
    $apikey    = "84f1315348e48531343649b9cf5a492e";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.whoapi.com/?domain=$domain&r=$r&apikey=$apikey");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if (isset($output['status']) && $output['status'] == 0) {

        $today = time();
        $target_date = date(strtotime($output['date_expires']));
        $datediff = $target_date - $today;
        $kalan_gun = round($datediff / (60 * 60 * 24));
        echo $kalan_gun;

        $kayit_tarihi = date($output["date_created"]);
        $guncellenme_tarihi = date($output["date_updated"]);
        $bitis_tarih = date($output["date_expires"]);

        $sorgu = $db->prepare("INSERT INTO domain_kayit SET d_adi=?,b_tarih=?,g_tarih=?,bi_tarih=?,k_gun=?");
        $ekle = $sorgu->execute(array($domain, $kayit_tarihi, $guncellenme_tarihi, $bitis_tarih, $kalan_gun));
        if ($ekle) {
            echo "EKlendi";
            header("location:islemler.php");
        } else {
            echo "EKlenmedi";
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

            <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-black">Yeni
                Veri Ekle</button>

            <div id="id01" class="w3-modal">
                <div class="w3-modal-content">

                    <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    <br>
                    <center>
                        <form action="" method="POST">
                            <input type="text" placeholder="Domain Adi" class="form-control" name="d_adi" id=""><br>
                            <input type="text" placeholder="Firma Adı" class="form-control" name="f_adi" id=""><br>
                            <button class="btn btn-success" name="test">Kaydet</button>


                        </form>
                </div>
            </div>
            </div>
            </div>

            </button></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php



            $listele = $db->prepare("SELECT * FROM domain_kayit");
            $listele->execute();
            $deger = $listele->fetchALL(PDO::FETCH_ASSOC);
            foreach ($deger as $cek) {
            ?>
                <td><?php echo $cek["d_id"]; ?></td>
                <td><?php echo $cek["d_adi"]; ?></td>
                <td><?php echo $cek["b_tarih"]; ?></td>
                <td><?php echo $cek["g_tarih"]; ?></td>
                <td><?php echo $cek["bi_tarih"]; ?></td>
                <td><?php echo $cek["k_gun"]; ?></td>





                <td>

                    <button type="button" class="btn btn-primary btn-xs dt-edit" style="margin-right:16px;">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-danger btn-xs dt-delete">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </td>

        </tr>
    <?php } ?>
    <tr>

    </tbody>
</table>


</div>
</body>
<html>
