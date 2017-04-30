import os
import sys
from PIL import Image
import csv


x = int(sys.argv[1])
y = int(sys.argv[2])


data_dir = "data/gs/MOD14A1_E_FIRE/"
out_dir = "data/processed_e/"
out_file = str(x)+"x"+str(y)+".csv"

if(os.path.exists(out_dir+out_file)):
	sys.exit(1)

file_list = os.listdir(data_dir)
file_list.sort()

fire_csv = "\"Date\",\"Incident\"";
total = 0

for file_name in file_list:

	if(file_name.find(".PNG") == -1):
		continue

	with Image.open(data_dir+file_name) as im:

		pix = im.load()
		width, height = im.size
		fire_data = pix[x,y]
		total = total + fire_data
		if(fire_data == 255):
			total = total - 255
			continue

		fire_date = file_name.replace("MOD14A1_E_FIRE_", "")
		fire_date = fire_date.replace(".PNG", "")

		fire_csv = fire_csv + "\n" + "\"" + fire_date + "\",%d" % fire_data

if(total == 0):
	print("Data Not Found")
	sys.exit(1)

with open(out_dir+out_file, 'w') as csv_file:
	csv_file.write(fire_csv)






