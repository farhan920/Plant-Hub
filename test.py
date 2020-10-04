#!/usr/bin/python3

import serial
import time
import json
import requests

if __name__ == "__main__":
    ser = serial.Serial('/dev/ttyACM0',9600,timeout=1)
    ser.flush()
    
    # constant loop
    while True:
        try:
            if ser.in_waiting > 0:
                # data in from the arduino
                unodata = ser.readline().decode('utf-8').rstrip()
                try:
                    unodata = json.loads(unodata)
                    print(unodata)
                    uri = "http://planthub.trevortech.net/post.php"
                    r = requests.post(url = uri, data = unodata)
                    response = json.loads(r.text)
                    print(response)
                    ser.write(response['uno'].encode('utf-8'))
                except:
                    print(unodata)
        except:
            print('error')
            
            #{"success": "true", "uno": "0,2.1"}
            #0,0 -- no valves open
            #2.1,0 -- open valve 1 for 2.1 seconds
            #0,2.5 -- open value 2 for 2.5 seconds
            
            
            