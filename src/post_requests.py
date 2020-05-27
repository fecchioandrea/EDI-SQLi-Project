import requests

MY_URL = ""
PARAM = ""


def download_all_sites_post(codes, num):
    for c in codes:
        resp = requests.post(MY_URL,c)
        print("status ", resp.status_code, " --- ", len(resp.content), " bytes --- using string: ", c, "\n")


def make_post_requests(param, given_url, codes):
    
    global PARAM
    PARAM = param

    global MY_URL
    MY_URL = given_url

    download_all_sites_post(codes)
