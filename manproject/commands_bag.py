from manproject.ProjectConfig import ProjectConfig

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
            Sync(Env()).to_storage()
    },
    'to_working': {
        'help': 'Pass code from storage place to working dir.',
        'command': lambda *args: 
            Sync(Env()).to_working()
    },
    'show_working': {
        'help': 'Types the working directory.',
        'command': lambda *args:
            print(Env().get_working_dir())
    },
    'show_storage': {
        'help': 'Types the storage place address.',
        'command':
            lambda *args:
                print(Env().get_storage_dir())
    }
}