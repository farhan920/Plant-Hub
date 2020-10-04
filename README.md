The North Avenue Traders Present…..


PlantHub























The North Avenue Traders:
Eric Gustafson
Trevor Honeycutt
Luke Duarte
Farhan Virani
Alex Tyler
Overview:
The North Avenue Traders have come together to create an automated hydroponic garden run by an Arduino Uno and a Raspberry Pi with a web server that displays relevant variables.

Software:
The web app was created HTML and Javascript for the front-end, and PHP for the backend. The Arduino was programmed with the Arduino coding language and the Raspberry Pi was programmed with Python.

Hardware:
Arduino Uno
Raspberry Pi
Arduino Analog pH sensor
Arduino Conductivity Sensor
Arduino Liquid Temperature Sensor
24W LED Grow Lights
Two12inch, 12V Plastic Water Solenoid Valve
Two 10k Ohm Resistors
Two IRF520 Mosfets
Two 1k Ohm Resistors
Two 1N4007 Diodes
One 9V battery

Project Description:
## Inspiration
Our inspiration originated from wanting to automate something that could be sustainable and work on throughout the semester. It would be a collaborative effort between everyone in our apartment that could be continuously added to as we learn more and more from the project.

## What it does
Our plants are in three solo cups that are filled with pebbles; at the bottoms of the cups, there are holes for the roots of the plants to permeate the cup and touch the nutrient solution in the bottom of the container. The plants need to be in a solution of a pH of 5.5 so there is a pH sensor submerged in the solution to detect the pH level and 9,500 ppm of nutrient concentration. Our Arduino receives this data and sends it to the Raspberry Pi which then uploads the data to a webserver to display the equilibrium values and their history; the webserver can be found here. The web server calculates if there needs to be automated changes such as letting in more liquid from the plastic water bottles on top of the entire frame. One of these bottles will hold a diluted acidic solution (so that the pH of the container can be controlled) and more nutrient solution.

## How we built it
We used the Invention Studio's woodshop to build a frame to hold the plants, nutrient solution, water, sensors, and circuits. The table and miter saw were used to cut the wood and the drills to put screws in the wooden boards to fasten them. We took a plastic box and used the drill press to cut circular holes of different radii. We used an Exacto knife to cut square holes to put the four pillars to hold the top wooden board. This top wooden board supports the solenoid valves and water bottles holding the nutrient and acidic solution. We used epoxy to connect the vinyl tubing to the solenoid valves as well as connecting the solenoid valves to the water bottles holding the solutions. On the software side, we used an Arduino microcontroller to automate the garden. We have a pH, temperature, and conductivity sensor submerged in the nutrient solution in the white container that the plants are also submerged in. The Arduino receives this data and sends it to a Raspberry Pi which sends data through wifi to a web server (http://planthub.trevortech.net/). The web server holds the equations for the flow rate of the water bottle-valve system and the time that the valves are open. It serves as the interface in which we can modify the equations used and how long the valves are to be open. This data is then sent back to the Raspberry Pi and then to the Arduino, and if the pH goes above 6.5 or the ppm value goes below 5000 ppm, then the solenoid valve opens for 10 seconds.

## Challenges we ran into
Some of the challenges we ran into include finding the correct power distribution to the sensors, microcontrollers, and solenoid valves, finding the right supplies that aren't too expensive, serial communication between the web server and the Raspberry Pi whilst having that data to be sent and received at the same rate, having the vinyl tubing be waterproof and tightly secured to the solenoid valves, and calibrating the sensors.

## Accomplishments that we're proud of
We're proud of being able to have two microcontrollers talk to each other (Arduino Uno and Raspberry Pi). We're also proud of all that we've learned in the areas of circuit analysis, product prototyping, web app development, and coding. The entire project is also low-cost. We wanted to make sure that this is something that could be cost-efficient, so many things we got donated from home depot as scrap or wooden materials that were scrap from the woodshop in the studio.

## What we learned
We each got to indulge more in areas that we were not comfortable with. For example, Luke Durate knows how to code but didn't know how to create a web server. Alex Tyler knew circuit analysis but not necessarily how to translate it to a breadboard as well as how transistors work. Eric Gustafson knew how to operate the tools in the Invention Studio but not really what their applications were or their minute details. 



## What's next for PlantHub
Our next steps are adding water level sensors as well as more accurate equations to monitor the flow rate of the solenoid valves. We need to also go about creating covers for the microcontrollers and breadboards so that they don't get wet and ruin the circuitry.
