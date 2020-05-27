import requests

MY_URL = ""
PARAM = {}


def download_all_sites_post(codes):
    for c in codes:
        global PARAM
        PARAM['username'] = c
        resp = requests.post(MY_URL,PARAM)
        print("status ", resp.status_code, " --- ", len(resp.content), " bytes --- using string: ", c, "\n")


def make_post_requests(param, url, codes):
    
    global PARAM
    PARAM = {"username":"", "password":"password", "action":"login"}

    global MY_URL
    MY_URL = url

    download_all_sites_post(codes)
    
