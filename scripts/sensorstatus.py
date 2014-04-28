#!/usr/bin/env python
#requires pySerial to be installed
#use sensorstatus.py -p PORT to receive messages or sensorstatus.py -p PORT -m MESSAGE to send
import serial, time,sys

timeout = 2
baudRate = 9600

from optparse import OptionParser
parser = OptionParser()
parser.add_option("-p", "--port", 
					dest="port", help="the serial port")
parser.add_option("-m", "--message",
					dest="message", help="a message to send")

(options, args) = parser.parse_args()
if not options.port:
	parser.error('port is required')

#open serial port
ser = serial.Serial(options.port, baudRate)
ser.timeout = timeout

if hasattr(options, 'message') and isinstance(options.message, basestring):
	ser.write('status')
else:
	startTime = time.time()
	while (time.time() < startTime + timeout):
		print ser.readline()
		break

#close port
ser.close()
