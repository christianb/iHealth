#include <MeetAndroid.h>
#include <OneWire.h>

// OneWire DS18S20, DS18B20, DS1822 Temperature Example
//
// http://www.pjrc.com/teensy/td_libs_OneWire.html
//
// The DallasTemperature library can do all this work for you!
// http://milesburton.com/Dallas_Temperature_Control_Library

OneWire  ds(10);  // on pin 10
MeetAndroid meetAndroid;

#define rxPin 3
#define txPin 2

int redLED = 8;
const int buttonPin = 2;

// variables will change:
int buttonState = 0;         // variable for reading the pushbutton status


boolean runMeasurement = false;
byte counter = 0;
byte DURATION = 10;
float values[10];

byte NUM_VALUES = 4;


void setup(void) {
  Serial.begin(115200);
  meetAndroid.registerFunction(startMeasurement, 'M');  
  
  pinMode(redLED, OUTPUT);
  digitalWrite(redLED, LOW);
  
  // initialize the pushbutton pin as an input:
  pinMode(buttonPin, INPUT);  
}

void startMeasurement(byte flag, byte numOfValues) {
  runMeasurement = true;
}

void startMeasurementRemote() {
  meetAndroid.send("startMeasurementRemote");
}

void loop(void) {
  meetAndroid.receive();
  
  // read the state of the pushbutton value:
  buttonState = digitalRead(buttonPin);
  
  // check if the pushbutton is pressed.
  // if it is, the buttonState is HIGH:
  if (buttonState == HIGH && runMeasurement == false) {     
    runMeasurement = true;
    //Serial.print("button pressed\n");
    startMeasurementRemote();
  }
  
  
  if (runMeasurement) {
    
    
    byte i;
    byte present = 0;
    byte type_s;
    byte data[12];
    byte addr[8];
    float celsius, fahrenheit;
  
    if ( !ds.search(addr)) {
      //Serial.println("No more addresses.");
      //Serial.println();
      ds.reset_search();
      delay(250);
      return;
    }
  
    //Serial.print("ROM =");
    //for( i = 0; i < 8; i++) {
      //Serial.write(' ');
      //Serial.print(addr[i], HEX);
    //}

    if (OneWire::crc8(addr, 7) != addr[7]) {
        //Serial.println("CRC is not valid!");
        return;
    }
  
    //Serial.println();
 
  // the first ROM byte indicates which chip
  switch (addr[0]) {
    case 0x10:
      //Serial.println("  Chip = DS18S20");  // or old DS1820
      type_s = 1;
      break;
    case 0x28:
      //Serial.println("  Chip = DS18B20");
      type_s = 0;
      break;
    case 0x22:
      //Serial.println("  Chip = DS1822");
      type_s = 0;
      break;
    default:
      //Serial.println("Device is not a DS18x20 family device.");
      return;
  } 

  ds.reset();
  ds.select(addr);
  ds.write(0x44,1);         // start conversion, with parasite power on at the end
  digitalWrite(redLED, LOW);
  delay(250);     // maybe 750ms is enough, maybe not
  digitalWrite(redLED, HIGH);
  delay(500);
  // we might do a ds.depower() here, but the reset will take care of it.
  
  present = ds.reset();
  ds.select(addr);    
  ds.write(0xBE);         // Read Scratchpad

  //Serial.print("  Data = ");
  //Serial.print(present,HEX);
  //Serial.print(" ");
  for ( i = 0; i < 9; i++) {           // we need 9 bytes
    data[i] = ds.read();
    //Serial.print(data[i], HEX);
    //Serial.print(" ");
  }
  //Serial.print(" CRC=");
  //Serial.print(OneWire::crc8(data, 8), HEX);
  //Serial.println();

  // convert the data to actual temperature

  unsigned int raw = (data[1] << 8) | data[0];
  if (type_s) {
    raw = raw << 3; // 9 bit resolution default
    if (data[7] == 0x10) {
      // count remain gives full 12 bit resolution
      raw = (raw & 0xFFF0) + 12 - data[6];
    }
  } else {
    byte cfg = (data[4] & 0x60);
    if (cfg == 0x00) raw = raw << 3;  // 9 bit resolution, 93.75 ms
    else if (cfg == 0x20) raw = raw << 2; // 10 bit res, 187.5 ms
    else if (cfg == 0x40) raw = raw << 1; // 11 bit res, 375 ms
    // default is 12 bit resolution, 750 ms conversion time
  }
  celsius = (float)raw / 16.0;
  fahrenheit = celsius * 1.8 + 32.0;
  /*Serial.print("  Temperature = ");
  Serial.print(celsius);
  Serial.print(" Celsius, ");*/
  //Serial.print(fahrenheit);
  //Serial.println(" Fahrenheit");*/
  
  values[counter++] = celsius;
  if (counter == DURATION) {
    
    //Serial.print("Measurement Done.");
    
    float average_temp = 0;
    // Berechne Durchschnitt auf den letzten fünf Werten
    for (int i = 1; i <= NUM_VALUES; i++) {
      /*Serial.print("values[");
      Serial.print(DURATION-i);
      Serial.print("] = ");
      Serial.println(values[DURATION-i]);*/
      average_temp += values[DURATION-i];
    }
    
    average_temp /= NUM_VALUES;
    
    //byte average_temp = (values[55] + values[56] + values[57] + values [DURATION] + values[DURATION-1]) / 5;
    //Serial.print("Average Temperature = ");
    //Serial.println(average_temp);
    
    
    runMeasurement = false;
    counter = 0;
    
    //Serial.flush();
    meetAndroid.send((float) average_temp);
    }
  } else {
    //Serial.print("Warte auf Anfrage...\n");
    delay(100);
    digitalWrite(redLED, LOW);
  }
  
}


