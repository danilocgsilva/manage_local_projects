from manproject.Env import Env

class Sync:

    def __init__(self, env: Env):
        self.env = env

    def to_storage(self):
        os_command = "rsync -rv " + self.env.get_working_dir() + " " + self.env.get_storage_dir()
        os.system(os_command)
        
    def to_working(self):
        os_command = "rsync -rv " + self.env.get_storage_dir() + " " + self.env.get_working_dir()
        os.system(os_command)
