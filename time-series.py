import sys

import pandas as pd
from fbprophet import Prophet

import matplotlib.pyplot as plt
#plt.style.use('fivethirtyeight')

# 1916 x 813
df = pd.read_csv("processed_e/"+sys.argv[1]+"x"+sys.argv[2]+".csv")

df['Date'] = pd.DatetimeIndex(df['Date'])
df = df.rename(columns={'Date': 'ds', 'Incident': 'y'})

#ax = df.set_index('ds').plot(figsize=(100, 8))
#ax.set_ylabel('Daily Number of Incidents')
#ax.set_xlabel('Date')

my_model = Prophet(interval_width=0.95)
my_model.fit(df)

future_dates = my_model.make_future_dataframe(periods=365, freq='D')
forecast = my_model.predict(future_dates)

#my_model.plot(forecast, uncertainty=True)
#plt.show()


mask = (forecast['ds'] > '2017-1-1') & (forecast['ds'] <= '2017-12-31')
num = forecast.loc[mask][['ds','seasonal_lower']]._get_numeric_data()
num[num < 0] = 0

forecast.loc[:,('seasonal_lower')] = num
forecast.loc[mask][['ds','seasonal_lower']].to_csv("predicted/"+sys.argv[1]+"x"+sys.argv[2]+".csv", index = False)
#print(forecast.loc[mask][['ds','seasonal_lower']])

num = forecast.loc[mask][['ds','seasonal_lower']].reset_index()

num.time = pd.to_datetime(num['ds'], format='%Y-%m-%d %H:%M:%S.%f')
num.set_index(['ds'], inplace=True)


ax = num['seasonal_lower'].plot(figsize=(8, 6))
ax.set_xlabel('Days')
ax.set_ylabel('Fire Hazard Risk')

plt.savefig("plots/"+sys.argv[1]+"x"+sys.argv[2]+".png")



