#include <DallasTemperature.h>
#include <OneWire.h>


#define waterPhPin A5          //pH meter Analog output to Arduino Analog Input 0
#define airTempPin A3
#define Offset 0.00         //deviation compensate
#define samplingInterval 20
#define printInterval 30000
#define ArrayLenth  40  //times of collection
#define ONE_WIRE_BUS 4  // Data wire For Temp Probe is plugged into pin 4 on the Arduino
int pHArray[ArrayLenth];   //Store the average value of the sensor feedback
int pHArrayIndex=0;

int R1= 1000;
int Ra=25; //Resistance of powering Pins
int ECPin= A0;
int ECGround=A1;
int ECPower =A4;
float PPMconversion=0.5;

//*************Compensating for temperature ************************************//
float TemperatureCoef = 0.019;

//********************** Cell Constant For Ec Measurements *********************//
float K=2.88;

OneWire oneWire(ONE_WIRE_BUS);// Setup a oneWire instance to communicate with any OneWire devices
DallasTemperature sensors(&oneWire);// Pass our oneWire reference to Dallas Temperature.
 
 

float EC=0;
float EC25 =0;
int ppm =0;
 
 
float raw= 0;
float Vin= 5;
float Vdrop= 0;
float Rc= 0;
float buffer=0;

// variable for opening valves
double open1 = 0;
double open2 = 0;

// vars
double waterPh = 0;
float waterTemp = 0;
double airTemAavg = 0;
double ppmAvg = 0;
double waterPhAvg = 0;
double waterTempAvg = 0;


void setup() { 
  Serial.begin(9600);

  pinMode(ECPin,INPUT);
  pinMode(ECPower,OUTPUT);//Setting pin for sourcing current
  pinMode(ECGround,OUTPUT);//setting pin for sinking current
 
  digitalWrite(ECGround,LOW);//We can leave the ground connected permanantly
 
  delay(100);// gives sensor time to settle
  sensors.begin();
  delay(100);
  //** Adding Digital Pin Resistance to [25 ohm] to the static Resistor *********//
  // Consule Read-Me for Why, or just accept it as true
  R1=(R1+Ra);// Taking into acount Powering Pin Resitance
 
}

double avergearray(int* arr, int number){
  int i;
  int max,min;
  double avg;
  long amount=0;
  if(number<5){   //less than 5, calculated directly statistics
  for(i=0;i<number;i++){
    amount+=arr[i];
  }
  avg = amount/number;
  return avg;
  }else{
  if(arr[0]<arr[1]){
    min = arr[0];max=arr[1];
  }
  else{
    min=arr[1];max=arr[0];
  }
  for(i=2;i<number;i++){
    if(arr[i]<min){
      amount+=min;      //arr<min
      min=arr[i];
    }else {
      if(arr[i]>max){
        amount+=max;  //arr>max
        max=arr[i];
      }else{
        amount+=arr[i]; //min<=arr<=max
      }
    }//if
  }//for
  avg = (double)amount/(number-2);
  }//if
  return avg;
}


void openValve(int valveId, double sec) {
  if (valveId == 1) {
    digitalWrite(8, HIGH);
  }
  if (valveId == 2) {
    digitalWrite(9, HIGH);
  }
  int del = sec*1000;
  delay(del);
  //Serial.println(valveId);
  //Serial.println(del);
  digitalWrite(8, LOW);
  digitalWrite(9, LOW);
}

void loop(void) {
  static unsigned long samplingTime = millis();
  static unsigned long printTime = millis();
  static float pHValue,voltage;
  if(millis()-samplingTime > samplingInterval) {
      pHArray[pHArrayIndex++]=analogRead(waterPhPin);
      if(pHArrayIndex==ArrayLenth)pHArrayIndex=0;
      voltage = avergearray(pHArray, ArrayLenth)*5.0/1024;
      pHValue = 5.0*voltage+Offset;
      samplingTime=millis();
  }
  
  if(millis() - printTime > printInterval) {
    //Serial.println("SEND");
    double airTemp = analogRead(airTempPin);
    airTemp = airTemp / 1024;
    airTemp = airTemp * 4.78;
    airTemp = airTemp - 0.5;
    airTemp = airTemp * 100;
    float waterPhFinal = pHValue;
    
    Serial.println((String)"{\"airtemp\":\"" + airTemp + (String)"\", \"ppm\":\"" + ppm + (String)"\", \"watertemp\": \"" + waterTemp + (String)"\", \"waterph\":\"" + waterPhFinal + (String)"\"}");
    GetEC();
    printTime=millis();
  

  }


  // serial read
  if (Serial.available() > 0) {
    String data = Serial.readStringUntil('\n');
    //Serial.println(data);
    open1 = data.substring(0, 4).toDouble();
    open2 = data.substring(6,10).toDouble();
    openValve(1, open1);
    openValve(2, open2);
    //Serial.println(open1);
    //Serial.println(open2);
  }
}

void GetEC(){
  // get water temp
  sensors.requestTemperatures();// Send the command to get temperatures
  waterTemp=sensors.getTempCByIndex(0); //Stores Value in Variable
   
   
   
   
  //************Estimates Resistance of Liquid ****************//
  digitalWrite(ECPower,HIGH);
  raw= analogRead(ECPin);
  raw= analogRead(ECPin);// This is not a mistake, First reading will be low beause if charged a capacitor
  digitalWrite(ECPower,LOW);
 
 
 
 
//***************** Converts to EC **************************//

Vdrop= (Vin*raw)/1024.0;
Rc=(Vdrop*R1)/(Vin-Vdrop);
Rc=Rc-Ra; //acounting for Digital Pin Resitance
EC = 1000/(Rc*K);

 
 
//*************Compensating For Temperaure********************//
EC25  =  EC/ (1+ TemperatureCoef*(waterTemp-25.0));
ppm=(EC25)*(PPMconversion*1000);
 
 
};
//************************** End OF EC Function ***************************//
 
