# Earth and Fire
Project Earth &amp; Fire for NASA Space Apps Challenge 2017

![Earth and Fire](https://raw.githubusercontent.com/arman-bd/earth-and-fire/master/dist/img/header-logo.png)

Earth and Fire is an advanced mobile application that has the capability to forecast the natural fire hazard rate for any given geolocation at any given future time. It also has a feature for getting help from the public and sending out notifications, and it can do time series analysis on data from NASA's earth observation missions.

![Earth and Fire](https://raw.githubusercontent.com/arman-bd/earth-and-fire/master/earth-and-fire.png)

At one time, the ancient Greeks thought that fire was one of the four most important things in the universe. In one of the Greek myths, Prometheus is described as stealing fire from the gods to save the lives of otherwise defenseless humans. However, he was punished for his act of kindness. That is not the case, and we have now demonstrated that. However, we cannot deny that fire is one of the inventions that has allowed our civilization to progress to this point. There are hints of this amazing scientific phenomenon everywhere, from simple home cooking to advanced rocket science. But like every other blessing of nature, it also has its curses. According to a study, wildfires, peat fires, and controlled burns on farming lands are responsible for the deaths of 339,000 people worldwide each year. An article in Scientific American says that large wildfires can easily cause more than a billion dollars worth of damage.

Because so many people died and so much property was destroyed, we decided to create a smart system that could predict the risk of natural fires using the best computing algorithm. Our research led us to NASA Earth Observation (NEO) global Active Fire Data. We find that data helpful for our project.
After locating the appropriate data set, we started the analysis process. We use Python, a programming language, to get data from the grayscale satellite image that NASA gave us. This data is then fed into a forecast model for the next 12 months. For the application, we are making predictions about the risk of wildfires in 2017 based on data collected by NASA Earth Observations from 2000 through 2016.

![Earth and Fire](https://raw.githubusercontent.com/arman-bd/earth-and-fire/master/app-screenshot.png)

In addition, we have incorporated a crowdsourcing component into our application. This feature lets users tell Earth & Fire directly from their device about possible fire hazards. Once the information has been verified, Earth & Fire will also alert other users in the area. Also, there is an Application Program Interface that the government and researchers can use to get information about active fires worldwide.

## Used Resources:
* NEO Active Fire Data (8 Days)
* NASA FIRMS Data (Daily)
* Prophet
* Google Maps API
* Cesium JS

We had to change some parts of the original plan for the project because we didn't have enough computing power. More processing power is required to make more accurate and specific predictions.
