"""
Module useful in doing POST requests

"""

import requests

MY_URL = ""
#PARAM = {}
PARAM = ""


"""
def download_site_post(code):
    """
        Makes the POST request for every single code
            and prints data in a formatted way.

        Args:
            code        -- the code to be used in the request

    """
    with requests.post(MY_URL, PARAM) as response:
        print('{:30s} {:40s} {:90s}'.format(f'Read {len(response.content)} bytes with POST',
                                            f'using code: {code}',
                                            f'giving status: {response.status_code}')
              )
"""


def download_all_sites_post(codes, num):
    """
        Initialises a ThreadPoolExecutor in order to make
            more asyncronous POST requests.

        Args:
            codes       -- list of codes

    """
    for c in codes:
        resp = requests.post(MY_URL,c)
        print("status ", resp.status_code, " --- ", len(resp.content), " bytes --- using string: ", c, "\n")


def make_post_requests(param, given_url, codes):
    """
        Initialises the POST requests.

        Args:
            data            -- the dictionary with parameters
            given_url       -- the url given in the command-line
            codes           -- the list of codes to try
            num             -- the max number of threads to be used
    """
    #data = split_data(data)

    global PARAM
    #PARAM = {data[0]: data[1]}
    PARAM = param

    global MY_URL
    MY_URL = given_url

    download_all_sites_post(codes)
