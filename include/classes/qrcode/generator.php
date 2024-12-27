<?php
include 'phpqrcode/qrlib.php';

class QR_Generator {

    public static function generate($content) {
        $filename = $content.'.png';
        // QRcode::png($content, $filename);
        QRcode::png("192.168.1.5/demo/qr/", '18S00013.png', 4, 4, TRUE);  
        

        $data = file_get_contents($filename);

        // unlink($filename);
        // QRcode::png($content, $filename, 4, 4, TRUE);  
        return base64_encode($data);

    }
    public static function generate_wifi($ssid, $password) {
        $wifi = "WIFI:T:WPA;S:" . $ssid . ";P:" . $password . ";;";

        return self::generate($wifi,'wifi');
    }
}
// if ('text' == 'text') {
//     exit(QR_Generator::generate($rs[0]));
// }else if ($_POST['type'] == 'wifi') {
//     exit(QR_Generator::generate_wifi($_POST['data1'],$_POST['data2']));
// }
// else {
//     header($_SERVER['SERVER_PROTOCOL'] . ' 400 Unknown request');
// }