<?php
namespace App\Libraries;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Exception;

class myfunction {

    // SET TITLE
    protected $title, $project_title, $separator_title;
    protected $title_company;
    public static function setTitle(String|float $title = null) {
        try {
            self::$title = $title;
        }
        catch(Exception $e) {
            echo "function setTitle() Error: ".$e;
        }
    }

    public static function setTitle_Company(String $title) {
        try {
            self::$title_company = $title;
        }
        catch(Exception $e) {
            echo "function setTitle_Company() Error: ".$e;
        }
    }

    public function setProjectTitle(String|float $title = null) {
        try {
            self::$project_title = $title;
        }
        catch(Exception $e) {
            echo "function setProjectTitle() Error: ".$e;
        }
    }

    public function setSepatatorTitle(String $title = null) {
        try {
            self::$separator_title = $title;
        }
        catch(Exception $e) {
            echo "function setSepatatorTitle() Error: ".$e;
        }
    }

    public function getTitle() {
        try {
            return self::$title;
        }
        catch(Exception $e) {
            return "function getTitle() Error: ".$e;
        }
    }

    public function getProjectTitle() {
        try {
            return self::$project_title;
        }
        catch(Exception $e) {
            return "function getProjectTitle() Error: ".$e;
        }
    }

    public function getSeparatorTitle() {
        try {
            return self::$separator_title;
        }
        catch(Exception $e) {
            return "function getSeparatorTitle() Error: ".$e;
        }
    }

    public function getDocTitle(String|float $title = "__-__") { ?>
        <script type="text/javascript">
            document.title = "<?php echo self::getTitle().self::getSeparatorTitle().self::getProjectTitle(); ?>";
            $("<?php echo '#'.$title; ?>").html("<?php echo self::getTitle(); ?>");
        </script>
        <?php
    }

    public function redirect(String $str) {
        return header("location: ".$str);
    }


    // SAFETY CONNECTION STRING FROM INJECTION
    public static function escape(String|float $str=null) {
        try {
            return htmlspecialchars(htmlentities(addslashes($str)));
        }
        catch(Exception $e) {
            return "Error Function escape() : ".$e;
        }
    }

    // READABLE FORMAT TEXT
    public static function readable($str=null) {
        return html_entity_decode(htmlspecialchars_decode($str));
    }

    public static function rawtext($str=null) {
        return htmlspecialchars(htmlentities($str));
    }

    public function formatnumber(int|float $str=null, $koma=0) {
        try {
            return number_format($str, $koma, ',', '.');
        }
        catch(Exception $e) {
            return "Error Function formatnumber() : ".$e;
        }
    }

    public function rupiah(int|float $str=null) {
        try {
            return 'Rp. '.self::formatnumber($str, 2);
        }
        catch(Exception $e) {
            return "Error Function Rupiah() : ".$e;
        }
    }


    // SEND EMAIL
    public function toSendMail(String $to=null, String $subject=null, String $txt=null) {
        try {
            $headers = "From: dev.ariwiraasmara.emailgateway@gmail.com";
            mail($to,$subject,$txt,$headers);
        }
        catch(Exception $e) {
            echo "function toSendMail() Error: ".$e;
        }
    }

    public function toSendMailBy(String $to=null, String $subject=null, String $txt=null, String $headers=null) {
        try {
            //$headers = "From: dev.ariwiraasmara.emailgateway@gmail.com";
            mail($to,$subject,$txt,$headers);
        }
        catch(Exception $e) {
            echo "function toSendMail() Error: ".$e;
        }
    }


    // ENECRYPTION & DECRYPTION
    public static function encrypt_pass(String $val) {
        return self::toCrypt(hash("sha512", md5(base64_encode(bin2hex($val)))));
    }

    public static function encrypt($val, int $x7 = 0) {
        if($x7 == 3) Crypt::encryptString(Crypt::encryptString(Crypt::encryptString($val)));
        else return Crypt::encryptString($val);
    }

    public static function decrypt($val, int $x7 = 0) {
        return Crypt::decryptString($val, false, base64_decode('<--{[@12iW3721195S0f!@]}-->'));

        // if($x7 == 3) Crypt::decryptString(Crypt::decryptString(Crypt::decryptString($val)));
        // else return Crypt::decryptString($val);
    }

    public static function base64encode($str) {
        return base64_encode($str);
    }

    public static function base64decode($str) {
        return base64_decode($str);
    }

    public static function decodeToken($str) {
        return json_decode(base64_decode($str));
    }

    public static function enval($str, bool $we = false) {
        if($we == true) return self::encrypt(bin2hex(base64_encode( $str )));
        return bin2hex(base64_encode( $str ));
    }

    public static function denval(String|float $str, bool $we = false) {
        if($we == true) base64_decode(hex2bin( self::decrypt($str) ));
        return base64_decode(hex2bin( $str ));
    }

