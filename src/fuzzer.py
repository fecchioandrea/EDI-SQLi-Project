import sys
from parser import parse_args
from post_requests import make_post_requests


def build_list(file):
    """
        Build the Python list with the codes to be used as payloads, starting
        from one or more text file(s) (like "bypass1.txt") in which codes are listed.
        Args:
            files       -- list of inputfiles
        Local Variables:
            a_file      -- one of the multiple files as input
        Returns:
            codes       -- list of codes to be used
    """
    codes = []
    f_open = open(file, "r")
    lines = f_open.readlines()
    f_open.close()
    for line in lines:
        codes.append(line.replace("\n", ""))

    return codes


def main():
    """
    Main routine of the fuzzer.

    """
    args = parse_args(sys.argv[1:])
    codes = build_list(args.filelist)
    make_post_requests(args.param, args.url, codes)


if __name__ == '__main__':
    main()
