# Domain Sorgulama ve Yönetim Sistemi

Bu proje, belirli bir alan adı için WHOIS verilerini çekmek ve bu verileri bir veritabanına kaydetmek için basit bir PHP uygulamasıdır. Alan adının kayıt, güncelleme ve bitiş tarihlerini ve kalan gün sayısını hesaplar ve gösterir.

## Özellikler

- WHOIS API kullanarak alan adı bilgilerini çekme
- Alan adı kayıt, güncelleme ve bitiş tarihlerini veritabanında saklama
- Alan adının bitişine kalan gün sayısını hesaplama ve gösterme
- Kullanıcı dostu arayüz ile alan adı kayıtlarını görüntüleme ve yönetme

## Gereksinimler

- PHP 7.x veya üzeri
- cURL uzantısı etkin
- MySQL veritabanı
- WHOIS API anahtarı

## Kurulum

1. **Depoyu klonlayın:**

    ```bash
    git clone https://github.com/uydevops/DomainSorgulama.git
    cd DomainSorgulama
    ```

2. **Veritabanını yapılandırın:**

    MySQL veritabanınızı oluşturun ve gerekli tabloları oluşturmak için sağlanan `schema.sql` dosyasını içe aktarın.

3. **Veritabanı bağlantısını güncelleyin:**

    `Database.php` dosyasını açarak veritabanı bağlantı bilgilerinizi ekleyin:

    ```php
    <?php
    class Database {
        private $host = 'localhost';
        private $db_name = 'your_database_name';
        private $username = 'your_username';
        private $password = 'your_password';
        public $conn;

        public function getConnection() {
            $this->conn = null;
            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            } catch(PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }
    ?>
    ```

4. **WHOIS API anahtarını güncelleyin:**

    `WhoisService.php` dosyasındaki API anahtarını kendi anahtarınızla değiştirin:

    ```php
    <?php
    class WhoisService {
        private $apiKey;
        
        public function __construct($apiKey) {
            $this->apiKey = $apiKey;
        }
        
        public function fetchWhoisData($domain) {
            $url = "https://api.whoapi.com/?domain=$domain&r=whois&apikey=" . $this->apiKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = json_decode(curl_exec($ch), true);
            curl_close($ch);
            return $output;
        }
    }
    ?>
    ```

## Kullanım

1. **Uygulamayı çalıştırın:**

    Web sunucunuzun çalıştığından emin olun ve proje dizinine gidin.

2. **Yeni bir alan adı ekleyin:**

    "Yeni Veri Ekle" düğmesine tıklayın ve alan adı ve firma adını girin. Formu göndererek alan adı bilgilerini çekin ve saklayın.

3. **Alan adı kayıtlarını görüntüleyin:**

    Ana tablo, saklanan tüm alan adı kayıtlarını ve bunların kayıt, güncelleme ve bitiş tarihlerini ve kalan gün sayısını gösterir.

## Katkıda Bulunma

Katkılarınızı bekliyoruz! Lütfen projeyi fork edin ve değişikliklerinizi bir pull request ile gönderin. Kodunuzun mevcut kodlama tarzına uygun olmasına ve uygun testleri içermesine özen gösterin.

## Lisans

Bu proje MIT Lisansı altında sunulmaktadır. Daha fazla bilgi için [LICENSE](LICENSE) dosyasına bakın.

## İletişim

Herhangi bir soru veya öneriniz için bana [GitHub](https://github.com/uydevops) üzerinden ulaşabilirsiniz.

---

Bu projeyi incelediğiniz için teşekkür ederim! Katkılarınız ve geri bildirimleriniz çok değerli.
