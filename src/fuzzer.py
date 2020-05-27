import sys
from parser import parse_args
from post_requests import make_post_requests


def main():
    """
    Main routine of the fuzzer.

    """
    args = parse_args(sys.argv[1:])

    make_post_requests(args.param, args.url, args.codes)


if __name__ == '__main__':
    main()
