import sys
from manproject.Sync import Sync
from manproject.Env import Env

def main():
    try:
        execute_command(sys.argv[1])
    except IndexError:
        print("Types the command name. Nothing done.")

def execute_command(command: str):
    if command == 'add':
        print("Lets add a project!")
    elif command in ['to_storage', 'to_working', 'show_working', 'show_storage']:
        env_works(command)
    else:
        print("A don't know which is this command")

def env_works(command):
    env = Env()
    if command == 'to_storage':
        sync = Sync(env)
        sync.to_storage()
    elif command == 'to_working':
        sync = Sync(env)
        sync.to_working()
    elif command == 'show_working':
        env.get_working_dir()
    elif command == 'show_storage':
        env.get_working_dir()

