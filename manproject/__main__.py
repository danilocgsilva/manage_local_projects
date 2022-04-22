import sys
from manproject.Sync import Sync

def main():
    try:
        execute_command(sys.argv[1])
    except IndexError:
        print("Types the command name. Nothing done.")

def execute_command(command: str):
    if command == 'add':
        print("Lets add a project!")
    elif command == 'to_storage':
        sync = Sync()
        sync.to_storage()
    elif command == 'to_working':
        sync = Sync()
        sync.to_working()
    else:
        print("A don't know which is this command")

