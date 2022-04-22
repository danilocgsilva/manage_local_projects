import sys
from manproject.to_storage import to_storage

def main():
    try:
        execute_command(sys.argv[1])
    except IndexError:
        print("Types the command name. Nothing done.")

def execute_command(command: str):
    if command == 'add':
        print("Lets add a project!")
    elif command == 'to_storage':
        to_storage()
    elif command == 'to_working':
        print("Lets send files from storage to working.")
    else:
        print("A don't know which is this command")

