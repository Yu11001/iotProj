#include <WiFi.h>
#include <HTTPClient.h>

#define sensor10PIN 4 // 10 baht
#define sensor5PIN 17 // 5 baht
#define sensor1PIN 18 // 1 baht

// WiFi credentials
const char* ssid = "";
const char* password = "";

const char* serverName = "http://myServer/iot/tcrtsensordataupdate.php";

// 计数和金额变量
int totalSavings = 0;

void setup() {
  Serial.begin(115200);
  
  // 设置引脚模式
  pinMode(sensor1PIN, INPUT);
  pinMode(sensor5PIN, INPUT);
  pinMode(sensor10PIN, INPUT);

  // 连接到Wi-Fi
  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nConnected to WiFi");
}

void loop() {
  // 检查10泰铢传感器
  if (digitalRead(sensor10PIN) == LOW) { // 假设低电平表示硬币经过
    totalSavings += 10;
    sendToDatabase(0, 0, 1, totalSavings);
    delay(1000); // 防止多次触发
  }

  // 检查5泰铢传感器
  if (digitalRead(sensor5PIN) == LOW) {
    totalSavings += 5;
    sendToDatabase(0, 1, 0, totalSavings);
    delay(1000);
  }

  // 检查1泰铢传感器
  if (digitalRead(sensor1PIN) == LOW) {
    totalSavings += 1;
    sendToDatabase(1, 0, 0, totalSavings);
    delay(1000);
  }
}

void sendToDatabase(int b1, int b5, int b10, int total) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    // Prepare URL with sensor data
    String serverPath = String(serverName) + "?b1=" + String(b1) + "&b5=" + String(b5) + "&b10=" + String(b10) + "&total=" + String(total);

    // Send HTTP GET request
    http.begin(serverPath.c_str());
    int httpResponseCode = http.GET();

    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
    } else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    
    // Free resources
    http.end();
  } else {
    Serial.println("WiFi Disconnected");
  }
}
