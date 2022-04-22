import sys
from manproject.to_storage import sync

def execute_command(command: str):
    if command == 'add':
        print("Lets add a project!")
    else:
        print("A don't know which is this command")

def main():
    try:
        execute_command(sys.argv[1])
    except IndexError:
        sync()
