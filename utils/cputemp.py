import subprocess
import json
res = subprocess.run(["sensors"], capture_output=True).stdout.decode('utf-8')
res = res.split('\n')
#print(res)
temps = {}
for l in res:
	if not("Core" in l):
		continue
	ligne = l.strip().split(' ')
	cpu = ligne[0]
	temperature = float(ligne[-1].replace('+','').replace('°C',''))
	if cpu in temps.keys():
		if temps[cpu] < temperature:
			temps[cpu] = temperature
	else:
		temps[cpu] = temperature

print(json.dumps(temps,ensure_ascii=False))
