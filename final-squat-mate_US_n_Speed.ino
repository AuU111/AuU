#include <I2Cdev.h>
#include <SPI.h>
#include <Ethernet.h>
#include <Servo.h> 
#include <Wire.h>
#define echoPin 2 // attach pin D2 Arduino to pin Echo of HC-SR04
#define trigPin 3 //attach pin D3 Arduino to pin Trig of HC-SR04
// defines variables
long duration; // variable for the duration of sound wave travel
int distance; // variable for the distance measurement
long fastness;
long lastDistance;
long beforelastDistance;
long totalDistance;
int tempCounter;

long loop_timer;
long temp = 200;
long lastTemp;

// Enter a MAC address for your controller below.
// Newer Ethernet shields have a MAC address printed on a sticker on the shield
byte mac[] = { 0x28, 0xAD, 0xBE, 0xEF, 0xB9, 0xED };
int result;
// if you don't want to use DNS (and reduce your sketch size)
// use the numeric IP instead of the name for the server:
//IPAddress server(74,125,232,128);  // numeric IP for Google (no DNS)
char server[] = "youevenlift.net";    // name address for Google (using DNS)

// Set the static IP address to use if the DHCP fails to assign
//IPAddress ip(192, 168, 1, 177);
IPAddress ip(10, 199, 57, 177);


// Initialize the Ethernet client library
// with the IP address and port of the server
// that you want to connect to (port 80 is default for HTTP):
EthernetClient client;

void setup() {
  // Open serial communications and wait for port to open:
  Serial.begin(9600);
  pinMode(4, OUTPUT);
  digitalWrite(4, HIGH);
  while (!Serial) {
    ; // wait for serial port to connect. Needed for native USB port only
  }

  // start the Ethernet connection:
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    // try to congifure using IP address instead of DHCP:
    Ethernet.begin(mac, ip);
  }
  // give the Ethernet shield a second to initialize:

  Serial.println("connecting...");
  delay(2000);
  Serial.println(Ethernet.localIP());

  writeData();

  pinMode(trigPin, OUTPUT); // Sets the trigPin as an OUTPUT
  pinMode(echoPin, INPUT); // Sets the echoPin as an INPUT
  Serial.println("Ultrasonic Sensor HC-SR04 Test"); // print some text in Serial Monitor
  Serial.println("with Arduino UNO R3");
}

void loop() {

    checkClient();

}


void checkClient() {

  // if there are incoming bytes available
  // from the server, read them and print them:
  if (client.available()) {

    runSensor();

//if (lastDistance < 100) {
//    if (distance > lastDistance) {
        writeData();     
//    }
//}
  }

  // if the server's disconnected, stop the client:
  if (!client.connected()) {
    Serial.println();
    Serial.println("disconnecting.");
    client.stop();

    // do nothing forevermore:
    while (true);
  }
}


void writeData() {

  // if you get a connection, report back via serial:
  if (result = client.connect(server, 80)) {
//    Serial.print(result);
    Serial.println();
    Serial.println();
    Serial.println("connected, about to writeData()");
    // Make a HTTP request:
    client.print("GET /add_hc-sr04.php?sensor1=");
    client.print(lastTemp);
    client.print("&sensor2=");
    client.print(fastness);
    client.println(" HTTP/1.1");
    client.println("Host: www.youevenlift.net");
    client.println("Connection: close");
    client.println();
  } else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
}


void runSensor() {

  // Clears the trigPin condition
  digitalWrite(trigPin, LOW);
  delayMicroseconds(1);
  // Sets the trigPin HIGH (ACTIVE) for 10 microseconds
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(5);
  digitalWrite(trigPin, LOW);
  // Reads the echoPin, returns the sound wave travel time in microseconds
  duration = pulseIn(echoPin, HIGH);
  // Calculating the distance
  beforelastDistance = lastDistance;
  lastDistance = distance;
  distance = duration * 0.034 / 2; // Speed of sound wave divided by 2 (go and back)
  fastness = (distance-lastDistance) * duration * 0.001;
  // Displays on the Serial Monitor
  Serial.print("Distance: ");
  Serial.print(distance);
  Serial.println(" cm");
  Serial.print("Speed: ");
  Serial.print(fastness);
  Serial.println(" m/s");
  Serial.println("------------------------------");
  
  lastTemp = temp;
  temp = distance;
}
