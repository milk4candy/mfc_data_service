#! /usr/bin/python

import urllib2, base64

req = urllib2.Request("http://mfc.cwb.gov.tw/index.php/ctrl_web_service/regular_product_service/506/num_now_1/rsort_by_filename")
req.add_header("Authorization", "Basic " + base64.encodestring("username:password"))
http = urllib2.urlopen(req)
data = http.read()
http.close()
print data
exit