    public static function encode($data, $key) {
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($data, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode( $hmac );//base64_encode( $iv.$hmac.$ciphertext_raw );
        return $ciphertext;
    }

    public static function decode($str, $data) {
        $c = base64_decode($data);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        if (hash_equals($hmac, $calcmac))// timing attack safe comparison
        {
            return $original_plaintext."\n";
        }
    }


    // ENCRYPT ONE WAY
    public static function hash(String|float $str) {
        return Hash::make($str, ['rounds' => 12,]);
    }

    public static function checkHash(String|float $str, String $hashed) {
        if (Hash::check($str, $hashed)) return 1;
        else return 0;
    }

    public static function toCrypt($str) {
        //return crypt($str, '$6$rounds='.self::randNumber(7, 1));
        return crypt($str, '$6$rounds=030702111995');//self::random('numb', 7));
    }

    public static function toMD5($str, bool $tf = false) {
        return md5($str, $tf);
    }

    public static function toSHA1($str, bool $tf = false) {
        return sha1($str, $tf);
    }

    public static function toSHA512($str) {
        return hash("sha512", $str);
    }

    public static function toHaval256(String|float $str) {
        return hash("haval256,5", $str);
    }

    public static function tokenName(String $str = 'token') {
        return self::toCrypt(self::toSHA512(self::toMD5($str)));
    }

    public static function tokenValue() {
        return self::toCrypt(self::toSHA512(self::toMD5(self::toHaval256(self::encrypt(openssl_random_pseudo_bytes(self::random(3)))))));
    }

    public static function enlink(String|float $str) {
        return self::toSHA512(self::toMD5($str));
    }

    // E
    public function enparam(String $a, String $b, String $c, String $d) {
        return self::setIDParam($a, $b).'&'.self::setIDParam($c, $d);
    }

    public function setIDParam(String|float $id, String|float $val) {
        return self::enlink($id).'='.self::enval($val);
    }

    // SESSION AND COOKIE
    public function setOneSession(String $str, String $val, int $type=0) {
        try {
            if( $type > 1 ) {
                $_SESSION[self::enlink($str)] = self::enval($val);
            }
            else if( $type == 1 ) {
                $_SESSION[self::enlink($str)] = $val;
            }
            else {
                $_SESSION[$str] = $val;
            }
        }
        catch(Exception $e) {
            return "Error Function setOneSession() : ".$e;
        }
    }

    public function setSession(Array $array, int $type=0) {
        try {
            if( $type > 1 ) {
                foreach($array as $arr => $val) {
                    $_SESSION[self::enlink($arr)] = self::enval($val);
                }
            }
            else if( $type == 1 ) {
                foreach($array as $arr => $val) {
                    $_SESSION[self::enlink($arr)] = $val;
                }
            }
            else {
                foreach($array as $arr => $val) {
                    $_SESSION[$arr] = $val;
                }
            }
        }
        catch(Exception $e) {
            return "Error Function setSession() : ".$e;
        }
    }

    public static function getSession(String|float $str=null, int $type=0) {
        try {
            return match($type) {
                1 => $_SESSION[self::enlink($str)],
                2 => self::denval($_SESSION[self::enlink($str)]),
                default => $_SESSION[$str],
            };
        }
        catch(Exception $e) {
            return "Error Function getSession() : ".$e;
        }
    }

    public static function setRawCookie(string $name = 'token', $val=1, $hari=1, $jam=24, $menit=60, $detik=60) {
        setcookie($name, $val, time() + ($hari * $jam * $menit * $detik), "/"); // 86400 = 1 day
    }

    public static function setOneCookie(string $name = 'token', $val=1, $hari=1, $jam=24, $menit=60, $detik=60) {
        setcookie($name, self::encrypt(self::enval($val)), time() + ($hari * $jam * $menit * $detik), "/"); // 86400 = 1 day
    }

    public static function setCookie($array, $hari=1, $jam=24, $menit=60, $detik=60) {
        foreach($array as $arr => $val) {
            setcookie($arr, self::encrypt(self::enval($val)), time() + ($hari * $jam * $menit * $detik), "/"); // 86400 = 1 day
        }
    }

    public static function getRawCookie(string $name = 'token', $type = 0) {
        return @$_COOKIE[$name];
    }

    public static function getCookie(String|float $str, $type = 0) {
        return self::denval(self::decrypt(@$_COOKIE[$str]));
    }

    public static function setCookieOff(String $str) {
        setcookie($str, null, time() - (365 * 24 * 60 * 60), "/");
    }


    // SYSTEM LOGOUT
    public function logoutSystem($array) {
        try {
            foreach($array as $arr) {
                setcookie(self::enlink($arr), null, time() - (365 * 24 * 60 * 60), "/");
            }
            session_destroy();
        }
        catch(Exception $e) {
            return "Error Function logoutSystem() : ".$e;
        }
    }

    // GET SYSTEM TIME
    public function getHari($str) {
        try {
            return date('l', strtotime($str));
        }
        catch(Exception $e) {
            return "function Hari() Error: ".$e;
        }
    }

    public function getTanggal($str, $pemisah, $format, $jam) {
        try {
            if($format == 'dmy') {
                if($jam == 'Yes') {
                    return date('d'.$pemisah.'m'.$pemisah.'Y H:i:s', strtotime($str));
                }
                else {
                    return date('d'.$pemisah.'m'.$pemisah.'Y', strtotime($str));
                }
            }
            else if($format == 'ymd') {
                if($jam == 'Yes') {
                    return date('Y'.$pemisah.'m'.$pemisah.'d H:i:s', strtotime($str));
                }
                else {
                    return date('Y'.$pemisah.'m'.$pemisah.'d', strtotime($str));
                }
            }
            else {
                return date('d'.$pemisah.'m'.$pemisah.'Y');
            }
        }
        catch(Exception $e) {
            return "function getBulan() Error: ".$e;
        }
    }

    public function getTanggalAkhir($str) {
        try {
            return date('t', strtotime($str));
        }
        catch(Exception $e) {
            return "function getTanggalAkhir() Error: ".$e;
        }
    }

    public function getBulan($str, $bulan, $tahun) {
        try {
            if($bulan == 'Angka') {
                if($tahun == 'Yes') {
                    return date('m Y', strtotime($str));
                }
                else {
                    return date('m', strtotime($str));
                }
            }
            else if($bulan == 'Nama') {
                if($tahun == 'Yes') {
                    return date('F Y', strtotime($str));
                }
                else {
                    return date('F', strtotime($str));
                }
            }
            else {
                return date('F Y');
            }
        }
        catch(Exception $e) {
            return "function getBulan() Error: ".$e;
        }
    }


    // NOTIFICATION
    public static function Notrifger($id, $idtrigger, $txt) {
        try { ?>
            <a href="<?php echo '#'.self::Enlink($idtrigger); ?>" id="<?php echo self::Enlink($id); ?>" class="modal-trigger hide"><?php echo 'to-'.$txt; ?></a>
            <?php
        }
        catch(Exception $e) {
            echo "function Notrifger() Error: ".$e;
        }
    }

    public static function Notif($id, $pesan, $tipe, $link='#') {
        try {
            if($tipe == 'notif') { $warna = '#5f5;'; $txt = 'txt-black'; }
            else if($tipe == 'warn') { $warna = '#f00;'; $txt = 'txt-white'; }
            else if($tipe == 'info') { $warna = '#55f;'; $txt = 'txt-white'; }
            else { $warna = '#ccc;'; $txt = 'txt-white'; }
            ?>
            <div class="modal notification borad-20 <?php echo $txt; ?>" id="<?php echo self::Enlink($id); ?>" style="<?php echo 'background: '.$warna; ?>">
                <div class="modal-content choose-date">
                    <a href="<?php echo $link; ?>" class="close-notification no-smoothState modal-close"><i class="ion-android-close"></i></a>
                    <h1 class="uppercase <?php echo $txt; ?> bold italic center"><?php echo $pesan; ?></h1>
                </div>
            </div>
            <?php
        }
        catch(Exception $e) {
            echo "function Notif() Error: ".$e;
        }
    }


    // OTHER
    public static function random(String $str = '', int $length = 10) {
        try {
            $seed = match($str) {
                'char' => str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),
                'numb' => str_split('0123456789'),
                'numbwize' => str_split('123456789'),
                'pass' => str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+[{]}|;:,<.>?'),
                'spec' => str_split('`~!@#$%^&*()-_=+[{]}\'\"|;:,<.>/?/'),
                'combwisp' => str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'),
                default => str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789`~!@#$%^&*()-_=+[{]}\'\"|;:,<.>/?/')
            };

            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $rand = '';
            foreach (array_rand($seed, $length) as $k) {
                $rand .= $seed[$k];
            }
            return $rand;
        }
        catch(Exception $e) {
            echo "function randNumber() Error: ".$e;
        }
    }

    // QR AND BARCODE
    public static function QRCode($path, $kode, $cp, $matrixPointSize) {
        //QR code

        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'qrcard'.DIRECTORY_SEPARATOR;
        //$PNG_WEB_DIR = 'qrcard/'.$memberid.'/';

        $errorCorrectionLevel = 'H';
        //$matrixPointSize = 500;

        //$kode = '1000100010001004';
        $filename = $path.$kode.'.png';
        if (!file_exists($filename)){
            QRcode::png($cp, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        }

        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        $resource = 'data:image/png;base64,'.base64_encode($generator->getBarcode($kode, $generator::TYPE_CODE_128));
    }

    public static function QRCipher($cardno) {
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($cardno, $cipher, '70007000', $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, '70007000', $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        return $ciphertext;
    }
}
?>
