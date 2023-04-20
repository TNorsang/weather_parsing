import sys
import xml.dom.minidom
import mysql.connector

fileName = sys.argv[1]

doc = xml.dom.minidom.parse(fileName)

divs = doc.getElementsByTagName("div")
stateAndCity = []
Day = []
Time = []
Temperature = []
shortDes = []
longDes = []


currentTemp = ""

# <div class="pull-left" id="current_conditions-summary">
#                         <img class="pull-left" src="newimages/large/nsct.png" alt=""></img>
#                         <p class="myforecast-current">Fair</p>
#             <p class="myforecast-current-lrg">51&#176;F</p>
#             <p class="myforecast-current-sm">11&#176;C</p>
#         </div>

for div in divs:
    if div.hasAttribute("id") and div.getAttribute("id") == "current_conditions-summary":
        # find the p tag with the class "myforecast-current-lrg"
        ps = div.getElementsByTagName("p")
        for p in ps:
            if p.hasAttribute("class") and p.getAttribute("class") == "myforecast-current-lrg":
                # get the value of the p tag
                currentTemp = p.firstChild.nodeValue          

hazard = ""
alla = doc.getElementsByTagName("a")
for a in alla:
    if a.hasAttribute("class") and "anchor-hazards" in a.getAttribute("class"):
        hazard = "Hazardous Weather Conditions"
        for childofa in a.childNodes:
            if childofa.nodeType == childofa.TEXT_NODE and childofa.nodeValue != "":
                hazard += "," + childofa.nodeValue 

if (hazard != ""):
    print(hazard.split(",")[0])
    print(hazard.split(",")[1])


def getCityAndState():
    for div in divs:
        if div.hasAttribute('class') and 'current-conditions-extra' in div.getAttribute('class'):
            a_elements = div.getElementsByTagName('a')[0]
            stateAndCity = a_elements.getAttribute('title')
            return stateAndCity

date = fileName[:10]

def populateForecast():
    for div in divs:
        if div.hasAttribute("class") and "tombstone-container" in div.getAttribute("class"):
            for childofdiv_p in div.getElementsByTagName("p"):
                if childofdiv_p.hasAttribute('class') and 'period-name' in childofdiv_p.getAttribute('class'):
                    DayTime = ""
                    for childofp in childofdiv_p.childNodes:
                        if childofp.nodeType == childofp.TEXT_NODE and childofp.nodeValue != "":
                            DayTime += childofp.nodeValue + " "
                    DT = DayTime.split()
                    if (len(DT) == 2):
                        Day.append(DT[0])
                        Time.append(DT[1])
                    elif (len(DT) == 1):
                        Day.append(DT[0])
                        Time.append("") 
                if childofdiv_p.hasAttribute('class') and 'short-desc' in childofdiv_p.getAttribute('class'):
                    fullText = ""
                    for childofp in childofdiv_p.childNodes:
                        if childofp.nodeType == childofp.TEXT_NODE and childofp.nodeValue != "":
                            fullText += childofp.nodeValue + " "
                    shortDes.append(fullText)
                if childofdiv_p.hasAttribute('class') and ('temp temp-low' in childofdiv_p.getAttribute('class') or 'temp temp-high' in childofdiv_p.getAttribute('class')):
                    fullText2 = ""
                    for childofp in childofdiv_p.childNodes:
                        if childofp.nodeType == childofp.TEXT_NODE and childofp.nodeValue != "":
                            fullText2 += childofp.nodeValue
                    Temperature.append(fullText2)       
  
    for div in divs:
        if div.hasAttribute("class") and ("row row-even row-forecast" in div.getAttribute("class")  or  "row row-odd row-forecast" in div.getAttribute("class")):
            longDes.append([])
            for childofdiv_div in div.childNodes:
                if childofdiv_div.hasAttribute('class') and ('col-sm-2 forecast-label' in childofdiv_div.getAttribute('class')):
                    for childofp in childofdiv_div.childNodes:
                        for c in childofp.childNodes:
                            if c.nodeType == c.TEXT_NODE and c.nodeValue != "":
                                longDes[-1].append(c.nodeValue) 
                if childofdiv_div.hasAttribute('class') and ('col-sm-10 forecast-text' in childofdiv_div.getAttribute('class')):
                    for childofp in childofdiv_div.childNodes:
                        if childofp.nodeType == childofp.TEXT_NODE and childofp.nodeValue != "":
                            longDes[-1].append(childofp.nodeValue)
          
populateForecast()

city, state = getCityAndState().split(", ")

def insert(cursor):
    query = f"delete from weather where state = '{state}';"
    cursor.execute(query, ())

    query = 'INSERT INTO weather(state, city, date, day, temperature, short_description, long_description, hazard) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s);'
    cursor.execute(query, (state, city, "", "", currentTemp, "", "",hazard))

    query = 'INSERT INTO weather(state, city, date, day, temperature, short_description, long_description, hazard) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s);'
    cursor.execute(query, (state, city, "", "", currentTemp, "", "", hazard))

    for i in range(len(longDes)):
        if i < len(Day):
            query = 'INSERT INTO weather(state, city, date, day, temperature, short_description, long_description, hazard) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s);'
            cursor.execute(query, (state, city, Day[i], Time[i], Temperature[i], shortDes[i], longDes[i][1],hazard))
            # print(f"{Day[i]} {Time[i]} is {Temperature[i]} ({shortDes[i]} | {longDes[i][1]})")
        else:
            da = ""
            ta = ""
            l = longDes[i][0].split()
            if len(l) == 1:
                da = l[0]
            else:
                da = l[0]
                ta = l[1]

            query = 'INSERT INTO weather(state, city, date, day, temperature, short_description, long_description) VALUES ( %s, %s, %s, %s, %s, %s, %s);'
            cursor.execute(query, ( state, city, da, ta , "", '', longDes[i][1]))

# def update(cursor):
#     query = 'UPDATE weather SET date = %s, day = %s, temperature = %s, short_description = %s, long_description = %s WHERE id = %s;'
#     cursor.execute(query, ('2023-02-22', 'Saturday', high, 'Partly Cloudy', 'Sunny intervals with occasional cloudy spells', id))

try:
    cnx = mysql.connector.connect(host='localhost', user='root', password='weather', database='main', auth_plugin='mysql_native_password')
    cursor = cnx.cursor()

    # select_query = 'SELECT * FROM weather WHERE id = %s'
    # cursor.execute(select_query, (id,))
    # row = cursor.fetchone()

    # if row:
    #     update(cursor)
    #     cnx.commit()
    # else:
    #     insert(cursor)
    #     cnx.commit()
    insert(cursor)
    cnx.commit()
    
    cursor.close()
except mysql.connector.Error as err:
    print(err)
finally:
    try:
        cnx
    except NameError:
        pass
    else:
        cnx.close()
