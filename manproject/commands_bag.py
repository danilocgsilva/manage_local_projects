from manproject.ProjectConfig import ProjectConfig
from manproject.Project import Project
from manproject.Sync import Sync

commands_bag = {

    'add': {
        'help': 'Adds a new project.',
        'command': lambda *args: 
            ProjectConfig().add()
    },
    'delete': {
        'help': "Remove a project.",
        'command': lambda *args:
            ProjectConfig().remove(args[0])
    },
    'list': {
        'help': "Lists all projects recorded.",
        'command': lambda *args:
            ProjectConfig().list()
    },
    'to_storage': {
        'help': 'Pass code from working dir to storage place.',
        'command': lambda *args: 
            Sync(Project(args[0])).to_storage()
    },
    'to_working': {
        'help': 'Pass code from storage place to working dir.',
        'command': lambda *args: 
            Sync(Project(args[0])).to_working()
    },
    'show_working': {
        'help': 'Types the working directory. Requires the project name as second parameter.',
        'command': lambda *args:
            print(Project(args[0]).get_working_dir())
    },
    'show_storage': {
        'help': 'Types the storage place address. Requires the project name as second parameter.',
        'command':
            lambda *args:
                print(Project(args[0]).get_storage_dir())
    }
}