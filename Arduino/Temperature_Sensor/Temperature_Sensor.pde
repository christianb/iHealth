#include <NewSoftSerial.h>


/*
  Receives Test Events from your phone.
  After it gets a test message the led 13 will blink
  for one second.
*/
 
#include <MeetAndroid.h>

MeetAndroid meetAndroid;
int onboardLed = 13;

#define rxPin 3
#define txPin 2

//int greenLED = 12;
//int redLED = 8;

//boolean isCall = false;
//NewSoftSerial mySerial(rxPin, txPin);


void setup()  
{
  
  //Serial.print('t');
  // use the baud rate your bluetooth module is configured to 
  // not all baud rates are working well, i.e. ATMEGA168 works best with 57600
  Serial.begin(115200); 
  
  // register callback functions, which will be called when an associated event occurs.
  // - the first parameter is the name of your function (see below)
  // - match the second parameter ('A', 'B', 'a', etc...) with the flag on your Android application
  meetAndroid.registerFunction(startMeasurement, 'M');  

  //pinMode(onboardLed, OUTPUT);
  //digitalWrite(onboardLed, HIGH);

  //pinMode(redLED, OUTPUT);
  //digitalWrite(redLED, LOW);
  
  //pinMode(greenLED, OUTPUT);
  //digitalWrite(greenLED, HIGH);
  
}

void loop() {
  meetAndroid.receive(); // you need to keep this in your loop() to receive events
  /*
  if (isCall == true) {
   digitalWrite(redLED, HIGH);
   digitalWrite(greenLED, LOW);
   delay(200); 
   digitalWrite(redLED, LOW);
   delay(200);
  }
  
  if (isCall == false) {
    digitalWrite(greenLED, HIGH);
  }
  */
}

/*
 * This method is called constantly.
 * note: flag is in this case 'A' and numOfValues is 0 (since test event doesn't send any data)
 *
void testEvent(byte flag, byte numOfValues)
{
  //flushLed(300);
  //flushLed(300);
  int val = meetAndroid.getInt();
  meetAndroid.getFloat();
  meetAndroid.getDouble();
  if (val == 100) {
    isCall = true;
  } else { isCall = false;}
  
  
  //Serial.print('A');
  Serial.print(val, DEC);
  Serial.print('\n');
}*/

void startMeasurement(byte flag, byte numOfValues) {
  //Serial.print("Call startMeasurement()");
  sendTemperature(37);
}

void sendTemperature(int pTemperature) {
  meetAndroid.send(pTemperature);
}
/*
void flushLed(int time)
{
  digitalWrite(onboardLed, LOW);
  delay(time);
  digitalWrite(onboardLed, HIGH);
  delay(time);
}*/

