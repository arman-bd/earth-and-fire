import os
import sys
from PIL import Image
import csv

data_dir = "../fire_data_e/"
out_dir = "processed_e/"
file_list = os.listdir(data_dir)
file_list.sort()
x = int(sys.argv[1])
y = int(sys.argv[2])

fire_csv = "\"Date\",\"Incident\"";


for file_name in file_list:

	with Image.open(data_dir+file_name) as im:

		pix = im.load()
		width, height = im.size
		fire_data = pix[x,y]
		if(fire_data == 255):
			continue

		fire_date = file_name.replace("MOD14A1_E_FIRE_", "")
		fire_date = fire_date.replace(".PNG", "")

		fire_csv = fire_csv + "\n" + "\"" + fire_date + "\",%d" % fire_data

with open(out_dir+str(x)+"x"+str(y)+".csv", 'w') as csv_file:
	csv_file.write(fire_csv)






