import sys
from parser import parse_args
from post_requests import make_post_requests


def main():
    """
    Main routine of the fuzzer.

    """
    args = parse_args(sys.argv[1:])

    url = args.url
    make_post_requests(args.param, url, codes)


if __name__ == '__main__':
    main()
