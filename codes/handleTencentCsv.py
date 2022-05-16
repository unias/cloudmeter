# -*- coding=utf-8 -*-

import json

jsonlist = []
with open('../datas/tencent_cloud_price_shanghai_all.csv', 'r') as f:
    heading = f.readline().split(',')
    for line in f.readlines():
        line = line.split(',')[:-1]
        if not line[0][-2:] == 'I2':
            continue
        t = {}
        for i in range(len(line)):
            t[heading[i]] = line[i]
        jsonlist.append(t)

print (json.dumps(jsonlist, ensure_ascii=False))