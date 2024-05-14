<?php
class DomainService {
    private $db;
    private $whoisService;
    
    public function __construct($db, $whoisService) {
        $this->db = $db;
        $this->whoisService = $whoisService;
    }
    
    public function calculateDaysRemaining($expiryDate) {
        $today = time();
        $targetDate = strtotime($expiryDate);
        $dateDiff = $targetDate - $today;
        return round($dateDiff / (60 * 60 * 24));
    }

    public function saveDomainData($domain) {
        $output = $this->whoisService->fetchWhoisData($domain);
        if (isset($output['status']) && $output['status'] == 0) {
            $daysRemaining = $this->calculateDaysRemaining($output['date_expires']);
            $recordDate = date('Y-m-d', strtotime($output["date_created"]));
            $updateDate = date('Y-m-d', strtotime($output["date_updated"]));
            $expiryDate = date('Y-m-d', strtotime($output["date_expires"]));

            $stmt = $this->db->prepare("INSERT INTO domain_kayit (d_adi, b_tarih, g_tarih, bi_tarih, k_gun) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$domain, $recordDate, $updateDate, $expiryDate, $daysRemaining]);
        }
        return false;
    }

    public function getAllDomains() {
        $query = $this->db->prepare("SELECT * FROM domain_kayit");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
