&lt;?php
require("vendor/autoload.php");
 
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
 
require("phpMQTT.php");
 
$mqtt = new phpMQTT("hairdresser.cloudmqtt.com", 16093, "phpMQTT Pub Nodemcu"); //เปลี่ยน www.yourmqttserver.com ไปที่ mqtt server ที่เราสมัครไว้นะครับ
 
$token = "PrEXTPeWFFBKhqPxCjRz1+tKJ76bSTmkKkzVE3UwSBcMedaupGVzEWZGffy/j6iUanH2mt+jri8nLCtOgX8QTZCRD7fmo1QIIIwZ0ikCt7bwbUx6pm7GPxPQt8UNFKbuqEZfp364rzhmKQvRZVgsFAdB04t89/1O/w1cDnyilFU="; //นำ token ที่มาจาก line developer account ของเรามาใส่ครับ
 
$httpClient = new CurlHTTPClient($token);
$bot = new LINEBot($httpClient, ['channelSecret' =&gt; $token]);
// webhook
$jsonStr = file_get_contents('php://input');
$jsonObj = json_decode($jsonStr);
print_r($jsonStr);
foreach ($jsonObj-&gt;events as $event) {
if('message' == $event-&gt;type){
// debug
//file_put_contents("message.json", json_encode($event));
$text = $event-&gt;message-&gt;text;
 
if (preg_match("/สวัสดี/", $text)) {
$text = "มีอะไรให้จ่าวิสรับใช้ครับ";
}
 
if (preg_match("/เปิดทีวี/", $text)) {     //หากในแชตที่ส่งมามีคำว่า เปิดทีวี ก็ให้ส่ง mqtt ไปแจ้ง server เราครับ
if ($mqtt-&gt;connect()) {
$mqtt-&gt;publish("/ESP32","TV"); // ตัวอย่างคำสั่งเปิดทีวีที่จะส่งไปยัง mqtt server
$mqtt-&gt;close();
}
$text = "เปิดทีวีให้แล้วคร้าบบบบ";
}
if (preg_match("/ปิดทีวี/", $text) and !preg_match("/เปิดทีวี/", $text)) {
if ($mqtt-&gt;connect()) {
$mqtt-&gt;publish("/ESP32","TV");
$mqtt-&gt;close();
}
$text = "จ่าปิดทีวีให้แล้วนะครับ!!";
}
$response = $bot-&gt;replyText($event-&gt;replyToken, $text); // ส่งคำ reply กลับไปยัง line application
 
}
}
 
?&gt;