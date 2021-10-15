import requests
import json
import serial
import time

arduino = serial.Serial(port='/dev/ttyACM0', baudrate=9600, timeout=0.1) // puerto esrial donde esta conectado el arduino en SO ubuntu
arduino.setDTR(False)
arduino.flushInput()
arduino.setDTR(True)

def getFromAPI(): # obtiene el valor de la BD
	url = 'http://url_api'
	headers = {'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36'}
	payload = {'id': '1'}
	r = requests.get(url, headers=headers, params=payload)
	jsonText = json.loads(r.text)[0]['state']
	return jsonText

def setStateAPI(): # si cambia del lado hardware
	url = 'http://url_api/put'
	headers = {'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36'}
	payload = {"id":"1","state":"0"} #cambia dependiendo led
	r = requests.put(url, data=json.dumps(payload), headers=headers)

def readLedState(): # verifica el estado del led
  data = arduino.readline()
  return data #regresar 0/1

def writeLedState(state): # modifica el valor del led
  arduino.write(bytes(state, 'utf-8'))

while True:		
	time.sleep(1.0)
	#print(readLedState())
	writeLedState(getFromAPI())	
