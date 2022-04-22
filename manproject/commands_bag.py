from manproject.AddProject import AddProject
from manproject.Env import Env
from manproject.Sync import Sync

commands_bag = {

    'add': {
        'help': 'Adds a new project.',
        'command': lambda: 
            AddProject().add()
    },
    'to_storage': {
        'help': 'Pass code from working dir to storage place.',
        'command': lambda: 
            Sync(Env()).to_storage()
    },
    'to_working': {
        'help': 'Pass code from storage place to working dir.',
        'command': lambda: 
            Sync(Env()).to_working()
    },
    'show_working': {
        'help': 'Types the working directory.',
        'command': lambda:
            print(Env().get_working_dir())
    },
    'show_storage': {
        'help': 'Types the storage place address.',
        'command':
            lambda: print(Env().get_storage_dir())
    }
}