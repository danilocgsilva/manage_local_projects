from manproject.ProjectConfig import ProjectConfig
from manproject.Project import Project
from manproject.Sync import Sync
from manproject.functions import show_all_data_from_project, to_working_dir, deploy, change

commands_bag = {

    'add': {
        'help': 'Adds a new project.',
        'requires_argument': False,
        'command': lambda *args: ProjectConfig().add()
    },
    'list': {
        'help': "Lists all projects recorded.",
        'requires_argument': False,
        'command': lambda *args: ProjectConfig().list()
    },
    'delete': {
        'help': "Remove a project.",
        'requires_argument': True,
        'command': lambda *args: ProjectConfig().remove(args[0])
    },
    'to_storage': {
        'help': 'Pass code from working dir to storage place.',
        'requires_argument': True,
        'command': lambda *args: Sync(Project(args[0])).to_storage()
    },
    'to_working': {
        'help': 'Pass code from storage place to working dir. Needs a seconf argument beign the project name.',
        'requires_argument': True,
        'command': lambda *args: to_working_dir(args[0])
    },
    'show_working': {
        'help': 'Types the working directory. Requires the project name as second parameter.',
        'requires_argument': True,
        'command': lambda *args: print(Project(args[0]).get_working_dir())
    },
    'show_storage': {
        'help': 'Types the storage place address. Requires the project name as second parameter.',
        'requires_argument': True,
        'command': lambda *args: print(Project(args[0]).get_storage_dir())
    },
    'show_infos': {
        'help': 'Show all informations about a project',
        'requires_argument': True,
        'command': lambda *args: show_all_data_from_project(args[0])
    },
    'deploy': {
        'help': 'Send work to production place.',
        'requires_argument': True,
        'command': lambda *args: deploy(args[0])
    },
    'alter': {
        'help': 'Change data for project',
        'requires_argument': True,
        'command': lambda *args: change(args[0])
    },
    'add_env': {
        'help': 'Alters the enrvironment data from a project, inserting a new environment.',
        'requires_argument': True,
        'command': lambda *args: add_env(args[0])
    }
}