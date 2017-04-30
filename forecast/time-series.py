import sys
import os.path
import matplotlib as mpl
mpl.use('Agg')

import pandas as pd
from fbprophet import Prophet

import matplotlib.pyplot as plt
#plt.style.use('fivethirtyeight')

in_dir_csv = "data/processed_e/"
out_dir_csv = "data/predicted/"
out_dir_plot = "plots/"

x = int(sys.argv[1])
y = int(sys.argv[2])

in_csv = str(x)+"x"+str(y)+".csv"
out_csv = str(x)+"x"+str(y)+".csv"
out_plot = str(x)+"x"+str(y)+".png"

if(os.path.exists(in_dir_csv+in_csv) == False):
	print("Data Not Found")
	sys.exit(1)

#if(os.path.exists(out_dir_csv+out_csv) == True):
	#sys.exit(1)

# 1916 x 813
df = pd.read_csv(in_dir_csv+in_csv)

df['Date'] = pd.DatetimeIndex(df['Date'])
df = df.rename(columns={'Date': 'ds', 'Incident': 'y'})

#ax = df.set_index('ds').plot(figsize=(100, 8))
#ax.set_ylabel('Daily Number of Incidents')
#ax.set_xlabel('Date')

my_model = Prophet(interval_width=0.95)
my_model.fit(df)

future_dates = my_model.make_future_dataframe(periods=52, freq='W')
forecast = my_model.predict(future_dates)

#my_model.plot(forecast, uncertainty=True)
#plt.show()


mask = (forecast['ds'] > '2017-1-1') & (forecast['ds'] <= '2017-12-31')
num = forecast.loc[mask][['ds','seasonal_lower']]._get_numeric_data()

#decimals = pd.Series([2], index=['seasonal_lower'])
num[num < 0] = 0
num[num > 0] = num / 255 * 100
num[num > 255] = 255

forecast.loc[:,('seasonal_lower')] = num
forecast.loc[mask][['ds','seasonal_lower']].round(2).to_csv(out_dir_csv+out_csv, index = False)
#print(forecast.loc[mask][['ds','seasonal_lower']])

num = forecast.loc[mask][['ds','seasonal_lower']].reset_index()

num.time = pd.to_datetime(num['ds'], format='%Y-%m-%d')
num.set_index(['ds'], inplace=True)


ax = num['seasonal_lower'].plot(figsize=(6, 4))
ax.set_xlabel('Days')
ax.set_ylabel('Fire Hazard Risk')
ax.set_ylim([0, 100])

plt.savefig(out_dir_plot+out_plot)
