import sys
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
        if (len(sys.argv) > 2):
            argument = sys.argv[2]
        else:
            argument = None
        commands_bag[command]["command"](argument)

    else:
        print("A don't know which is this command.")

    
