import sys
from manproject.Sync import Sync
from manproject.Env import Env
from manproject.AddProject import AddProject
from manproject.commands_bag import commands_bag

def main():
    try:
        execute_command(sys.argv[1])
    except IndexError:
        print("Types the command name. Nothing done.")

def execute_command(command: str):
    if command == "help":
        for command in commands_bag:
            print(command + ": " + commands_bag[command]["help"])
    elif command in commands_bag:
        commands_bag[command]["command"]()
    else:
        print("A don't know which is this command")

    
