import requests

MY_URL = ""
PARAM = {}


def download_all_sites_post(codes):
    user_key = None
    for key in PARAM.keys():
        if key.__contains__("user"):
            user_key = key
            break

    if user_key is not None:
        for c in codes:
            PARAM[user_key] = c
            resp = requests.post(MY_URL, PARAM)
            print("status ", resp.status_code, " --- ", len(resp.content), " bytes --- using string: ", c,
                  " --- RESPONSE:")
            print(resp.content, "\n\n\n\n")


def make_post_requests(form, codes):
    global PARAM
    PARAM = {}
    for input_field in form.get("input_fields"):
        key = input_field.get("name")
        value = input_field.get("value")
        PARAM[key] = value

    global MY_URL
    MY_URL = form.get("action")

    download_all_sites_post(codes)
