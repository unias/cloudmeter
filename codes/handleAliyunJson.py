# -*- coding=utf-8 -*-

import json

def getKey(x):
    s = x["实例规格"]
    l = len(s)
    if s[-6:] == "xlarge":
        return str(l) + s[7:-6]
    else:
        return str(l)

data = {}
with open('../datas/aliyun_instancePrice_all.json', 'r') as f:
    data = json.load(f)

pricingInfo = data["pricingInfo"]
jsonlist = []
for key in pricingInfo:
    keys = key.split("::")
    instanceId = keys[1]
    if keys[1].split('.')[1] == "hfg5" and keys[0] == "cn-beijing" and keys[3] == "linux": 
        value = pricingInfo[key]
        t = {}
        t["实例规格"] = instanceId
        t["hour"] = value["hours"][0]['price']
        t["week"] = value["weeks"][0]['price']
        for i in range(5):
            t['year'+str(i)] = value["years"][i]['price']
        jsonlist.append(t)
jsonlist.sort(key=getKey)
print(json.dumps(jsonlist,ensure_ascii=False))

