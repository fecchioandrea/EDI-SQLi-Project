import requests

MY_URL = ""
PARAM = {}


def download_all_post(codes):
    user_key = None
    for key in PARAM.keys():
        if key.__contains__("user"):
            user_key = key
            break

    if user_key is not None:
        PARAM[user_key] = "random"
        first_try_resp = requests.post(MY_URL, PARAM, allow_redirects=False)
        nominal_size = len(first_try_resp.content)

        for c in codes:
            PARAM[user_key] = c
            resp = requests.post(MY_URL, PARAM, allow_redirects=False)
            resp_length = len(resp.content)
            print("status ", resp.status_code, " --- ", resp_length, " bytes --- using string: ", c,
                  " --- RESPONSE:")
            if (resp_length != nominal_size and resp_length > 0):
                print(resp.content, "\n\n\n\n")
            else:
                print(" - Nothing interesting... \n\n")



def make_post_requests(form, codes):
    global PARAM
    PARAM = {}
    for input_field in form.get("input_fields"):
        key = input_field.get("name")
        value = input_field.get("value")
        PARAM[key] = value

    global MY_URL
    MY_URL = form.get("action")

    download_all_post(codes)
