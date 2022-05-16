# -*- coding=utf-8 -*-

import json

heading = []
jsonlist = []

with open('temporarydata.txt', 'r') as f:
    for i in range(8):
        heading.append(f.readline().strip())
    i = 0
    t = {}
    for line in f.readlines():
        index = i % 8
        if i > 0 and index == 0:
            t = {}
            jsonlist.append(t)
        t[heading[index]] = line.strip()
        i = i + 1
    jsonlist.append(t)

print(json.dumps(jsonlist, ensure_ascii=False))