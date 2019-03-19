import urllib.request, base64

url = "http://mfc.cwb.gov.tw/index.php/ctrl_web_service/regular_product_service/506/num_now_1"
username = "username"
password = "password"

req_url = urllib.request.Request(url, method='GET')
req_auth = base64.b64encode((username + ':' + password).encode('utf-8')).decode('utf-8')
req_url.add_header("Authorization", "Basic " + req_auth)

http = urllib.request.urlopen(req_url)
data = http.read().decode('utf-8')
http.close()
print(data)
