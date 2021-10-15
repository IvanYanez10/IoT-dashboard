char iB = '0';
void setup() {
  Serial.begin(9600);
  pinMode(2, OUTPUT);
  delay(200);
}
void loop() {    
  iB = Serial.read();
  setLed();  
}
void setLed(){
  if(iB == '1' || iB == '0'){
    if(iB == '1')
      digitalWrite(2, HIGH);
    else
      digitalWrite(2, LOW);
    delay(800);
  }else{
    delay(100);
  }  
}
