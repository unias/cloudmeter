import json

md = '''string'''

del table(md):
    mdlist = md.split('\n')
    for i in range(len(mdlist)):
        mdlist[i] = mdlist[i].split('|')[1:-1]
    heading = mdlist[0]
    jsonlist = []
    for item in mdlist[2:]:
        ajson = {}
        for i in range(len(heading)):
            ajson[heading[i]] = item[i]
        jsonlist.append(ajson)
    print (json.dumps(jsonlist,ensure_ascii=False))

def 
