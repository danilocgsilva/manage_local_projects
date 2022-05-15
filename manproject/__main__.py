import sys
from wsgiref import validate
from manproject.commands_bag import commands_bag

def main():
    try:
        execute_command(sys.argv[1])
    except IndexError:
        print("Types the command name. Nothing done.")

def execute_command(command: str):
    
    if command == "help":
        for command in commands_bag:
            print( " * " + command + ": " + commands_bag[command]["help"])

    elif command in commands_bag:
        if (len(sys.argv) > 2):
            argument = sys.argv[2]
        else:
            argument = None

        if validate_command_requirements(commands_bag[command]):
            commands_bag[command]["command"](argument)
        else:
            print("The commands needs an additional argument to be the project name. Eg.: mpro {} <project_name>.".format(command))

    else:
        print("A don't know which is this command.")

def validate_command_requirements(command) -> bool:
    if command["requires_argument"]:
        if len(sys.argv) < 3:
            return False
    return True
